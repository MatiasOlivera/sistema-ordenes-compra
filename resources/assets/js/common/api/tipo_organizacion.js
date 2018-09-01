import api from '../servicio_api';
import { rutaTipoOrganizacion as ruta } from '../rutas_api';
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
    const RUTA = ruta.especifica(id);
    return api.obtener(RUTA, MENSAJES.OBTENER);
  },

  guardar(tipo) {
    return api.guardar(ruta.base, tipo, MENSAJES.GUARDAR);
  },

  actualizar(id, tipo) {
    const RUTA = ruta.especifica(id);
    return api.actualizar(RUTA, tipo, MENSAJES.ACTUALIZAR);
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

export default apiTipoOrganizacion;
