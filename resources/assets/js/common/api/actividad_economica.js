import api from '../servicio_api';
import { rutaActividad as ruta } from '../rutas_api';
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
    const RUTA = ruta.especifica(id);
    return api.obtener(RUTA, MENSAJES.OBTENER);
  },

  guardar(actividad) {
    return api.guardar(ruta.base, actividad, MENSAJES.GUARDAR);
  },

  actualizar(id, actividad) {
    const RUTA = ruta.especifica(id);
    return api.actualizar(RUTA, actividad, MENSAJES.ACTUALIZAR);
  },

  darDeBaja(id) {
    const RUTA = ruta.especifica(id);
    return api.eliminar(RUTA, MENSAJES.ELIMINAR);
  },

  darDeAlta(id) {
    const RUTA = ruta.alta(id);
    return api.restaurar(RUTA, MENSAJES.RESTAURAR);
  }
};

export default apiActividad;
