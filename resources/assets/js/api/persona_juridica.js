import {
  obtener,
  guardar,
  actualizar,
  eliminar,
  restaurar
} from '../services/api';
import { RUTA_PERSONAS_JURIDICAS, SUFIJO_RESTAURAR } from './rutas_api';
import { crearNotification } from '../services/api/servicio_mensajes';

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
  obtener(id, parametros = {}) {
    return obtener(
      `${RUTA_PERSONAS_JURIDICAS}/${id}`,
      parametros,
      MENSAJES.OBTENER
    );
  },

  guardar(juridica) {
    return guardar(RUTA_PERSONAS_JURIDICAS, juridica, MENSAJES.GUARDAR);
  },

  actualizar(id, juridica) {
    return actualizar(
      `${RUTA_PERSONAS_JURIDICAS}/${id}`,
      juridica,
      MENSAJES.ACTUALIZAR
    );
  },

  darDeBaja(id) {
    return eliminar(`${RUTA_PERSONAS_JURIDICAS}/${id}`, MENSAJES.ELIMINAR);
  },

  darDeAlta(id) {
    return restaurar(
      `${RUTA_PERSONAS_JURIDICAS}/${id}/${SUFIJO_RESTAURAR}`,
      MENSAJES.RESTAURAR
    );
  }
};

export default apiPersonaJuridica;
