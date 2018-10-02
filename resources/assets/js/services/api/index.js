import { get, post, put, destroy, patch } from './servicio_peticion';
import { setMensajesExito, setMensajesError } from './servicio_mensajes';

export function obtener(url, parametros, mensajes) {
  return get(url, parametros)
    .then((respuesta) => respuesta)
    .catch((error) => {
      throw setMensajesError(error, mensajes);
    });
}

export function guardar(url, datos, mensajes) {
  return post(url, datos)
    .then((respuesta) => setMensajesExito(respuesta, mensajes))
    .catch((error) => {
      throw setMensajesError(error, mensajes);
    });
}

export function actualizar(url, datos, mensajes) {
  return put(url, datos)
    .then((respuesta) => setMensajesExito(respuesta, mensajes))
    .catch((error) => {
      throw setMensajesError(error, mensajes);
    });
}

export function eliminar(url, mensajes) {
  return destroy(url)
    .then((respuesta) => setMensajesExito(respuesta, mensajes))
    .catch((error) => {
      throw setMensajesError(error, mensajes);
    });
}

export function restaurar(url, mensajes) {
  return patch(url)
    .then((respuesta) => setMensajesExito(respuesta, mensajes))
    .catch((error) => {
      throw setMensajesError(error, mensajes);
    });
}

export default {
  obtener,
  guardar,
  actualizar,
  eliminar,
  restaurar
};
