import servicioPeticion from './servicio_peticion.js';
import { setMensajesExito, setMensajesError } from './servicio_mensajes.js';


const api = {
    obtener(url, mensajes) {
        return servicioPeticion.obtener(url)
        .then((respuesta) => {
            return respuesta;
        })
        .catch((error) => {
            throw setMensajesError(error, mensajes);
        });
    },

    guardar(url, datos, mensajes) {
        return servicioPeticion.guardar(url, datos)
        .then((respuesta) => {
            return setMensajesExito(respuesta, mensajes);
        })
        .catch((error) => {
            throw setMensajesError(error, mensajes);
        });
    },

    actualizar(url, datos, mensajes) {
        return servicioPeticion.actualizar(url, datos)
        .then((respuesta) => {
            return setMensajesExito(respuesta, mensajes);
        })
        .catch((error) => {
            throw setMensajesError(error, mensajes);
        });
    },

    eliminar(url, mensajes) {
        return servicioPeticion.eliminar(url)
        .then((respuesta) => {
            return setMensajesExito(respuesta, mensajes);
        })
        .catch((error) => {
            throw setMensajesError(error, mensajes);
        });
    },

    restaurar(url, mensajes) {
        return servicioPeticion.restaurar(url)
        .then((respuesta) => {
            return setMensajesExito(respuesta, mensajes);
        })
        .catch((error) => {
            throw setMensajesError(error, mensajes);
        });
    }
};

export default api;