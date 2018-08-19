/**
 * Validar que una prop tiene las propiedades especificadas
 * @param  {Object} prop    La prop de un componente
 * @param  {Array}  claves  Las propiedades que debe tener la prop
 * @return {Boolean}
 */
export function objectoTienePropiedades(prop, claves) {
    if (! _.isObject(prop)) {
        throw new TypeError('El argumento "prop" debe ser un objecto');
    }
    
    if (_.isEmpty(prop)) {
        throw new Error('El argumento "prop" debe tener por lo menos un par clave/valor');
    }
    
    if (! _.isArray(claves)) {
        throw new TypeError('El argumento "claves" debe ser un array');
    }
    
    if (_.isEmpty(claves)) {
        throw new Error('El argumento "claves" debe incluir por lo menos una propiedad');
    }
    
    for (let clave of claves) {
        if (!prop.hasOwnProperty(clave)) {
            return false;
        }
    }
    return true;
}
