export default {
    methods: {
        $_darBajaInstanciaMixin_eliminar(ruta, cb, mensajes) {
            axios.delete(ruta)
            .then((response) => {
                this.exito({
                    title: 'Eliminado',
                    message: response.data.mensaje
                });
                
                cb(response);
            })
            .catch((error) => {
                if (error.response) {
                    let status = error.response.status;
                    let noEncontrado = mensajes.error.noEncontrado;
                    let porDefecto = mensajes.error.porDefecto;
            
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
        exito: {
            title: 'Exito',
            message: '',
            type: 'success'
        },
        error: {
            title: 'Error',
            message: '',
            type: 'error'
        }
    }
}