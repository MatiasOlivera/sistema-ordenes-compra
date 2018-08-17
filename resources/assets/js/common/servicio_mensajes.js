export function notificacion(titulo = '', mensaje = '') {
    return {
        title: titulo,
        message: mensaje
    }
}

export function setMensajesExito(respuesta, mensajes) {
    const STATUS = respuesta.status;
    
    switch(STATUS) {
        case 200:
        case 201:
            if (respuesta.data.hasOwnProperty('mensaje')) {
                const { title: titulo } = mensajes.exito.porDefecto;
                respuesta.notificacion = notificacion(titulo, respuesta.data.mensaje);
            }
            break;
    }
    
    return respuesta;
}

export function setMensajesError(error, mensajes) {
    let notificacion = null;
    let validacion = null;
    
    if (error.response) {
        const STATUS = error.response.status;
        
        switch(STATUS) {
            case 400:
                if (error.response.data.hasOwnProperty('mensaje')) {
                    notificacion = notificacion('Error', error.response.data.mensaje);
                }
                break;
            
            case 404:
                notificacion = mensajes.error.noEncontrado;
                break;
            
            case 422:
                validacion = error.response.data.errors;
                break;
            
            default:
                notificacion = mensajes.error.porDefecto;
        }
    }
        
    return { notificacion, validacion };
}