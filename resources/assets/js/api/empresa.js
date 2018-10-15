import { obtener, guardar, actualizar } from '../services/api';
import { RUTA_EMPRESAS } from './rutas_api';
import { crearNotification } from '../services/api/servicio_mensajes';

const NO_ENCONTRADO = {
  noEncontrado: crearNotification('No encontrada', 'La empresa no existe')
};

const MENSAJES = {
  OBTENER_EMPRESAS: {
    error: {
      porDefecto: crearNotification('Error', 'No se pudo traer las empresas')
    }
  },

  OBTENER_EMPRESA: {
    error: {
      porDefecto: crearNotification(
        'Error',
        'No se pudo traer los datos de la empresa'
      ),
      ...NO_ENCONTRADO
    }
  },

  GUARDAR: {
    exito: {
      porDefecto: crearNotification('Guardada')
    },
    error: {
      porDefecto: crearNotification('Error', 'No se pudo crear la empresa')
    }
  },

  ACTUALIZAR: {
    exito: {
      porDefecto: crearNotification('Actualizada')
    },
    error: {
      ...NO_ENCONTRADO
    }
  },

  ELIMINAR: {
    exito: {
      porDefecto: crearNotification('Eliminada')
    },
    error: {
      ...NO_ENCONTRADO
    }
  },

  RESTAURAR: {
    exito: {
      porDefecto: crearNotification('Restaurada')
    },
    error: {
      ...NO_ENCONTRADO
    }
  }
};

export function obtenerEmpresas(parametros = {}) {
  const PARAMETROS_POR_DEFECTO = {
    busqueda: null,
    limite: 10,
    pagina: 1,
    ordenarPor: 'nombre_fantasia',
    ascendente: 1,
    soloEliminados: 0
  };

  const CONDICIONES = { ...PARAMETROS_POR_DEFECTO, ...parametros };

  return obtener(RUTA_EMPRESAS, CONDICIONES, MENSAJES.OBTENER_EMPRESAS);
}

export function guardarEmpresa(empresa) {
  return guardar(RUTA_EMPRESAS, empresa, MENSAJES.GUARDAR);
}

export function actualizarEmpresa(id, empresa) {
  return actualizar(`${RUTA_EMPRESAS}/${id}`, empresa, MENSAJES.ACTUALIZAR);
}

export default {
  obtenerEmpresas,
  guardarEmpresa,
  actualizarEmpresa
};
