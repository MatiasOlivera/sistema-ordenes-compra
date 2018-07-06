export default {
    methods: {
        $_ValidacionMixin_obtenerMensajesError(errores) {
            let mensajes = _.mapValues(errores, function (error) {
                return error[0]
            });

            return mensajes;
        }
    }
}