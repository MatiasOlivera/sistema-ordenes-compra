import {
  obtener,
  guardar,
  actualizar,
  eliminar,
  restaurar
} from '../services/api';
import { RUTA_TIPOS_DE_ORGANIZACIONES, SUFIJO_RESTAURAR } from './rutas_api';
import { crearNotification } from '../services/api/servicio_mensajes';

const NO_ENCONTRADO = {
  noEncontrado: crearNotification(
    'No encontrado',
    'El tipo de organización no existe'
  )
};

const MENSAJES = {
  OBTENER: {
    error: {
      porDefecto: crearNotification(
        'Error',
        'No se pudo traer los datos del tipo de organización'
      ),
      ...NO_ENCONTRADO
    }
  },

  GUARDAR: {
    exito: {
      porDefecto: crearNotification('Guardado')
    },
    error: {
      porDefecto: crearNotification(
        'Error',
        'No se pudo crear el tipo de organización'
      )
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

const apiTipoOrganizacion = {
  obtener(id, parametros = {}) {
    return obtener(
      `${RUTA_TIPOS_DE_ORGANIZACIONES}/${id}`,
      parametros,
      MENSAJES.OBTENER
    );
  },

  guardar(tipo) {
    return guardar(RUTA_TIPOS_DE_ORGANIZACIONES, tipo, MENSAJES.GUARDAR);
  },

  actualizar(id, tipo) {
    return actualizar(
      `${RUTA_TIPOS_DE_ORGANIZACIONES}/${id}`,
      tipo,
      MENSAJES.ACTUALIZAR
    );
  },

  darDeBaja(id) {
    return eliminar(`${RUTA_TIPOS_DE_ORGANIZACIONES}/${id}`, MENSAJES.ELIMINAR);
  },

  darDeAlta(id) {
    return restaurar(
      `${RUTA_TIPOS_DE_ORGANIZACIONES}/${id}/${SUFIJO_RESTAURAR}`,
      MENSAJES.RESTAURAR
    );
  }
};

export default apiTipoOrganizacion;
