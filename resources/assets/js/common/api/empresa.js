import { guardar, actualizar } from '../servicio_api';
import { RUTA_EMPRESAS } from '../rutas_api';
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
    return guardar(RUTA_EMPRESAS, empresa, MENSAJES.GUARDAR);
  },

  actualizar(id, empresa) {
    return actualizar(`${RUTA_EMPRESAS}/${id}`, empresa, MENSAJES.ACTUALIZAR);
  }
};

export default apiEmpresa;
