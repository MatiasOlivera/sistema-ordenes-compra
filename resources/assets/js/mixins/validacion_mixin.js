export default {
    methods: {
        $_validacionMixin_obtenerMensajesError(errores) {
            let mensajes = _.mapValues(errores, function (error) {
                return error[0]
            });

            return mensajes;
        }
    }
}
