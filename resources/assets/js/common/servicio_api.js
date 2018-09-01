import servicioPeticion from './servicio_peticion';
import { setMensajesExito, setMensajesError } from './servicio_mensajes';

const api = {
  obtener(url, mensajes) {
    return servicioPeticion
      .obtener(url)
      .then((respuesta) => respuesta)
      .catch((error) => {
        throw setMensajesError(error, mensajes);
      });
  },

  guardar(url, datos, mensajes) {
    return servicioPeticion
      .guardar(url, datos)
      .then((respuesta) => setMensajesExito(respuesta, mensajes))
      .catch((error) => {
        throw setMensajesError(error, mensajes);
      });
  },

  actualizar(url, datos, mensajes) {
    return servicioPeticion
      .actualizar(url, datos)
      .then((respuesta) => setMensajesExito(respuesta, mensajes))
      .catch((error) => {
        throw setMensajesError(error, mensajes);
      });
  },

  eliminar(url, mensajes) {
    return servicioPeticion
      .eliminar(url)
      .then((respuesta) => setMensajesExito(respuesta, mensajes))
      .catch((error) => {
        throw setMensajesError(error, mensajes);
      });
  },

  restaurar(url, mensajes) {
    return servicioPeticion
      .restaurar(url)
      .then((respuesta) => setMensajesExito(respuesta, mensajes))
      .catch((error) => {
        throw setMensajesError(error, mensajes);
      });
  }
};

export default api;
