import distanceInWordsToNow from 'date-fns/distance_in_words_to_now';
import es from 'date-fns/locale/es';

export default {
  filters: {
    formatoRelativo(fecha) {
      if (!fecha) return '';
      return distanceInWordsToNow(fecha, { locale: es });
    }
  }
};
