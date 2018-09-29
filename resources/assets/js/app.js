import Vue from 'vue';
import VueNotifications from 'vue-notifications';
import { ServerTable } from 'vue-tables-2';

import App from './App.vue';
import router from './router';

// Configuraciones
import {
  NOTIFICACION_TIMEOUT,
  TIPOS_DE_NOTIFICACION
} from './config/vue-notifications';
import {
  TABLA_OPCIONES,
  TABLA_USAR_VUEX,
  TABLA_TEMA,
  TABLA_PLANTILLA
} from './config/vue-tables-2';
require('./libraries');

// Vue-notifications
VueNotifications.config.timeout = NOTIFICACION_TIMEOUT;
Vue.use(VueNotifications, TIPOS_DE_NOTIFICACION);

// Vue-tables-2
Vue.use(
  ServerTable,
  TABLA_OPCIONES,
  TABLA_USAR_VUEX,
  TABLA_TEMA,
  TABLA_PLANTILLA
);

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  components: { App },
  template: '<App/>'
});
