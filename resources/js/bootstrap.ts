declare global {
    interface Window {
        axios: typeof axios;
        Laravel: {csrfToken: string}
    }
}

/**
 * We'll load the axios HTTP library, which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
import { axios } from "@/services/axios";
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Set X-CSRF-TOKEN header with the CSRF token from the meta tag
const csrfTokenMeta = document.head.querySelector('meta[name="csrf-token"]');

// Verificar se o elemento foi encontrado e tem a propriedade 'content'
const csrfToken = csrfTokenMeta?.getAttribute('content');

// Usar o valor do CSRF token, se disponível
if (csrfToken) {
  axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
/**
 * Uncomment the following block if you are using Laravel Echo and Pusher
 */
// import Echo from 'laravel-echo';
// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });
