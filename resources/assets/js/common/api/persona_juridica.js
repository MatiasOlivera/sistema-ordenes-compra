import api                             from '../servicio_api.js';
import { rutaPersonaJuridica as ruta } from '../rutas_api.js';
import { notificacion }                from '../servicio_mensajes.js';

const NO_ENCONTRADO = {
    noEncontrado: notificacion('No encontrada', 'La persona jurídica no existe')
};

const MENSAJES = {
    OBTENER: {
        error: {
            porDefecto: notificacion('Error', 'No se pudo traer los datos de la persona jurídica'),
            ...NO_ENCONTRADO
        }
    },
    
    GUARDAR: {
        exito: {
            porDefecto: notificacion('Guardada')
        },
        error: {
            porDefecto: notificacion('Error', 'No se pudo crear la persona jurídica')
        }
    },
    
    ACTUALIZAR: {
        exito: {
            porDefecto: notificacion('Actualizada')
        },
        error: {
            porDefecto: notificacion('Error', 'No se pudo actualizar los datos de la persona jurídica'),
            ...NO_ENCONTRADO
        }
    },
    
    ELIMINAR: {
        exito: {
            porDefecto: notificacion('Eliminada')
        },
        error: {
            porDefecto: notificacion('Error', 'No se pudo dar de baja a la persona jurídica'),
            ...NO_ENCONTRADO
        }
    },
    
    RESTAURAR: {
        exito: {
            porDefecto: notificacion('Restaurada')
        },
        error: {
            porDefecto: notificacion('Error', 'No se pudo dar de alta a la persona jurídica'),
            ...NO_ENCONTRADO
        }
    }
};

export const apiPersonaJuridica = {
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