import api from '../servicio_api';
import { rutaEmpresa as ruta } from '../rutas_api';
import { crearNotification } from '../servicio_mensajes';

const NO_ENCONTRADO = {
  noEncontrado: crearNotification('No encontrada', 'La empresa no existe')
};

const MENSAJES = {
  OBTENER: {
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

const apiEmpresa = {
  guardar(empresa) {
    return api.guardar(ruta.base, empresa, MENSAJES.GUARDAR);
  },

  actualizar(id, empresa) {
    const RUTA = ruta.especifica(id);
    return api.actualizar(RUTA, empresa, MENSAJES.ACTUALIZAR);
  }
};

export default apiEmpresa;
