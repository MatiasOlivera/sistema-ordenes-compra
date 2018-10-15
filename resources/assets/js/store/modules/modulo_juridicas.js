import api from '../../api/persona_juridica';
import apiPersonaJuridicaEmpresa from '../../api/persona_juridica_empresa';
import {
  CREAR_JURIDICA,
  OBTENER_JURIDICA,
  ACTUALIZAR_JURIDICA,
  ELIMINAR_JURIDICA,
  RESTAURAR_JURIDICA,
  ASOCIAR_JURIDICA_EMPRESA,
  DESASOCIAR_JURIDICA_EMPRESA
} from '../tipos_acciones';
import { ESTABLECER_JURIDICA } from '../tipos_mutaciones';
import { manejadorNotificacion } from './modulo_notificaciones';

const JURIDICA_POR_DEFECTO = {
  id: null,
  denominacion: '',
  cuit: null,
  tipo_organizacion_id: null,
  created_at: null,
  updated_at: null,
  deleted_at: null,
  tipo_organizacion: {
    id: null,
    descripcion: '',
    created_at: null,
    updated_at: null,
    deleted_at: null
  },
  empresas: []
};

const namespaced = true;

const state = {
  juridica: { ...JURIDICA_POR_DEFECTO }
};

const actions = {
  [CREAR_JURIDICA](contexto, juridica) {
    return api
      .guardar(juridica)
      .then(manejadorNotificacion)
      .catch((error) => {
        manejadorNotificacion(error);
        throw error.validacion;
      });
  },

  [OBTENER_JURIDICA]({ commit }, id) {
    return api
      .obtener(id)
      .then(({ data }) => {
        commit(ESTABLECER_JURIDICA, data);
      })
      .catch(manejadorNotificacion);
  },

  [ACTUALIZAR_JURIDICA]({ dispatch }, { id, juridica }) {
    return api
      .actualizar(id, juridica)
      .then((respuesta) => {
        manejadorNotificacion(respuesta);
        dispatch(OBTENER_JURIDICA, id);
      })
      .catch((error) => {
        manejadorNotificacion(error);
        throw error.validacion;
      });
  },

  [ELIMINAR_JURIDICA]({ dispatch }, id) {
    return api
      .darDeBaja(id)
      .then((respuesta) => {
        manejadorNotificacion(respuesta);
        dispatch(OBTENER_JURIDICA, id);
      })
      .catch(manejadorNotificacion);
  },

  [RESTAURAR_JURIDICA]({ dispatch }, id) {
    return api
      .darDeAlta(id)
      .then((respuesta) => {
        manejadorNotificacion(respuesta);
        dispatch(OBTENER_JURIDICA, id);
      })
      .catch(manejadorNotificacion);
  },

  [ASOCIAR_JURIDICA_EMPRESA]({ dispatch }, { idJuridica, idEmpresa }) {
    return apiPersonaJuridicaEmpresa
      .asociar(idJuridica, idEmpresa)
      .then((respuesta) => {
        manejadorNotificacion(respuesta);
        dispatch(OBTENER_JURIDICA, idJuridica);
      })
      .catch(manejadorNotificacion);
  },

  [DESASOCIAR_JURIDICA_EMPRESA]({ dispatch }, { idJuridica, idEmpresa }) {
    return apiPersonaJuridicaEmpresa
      .desasociar(idJuridica, idEmpresa)
      .then((respuesta) => {
        manejadorNotificacion(respuesta);
        dispatch(OBTENER_JURIDICA, idJuridica);
      })
      .catch(manejadorNotificacion);
  }
};

/* eslint-disable no-param-reassign */
const mutations = {
  [ESTABLECER_JURIDICA](estado, juridica) {
    estado.juridica = juridica;
  }
};

export default {
  namespaced,
  state,
  actions,
  mutations
};
