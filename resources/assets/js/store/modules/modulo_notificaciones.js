import store from '../index';
import { MODULO_NOTIFICACIONES } from '../tipos_modulos';
import { CREAR_NOTIFICACION } from '../tipos_acciones';
import {
  AGREGAR_NOTIFICACION,
  ELIMINAR_NOTIFICACION
} from '../tipos_mutaciones';

const CANTIDAD_MAXIMA = 5;

const namespaced = true;

const state = {
  notificaciones: []
};

const getters = {
  cantidad: (estado) => estado.notificaciones.length,

  ultima: (estado, { cantidad }) => {
    if (cantidad === 0) {
      return null;
    }
    return estado.notificaciones[cantidad - 1];
  }
};

const actions = {
  /* eslint-disable no-shadow */
  [CREAR_NOTIFICACION]({ commit, getters }, notificacion) {
    commit(AGREGAR_NOTIFICACION, notificacion);

    if (getters.cantidad > CANTIDAD_MAXIMA) {
      commit(ELIMINAR_NOTIFICACION);
    }
  }
};

/* eslint-disable no-param-reassign */
const mutations = {
  [AGREGAR_NOTIFICACION](estado, notificacion) {
    estado.notificaciones.push(notificacion);
  },

  [ELIMINAR_NOTIFICACION](estado) {
    estado.notificaciones.shift();
  }
};

export function manejadorNotificacion({ notificacion }, almacen = store) {
  const crearNotificacion = `${MODULO_NOTIFICACIONES}/${CREAR_NOTIFICACION}`;

  if (notificacion) {
    almacen.dispatch(crearNotificacion, notificacion, { root: true });
  }
}

export default {
  namespaced,
  state,
  getters,
  actions,
  mutations
};
