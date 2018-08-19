import api                       from '../servicio_api.js';
import { rutaActividad as ruta } from '../rutas_api.js';
import { notificacion }          from '../servicio_mensajes.js';

const NO_ENCONTRADO = {
    noEncontrado: notificacion('No encontrado', 'El rubro no existe')
};

const MENSAJES = {
    OBTENER: {
        error: {
            porDefecto: notificacion('Error', 'No se pudo traer los datos del rubro'),
            ...NO_ENCONTRADO
        }
    },
    
    GUARDAR: {
        exito: {
            porDefecto: notificacion('Guardado')
        },
        error: {
            porDefecto: notificacion('Error', 'No se pudo crear el rubro')
        }
    },
    
    ACTUALIZAR: {
        exito: {
            porDefecto: notificacion('Actualizado')
        },
        error: {
            ...NO_ENCONTRADO
        }
    },
    
    ELIMINAR: {
        exito: {
            porDefecto: notificacion('Eliminado')
        },
        error: {
            ...NO_ENCONTRADO
        }
    },
    
    RESTAURAR: {
        exito: {
            porDefecto: notificacion('Restaurado')
        },
        error: {
            ...NO_ENCONTRADO
        }
    }
};

export const apiActividad = {
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