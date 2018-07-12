export default {
    filters: {
        formatoCuit: function(cuit) {
            if (!cuit) return '';
            
            const caracter = 'x';
            cuit = cuit.toString();
            
            let tipo = cuit.substring(0,2).padEnd(2, caracter);
            let numero = cuit.substring(2,10).padEnd(8, caracter);
            let digitoVerificador = cuit.substring(10,11).padEnd(1, caracter);

            return `${tipo}-${numero}-${digitoVerificador}`;
        }
    }
}