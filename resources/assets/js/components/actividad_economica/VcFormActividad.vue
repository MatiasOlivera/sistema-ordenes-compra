<template lang="html">

  <base-tarjeta
    :titulo="tarjeta.titulo"
    :boton-izq-visible="tarjeta.botonIzqVisible"
    :boton-izq-tipo="tarjeta.botonIzqTipo"
    :confirmacion-requerida="fueModificada"
    :confirmacion-notificacion="tarjeta.confirmacion.notificacion"
    @cerrar="cerrar"
  >

    <form @submit.prevent="enviar">
      <fieldset class="form-group">
        <label for="descripcion">Descripción</label>

        <input
          id="descripcion"
          v-model="actividad.descripcion"
          :class="{'is-invalid' : validacion.descripcion}"
          type="text"
          name="descripcion"
          class="form-control"
        >
        <vc-form-error
          v-if="validacion.descripcion"
          :error="validacion.descripcion"
        />
      </fieldset>

      <div class="row mt-4">
        <div class="col">
          <vc-boton-submit :disabled="estaCargando"/>
        </div>

        <div class="col-auto ml-auto">
          <vc-boton-reset @click.native="restaurar"/>
        </div>
      </div>
    </form>

  </base-tarjeta>

</template>

<script>
import apiActividad from '../../common/api/actividad_economica';
import { objetoTienePropiedades } from '../../common/components/validadores';
import {
  ACTIVIDAD_POR_DEFECTO,
  ACTIVIDAD_CLAVES
} from '../../common/components/actividad_economica';

/**
 * Eventos
 */
import {
  EVENTO_GUARDADO,
  EVENTO_ACTUALIZADO
} from '../../common/components/eventos_formulario';
import { EVENTO_CERRAR } from '../../common/components/eventos_tarjeta';

/**
 * Componentes
 */
import BaseTarjeta from '../BaseTarjeta.vue';
import VcFormError from '../VcFormError.vue';
import VcBotonSubmit from '../VcBotonSubmit.vue';
import VcBotonReset from '../VcBotonReset.vue';

/**
 * Valores por defecto
 */
const VALIDACION_POR_DEFECTO = {
  descripcion: null
};

const TARJETA = {
  botonIzqVisible: true,
  confirmacion: {
    notificacion: {
      titulo: 'Cerrar formulario',
      mensaje:
        'Se perderán todos los cambios de la actividad económica que no se hayan guardado. ¿Estás seguro?'
    }
  }
};

const TARJETA_NUEVO = {
  titulo: 'Nuevo rubro',
  botonIzqTipo: 'cerrar',
  ...TARJETA
};

const TARJETA_EDITAR = {
  titulo: 'Editar rubro',
  botonIzqTipo: 'volver',
  ...TARJETA
};

export default {
  name: 'VcFormActividad',

  components: {
    BaseTarjeta,
    VcFormError,
    VcBotonSubmit,
    VcBotonReset
  },

  props: {
    actividadEconomica: {
      type: Object,
      validator: function(actividad) {
        return objetoTienePropiedades(actividad, ACTIVIDAD_CLAVES);
      },
      default: function() {
        return ACTIVIDAD_POR_DEFECTO;
      }
    }
  },

  data() {
    return {
      actividad: null,
      validacion: null,
      tarjeta: null,
      estaCargando: false
    };
  },

  computed: {
    esNueva() {
      return _.isEqual(ACTIVIDAD_POR_DEFECTO, this.actividadEconomica);
    },

    fueModificada() {
      return !_.isEqual(this.actividadEconomica, this.actividad);
    },

    /**
     * Evitar el envio de propiedades innecesarias en las peticiones
     * @return {Object} Los campos del formulario
     */
    camposFormulario() {
      return _.pick(this.actividad, ACTIVIDAD_CLAVES);
    }
  },

  watch: {
    actividadEconomica: {
      immediate: true,
      handler: function(actividad) {
        this.actividad = { ...actividad };
      }
    }
  },

  created() {
    this.tarjeta = this.esNueva ? TARJETA_NUEVO : TARJETA_EDITAR;
    this.setValidacionPorDefecto();
  },

  methods: {
    enviar() {
      if (this.fueModificada) {
        this.estaCargando = true;
        if (this.esNueva) {
          this.guardar();
        } else {
          this.actualizar();
        }
      }
    },

    guardar() {
      apiActividad
        .guardar(this.camposFormulario)
        .then((respuesta) => {
          const { status: STATUS } = respuesta;

          if (STATUS === 201) {
            this.exito(respuesta.notificacion);

            this.restaurar();

            this.$emit(EVENTO_GUARDADO);

            BusEventos.$emit('VcFormActividad:guardado');
          }
        })
        .catch(({ notificacion, validacion }) => {
          if (validacion) {
            this.validacion = validacion;
          }

          if (notificacion) {
            this.error(notificacion);
          }
        })
        .finally(() => {
          this.estaCargando = false;
        });
    },

    actualizar() {
      apiActividad
        .actualizar(this.actividad.id, this.camposFormulario)
        .then((respuesta) => {
          const { status: STATUS } = respuesta;

          if (STATUS === 200) {
            this.exito(respuesta.notificacion);

            this.restaurar();

            this.$emit(EVENTO_ACTUALIZADO);

            BusEventos.$emit('VcFormActividad:guardado');
          }
        })
        .catch(({ notificacion, validacion }) => {
          if (validacion) {
            this.validacion = validacion;
          }

          if (notificacion) {
            this.error(notificacion);
          }
        })
        .finally(() => {
          this.estaCargando = false;
        });
    },

    restaurar() {
      this.actividad = { ...this.actividadEconomica };
      this.setValidacionPorDefecto();
    },

    setValidacionPorDefecto() {
      this.validacion = { ...VALIDACION_POR_DEFECTO };
    },

    cerrar() {
      this.restaurar();
      this.$emit(EVENTO_CERRAR);
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
};
</script>

<style lang="css">
</style>
