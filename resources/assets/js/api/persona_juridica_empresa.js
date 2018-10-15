import { guardar, eliminar } from '../services/api';
import { RUTA_PERSONAS_JURIDICAS, RUTA_EMPRESAS } from './rutas_api';
import { crearNotification } from '../services/api/servicio_mensajes';

const NO_ENCONTRADO = {
  noEncontrado: crearNotification(
    'No encontrada',
    'La persona jurídica o la empresa no existe'
  )
};

const MENSAJES = {
  GUARDAR: {
    exito: {
      porDefecto: crearNotification('Guardada')
    },
    error: {
      porDefecto: crearNotification(
        'Error',
        'No se pudo asociar la persona jurídica con la empresa'
      )
    }
  },
  ELIMINAR: {
    exito: {
      porDefecto: crearNotification('Eliminada')
    },
    error: {
      porDefecto: crearNotification(
        'Error',
        'No se pudo eliminar la asociación entre la persona jurídica y la empresa'
      ),
      ...NO_ENCONTRADO
    }
  }
};

const apiPersonaJuridicaEmpresa = {
  asociar(idJuridica, idEmpresa) {
    return guardar(
      `${RUTA_PERSONAS_JURIDICAS}/${idJuridica}/${RUTA_EMPRESAS}/${idEmpresa}`,
      null,
      MENSAJES.GUARDAR
    );
  },

  desasociar(idJuridica, idEmpresa) {
    return eliminar(
      `${RUTA_PERSONAS_JURIDICAS}/${idJuridica}/${RUTA_EMPRESAS}/${idEmpresa}`,
      MENSAJES.ELIMINAR
    );
  }
};

export default apiPersonaJuridicaEmpresa;
