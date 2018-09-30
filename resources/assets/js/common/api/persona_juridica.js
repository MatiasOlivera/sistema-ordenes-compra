import api from '../servicio_api';
import { RUTA_PERSONAS_JURIDICAS, SUFIJO_RESTAURAR } from '../rutas_api';
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
    return api.obtener(`${RUTA_PERSONAS_JURIDICAS}/${id}`, MENSAJES.OBTENER);
  },

  guardar(juridica) {
    return api.guardar(RUTA_PERSONAS_JURIDICAS, juridica, MENSAJES.GUARDAR);
  },

  actualizar(id, juridica) {
    return api.actualizar(
      `${RUTA_PERSONAS_JURIDICAS}/${id}`,
      juridica,
      MENSAJES.ACTUALIZAR
    );
  },

  darDeBaja(id) {
    return api.eliminar(`${RUTA_PERSONAS_JURIDICAS}/${id}`, MENSAJES.ELIMINAR);
  },

  darDeAlta(id) {
    return api.restaurar(
      `${RUTA_PERSONAS_JURIDICAS}/${id}`,
      MENSAJES.RESTAURAR
    );
  }
};

export default apiPersonaJuridica;
