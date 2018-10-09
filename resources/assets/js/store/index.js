import Vue from 'vue';
import Vuex from 'vuex';

import { MODULO_NOTIFICACIONES } from './tipos_modulos';

import notificaciones from './modules/modulo_notificaciones';

Vue.use(Vuex);

const store = new Vuex.Store({
  modules: {
    [MODULO_NOTIFICACIONES]: notificaciones
  }
});

export default store;
