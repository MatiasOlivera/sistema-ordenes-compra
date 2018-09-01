import api from '../servicio_api';
import { rutaPersonaJuridica as ruta } from '../rutas_api';
import { crearNotification } from '../servicio_mensajes';

const NO_ENCONTRADO = {
  noEncontrado: crearNotification(
    'No encontrada',
    'La persona jurídica no existe'
  )
};

const MENSAJES = {
  OBTENER: {
    error: {
      porDefecto: crearNotification(
        'Error',
        'No se pudo traer los datos de la persona jurídica'
      ),
      ...NO_ENCONTRADO
    }
  },

  GUARDAR: {
    exito: {
      porDefecto: crearNotification('Guardada')
    },
    error: {
      porDefecto: crearNotification(
        'Error',
        'No se pudo crear la persona jurídica'
      )
    }
  },

  ACTUALIZAR: {
    exito: {
      porDefecto: crearNotification('Actualizada')
    },
    error: {
      porDefecto: crearNotification(
        'Error',
        'No se pudo actualizar los datos de la persona jurídica'
      ),
      ...NO_ENCONTRADO
    }
  },

  ELIMINAR: {
    exito: {
      porDefecto: crearNotification('Eliminada')
    },
    error: {
      porDefecto: crearNotification(
        'Error',
        'No se pudo dar de baja a la persona jurídica'
      ),
      ...NO_ENCONTRADO
    }
  },

  RESTAURAR: {
    exito: {
      porDefecto: crearNotification('Restaurada')
    },
    error: {
      porDefecto: crearNotification(
        'Error',
        'No se pudo dar de alta a la persona jurídica'
      ),
      ...NO_ENCONTRADO
    }
  }
};

const apiPersonaJuridica = {
  obtener(id) {
    const RUTA = ruta.especifica(id);
    return api.obtener(RUTA, MENSAJES.OBTENER);
  },

  guardar(juridica) {
    return api.guardar(ruta.base, juridica, MENSAJES.GUARDAR);
  },

  actualizar(id, juridica) {
    const RUTA = ruta.especifica(id);
    return api.actualizar(RUTA, juridica, MENSAJES.ACTUALIZAR);
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

export default apiPersonaJuridica;
