import api              from '../servicio_api.js';
import { URL_EMPRESAS } from '../rutas_api.js';
import { notificacion } from '../servicio_mensajes.js';

const NO_ENCONTRADO = {
    noEncontrado: notificacion('No encontrada', 'La empresa no existe')
};

const MENSAJES = {
    OBTENER: {
        error: {
            porDefecto: notificacion('Error', 'No se pudo traer los datos de la empresa'),
            ...NO_ENCONTRADO
        }
    },
    
    GUARDAR: {
        exito: {
            porDefecto: notificacion('Guardada')
        },
        error: {
            porDefecto: notificacion('Error', 'No se pudo crear la empresa')
        }
    },
    
    ACTUALIZAR: {
        exito: {
            porDefecto: notificacion('Actualizada')
        },
        error: {
            ...NO_ENCONTRADO
        }
    },
    
    ELIMINAR: {
        exito: {
            porDefecto: notificacion('Eliminada')
        },
        error: {
            ...NO_ENCONTRADO
        }
    },
    
    RESTAURAR: {
        exito: {
            porDefecto: notificacion('Restaurada')
        },
        error: {
            ...NO_ENCONTRADO
        }
    }
};

export const apiEmpresa = {
    guardar(empresa) {
        return api.guardar(URL_EMPRESAS, empresa, MENSAJES.GUARDAR);
    },
    
    actualizar(id, empresa) {
        return api.actualizar(`${URL_EMPRESAS}/${id}`, empresa, MENSAJES.ACTUALIZAR);
    }
};