import api from '../servicio_api';
import { RUTA_TIPOS_DE_ORGANIZACIONES } from '../rutas_api';
import { crearNotification } from '../servicio_mensajes';

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
  obtener(id) {
    return api.obtener(
      `${RUTA_TIPOS_DE_ORGANIZACIONES}/${id}`,
      MENSAJES.OBTENER
    );
  },

  guardar(tipo) {
    return api.guardar(RUTA_TIPOS_DE_ORGANIZACIONES, tipo, MENSAJES.GUARDAR);
  },

  actualizar(id, tipo) {
    return api.actualizar(
      `${RUTA_TIPOS_DE_ORGANIZACIONES}/${id}`,
      tipo,
      MENSAJES.ACTUALIZAR
    );
  },

  darDeBaja(id) {
    return api.eliminar(
      `${RUTA_TIPOS_DE_ORGANIZACIONES}/${id}`,
      MENSAJES.ELIMINAR
    );
  },

  darDeAlta(id) {
    return api.restaurar(
      `${RUTA_TIPOS_DE_ORGANIZACIONES}/${id}`,
      MENSAJES.RESTAURAR
    );
  }
};

export default apiTipoOrganizacion;
