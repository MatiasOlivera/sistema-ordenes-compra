export default {
  filters: {
    formatoCuit: function(cuit) {
      if (!cuit) return '';

      const CARACTER = 'x';
      const CUIT_CADENA = cuit.toString();

      const TIPO = CUIT_CADENA.substring(0, 2).padEnd(2, CARACTER);
      const NUMERO = CUIT_CADENA.substring(2, 10).padEnd(8, CARACTER);
      const DIGITO_VERIFICADOR = CUIT_CADENA.substring(10, 11).padEnd(
        1,
        CARACTER
      );

      return `${TIPO}-${NUMERO}-${DIGITO_VERIFICADOR}`;
    }
  }
};
