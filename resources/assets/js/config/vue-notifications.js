import VueNotifications from 'vue-notifications';
import iziToast from 'izitoast';

export const NOTIFICACION_TIMEOUT = 10000;

function notificacion({
  title,
  message,
  type,
  timeout,
  buttons = [],
  displayMode
}) {
  if (type === VueNotifications.types.warn) type = 'warning';
  return iziToast[type]({ title, message, timeout, buttons, displayMode });
}

export const TIPOS_DE_NOTIFICACION = {
  success: notificacion,
  error: notificacion,
  info: notificacion,
  warn: notificacion,
  question: notificacion
};

export default {
  NOTIFICACION_TIMEOUT,
  TIPOS_DE_NOTIFICACION
};
