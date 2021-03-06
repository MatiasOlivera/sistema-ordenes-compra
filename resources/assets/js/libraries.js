window._ = require('lodash');
window.Popper = require('popper.js').default;

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

const jQuery = require('jquery');

window.$ = jQuery;
window.jQuery = jQuery;
require('bootstrap');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

const TOKEN = document.head.querySelector('meta[name="csrf-token"]');

if (TOKEN) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = TOKEN.content;
}

window.axios.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response) {
      const STATUS = error.response.status;

      switch (STATUS) {
        /**
         * Redireccionar a inicio cuando se termina la sesión del usuario
         */
        case 401:
          window.location.replace('/');
          break;

        /**
         * Recargar la página cuando el token X-CSRF-TOKEN es inválido
         * https://laravel.com/docs/5.6/csrf
         */
        case 419:
          window.location.reload();
          break;

        case 422:
          if (
            Object.prototype.hasOwnProperty.call(error.response.data, 'errors')
          ) {
            const errores = error.response.data.errors;
            const MENSAJES = _.mapValues(errores, (mensaje) => mensaje[0]);
            error.response.data.errors = MENSAJES;
          }
          break;

        default:
      }

      return Promise.reject(error);
    }
    return Promise.reject();
  }
);

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
