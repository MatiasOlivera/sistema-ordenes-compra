export default {
    methods: {
        $_obtenerInstanciaMixin_obtener(ruta, cb) {
            axios.get(ruta)
            .then((response) => {
                cb(response);
            })
            .catch((error) => {
                if (error.response) {
                    let status = error.response.status;
                    let noEncontrado = this.mensajes.obtener.error.noEncontrado;
                    let porDefecto = this.mensajes.obtener.error.porDefecto;
    
                    switch (status) {
                        case 404:                 
                            this.error({
                                title: noEncontrado.titulo,
                                message: noEncontrado.mensaje
                            });
    
                            break;
                        default:
                            this.error({
                                title: porDefecto.titulo,
                                message: porDefecto.mensaje
                            });
                    }
                }
    
            });
        }
    },
    notifications: {
        error: {
            title: 'Error',
            message: '',
            type: 'error'
        }
    }
}