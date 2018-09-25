import format from 'date-fns/format';

export default {
  filters: {
    formatoFecha(fecha) {
      if (!fecha) return '';
      return format(fecha, 'DD-MM-YYYY HH:mm:ss');
    }
  }
};
