import Vue from 'vue';
import Vuex from 'vuex';

import { MODULO_NOTIFICACIONES, MODULO_JURIDICAS } from './tipos_modulos';

import notificaciones from './modules/modulo_notificaciones';
import juridicas from './modules/modulo_juridicas';

Vue.use(Vuex);

const store = new Vuex.Store({
  modules: {
    [MODULO_NOTIFICACIONES]: notificaciones,
    [MODULO_JURIDICAS]: juridicas
  }
});

export default store;
