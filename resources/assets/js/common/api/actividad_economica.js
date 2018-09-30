import api from '../servicio_api';
import { RUTA_ACTIVIDADES_ECONOMICAS, SUFIJO_RESTAURAR } from '../rutas_api';
import { crearNotification } from '../servicio_mensajes';

const NO_ENCONTRADO = {
  noEncontrado: crearNotification('No encontrado', 'El rubro no existe')
};

const MENSAJES = {
  OBTENER: {
    error: {
      porDefecto: crearNotification(
        'Error',
        'No se pudo traer los datos del rubro'
      ),
      ...NO_ENCONTRADO
    }
  },

  GUARDAR: {
    exito: {
      porDefecto: crearNotification('Guardado')
    },
    error: {
      porDefecto: crearNotification('Error', 'No se pudo crear el rubro')
    }
  },

  ACTUALIZAR: {
    exito: {
      porDefecto: crearNotification('Actualizado')
    },
    error: {
      ...NO_ENCONTRADO
    }
  },

  ELIMINAR: {
    exito: {
      porDefecto: crearNotification('Eliminado')
    },
    error: {
      ...NO_ENCONTRADO
    }
  },

  RESTAURAR: {
    exito: {
      porDefecto: crearNotification('Restaurado')
    },
    error: {
      ...NO_ENCONTRADO
    }
  }
};

const apiActividad = {
  obtener(id) {
    return api.obtener(
      `${RUTA_ACTIVIDADES_ECONOMICAS}/${id}`,
      MENSAJES.OBTENER
    );
  },

  guardar(actividad) {
    return api.guardar(
      RUTA_ACTIVIDADES_ECONOMICAS,
      actividad,
      MENSAJES.GUARDAR
    );
  },

  actualizar(id, actividad) {
    return api.actualizar(
      `${RUTA_ACTIVIDADES_ECONOMICAS}/${id}`,
      actividad,
      MENSAJES.ACTUALIZAR
    );
  },

  darDeBaja(id) {
    return api.eliminar(
      `${RUTA_ACTIVIDADES_ECONOMICAS}/${id}`,
      MENSAJES.ELIMINAR
    );
  },

  darDeAlta(id) {
    return api.restaurar(
      `${RUTA_ACTIVIDADES_ECONOMICAS}/${id}/${SUFIJO_RESTAURAR}`,
      MENSAJES.RESTAURAR
    );
  }
};

export default apiActividad;
