import Ruta from './ruta.js';

let rutaActividad = new Ruta('/actividades-economicas');
let rutaEmpresa = new Ruta('/empresas');
let rutaPersonaJuridica = new Ruta('/juridicas');
let rutaTipoOrganizacion = new Ruta('/tipos-organizacion');

export {
    rutaActividad,
    rutaEmpresa,
    rutaPersonaJuridica,
    rutaTipoOrganizacion
}