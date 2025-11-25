import './bootstrap';

/* Axios */
// Si las siguientes líneas ya están en './bootstrap', puedes comentarlas o eliminarlas:
// import axios from 'axios';
// window.axios = axios;
// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Laravel Echo + Reverb
 */
import Pusher from 'pusher-js';
window.Pusher = Pusher;

import Echo from "laravel-echo";

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: false,
    encrypted: false,
});

// Código permanente para escuchar el evento y mostrar la alerta:
// Canal corregido a 'prueba-reverb' para que coincida con tu Evento PHP
window.Echo.channel('prueba-reverb') 
    .listen('PruebaReverb', (e) => { // 'PruebaReverb' es el nombre de tu evento
        console.log('¡Mensaje recibido desde Laravel Tinker!', e);
        alert('¡Mensaje recibido: ' + e.message); // Muestra un pop-up simple
    });

