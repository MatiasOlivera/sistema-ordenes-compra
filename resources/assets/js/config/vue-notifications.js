import VueNotifications from 'vue-notifications';
import iziToast from 'izitoast';

export const NOTIFICACION_TIMEOUT = 10000;

const TIPOS = {
  exito: 'success',
  error: 'error',
  info: 'info',
  advertencia: 'warning',
  pregunta: 'question'
};

function notificacion({
  titulo: title,
  mensaje: message,
  tipo,
  timeout,
  buttons = [],
  displayMode
}) {
  const type = TIPOS[tipo];
  return iziToast[type]({ title, message, timeout, buttons, displayMode });
}

export const TIPOS_DE_NOTIFICACION = {
  success: notificacion,
  error: notificacion,
  info: notificacion,
  warning: notificacion,
  question: notificacion
};

export default {
  NOTIFICACION_TIMEOUT,
  TIPOS_DE_NOTIFICACION
};
