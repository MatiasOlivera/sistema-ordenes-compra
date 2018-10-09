export function crearNotification(
  titulo = 'Titulo',
  mensaje = 'Mensaje',
  tipo = 'advertencia'
) {
  return {
    titulo,
    mensaje,
    tipo
  };
}

export function setMensajesExito(
  respuesta,
  mensajes,
  crearNotificacion = crearNotification
) {
  let datos = respuesta;
  const STATUS = respuesta.status;

  if (STATUS === 200 || STATUS === 201) {
    if (_.has(respuesta.data, 'mensaje')) {
      const { titulo } = mensajes.exito.porDefecto;
      datos.notificacion = crearNotificacion(titulo, respuesta.data.mensaje);
    }
  }

  return datos;
}

export function setMensajesError(
  error,
  mensajes,
  crearNotificacion = crearNotification
) {
  let notificacion = null;
  let validacion = null;

  if (error.response) {
    const STATUS = error.response.status;

    switch (STATUS) {
      case 400:
        if (_.has(error.response.data, 'mensaje')) {
          notificacion = crearNotificacion(
            'Error',
            error.response.data.mensaje
          );
        }
        break;

      case 404:
        notificacion = mensajes.error.noEncontrado;
        break;

      case 422:
        validacion = error.response.data.errors;
        break;

      default:
        notificacion = mensajes.error.porDefecto;
    }
  }

  return { notificacion, validacion };
}
