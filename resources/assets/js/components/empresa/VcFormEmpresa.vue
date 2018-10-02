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

      <!-- Campos -->
      <fieldset class="form-group">
        <label for="nombre_fantasia">Nombre de fantasía</label>

        <input
          id="nombre_fantasia"
          v-model="compania.nombre_fantasia"
          :class="{'is-invalid' : validacion.nombre_fantasia}"
          type="text"
          name="nombre_fantasia"
          class="form-control"
          aria-describedby="nombre_fantasiaAyuda"
        >

        <small
          v-if="!validacion.nombre_fantasia"
          id="nombre_fantasiaAyuda"
          class="form-text text-muted"
        >
          El nombre comercial de la empresa/negocio
        </small>
        <vc-form-error
          v-else
          :error="validacion.nombre_fantasia"
        />
      </fieldset>

      <div class="form-check form-check-inline">
        <input
          id="esMayorista"
          v-model="compania.es_mayorista"
          :value="true"
          :class="{'is-invalid' : validacion.es_mayorista}"
          class="form-check-input"
          type="radio"
          name="esMayorista"
        >
        <label
          class="form-check-label"
          for="esMayorista"
        >
          Es mayorista
        </label>
      </div>

      <div class="form-check form-check-inline">
        <input
          id="noEsMayorista"
          v-model="compania.es_mayorista"
          :value="false"
          :class="{'is-invalid' : validacion.es_mayorista}"
          class="form-check-input"
          type="radio"
          name="esMayorista"
        >
        <label
          class="form-check-label"
          for="noEsMayorista"
        >
          No es mayorista
        </label>
      </div>

      <!-- Botones -->
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
import apiEmpresa from '../../api/empresa';

/**
 * Componentes
 */
import BaseTarjeta from '../BaseTarjeta.vue';
import VcFormError from '../VcFormError.vue';
import VcBotonSubmit from '../VcBotonSubmit.vue';
import VcBotonReset from '../VcBotonReset.vue';

/**
 * Eventos
 */
import {
  EVENTO_GUARDADO,
  EVENTO_ACTUALIZADO
} from '../../common/components/eventos_formulario';
import { EVENTO_CERRAR } from '../../common/components/eventos_tarjeta';

/**
 * Valores por defecto
 */
const COMPANIA_POR_DEFECTO = {
  nombre_fantasia: null,
  es_mayorista: false
};

const VALIDACION_POR_DEFECTO = {
  nombre_fantasia: null,
  es_mayorista: null
};

const TARJETA = {
  botonIzqVisible: true,
  confirmacion: {
    notificacion: {
      titulo: 'Cerrar formulario',
      mensaje:
        'Se perderán todos los cambios de la empresa que no se hayan guardado. ¿Estás seguro?'
    }
  }
};

const TARJETA_NUEVO = {
  titulo: 'Nueva empresa',
  botonIzqTipo: 'cerrar',
  ...TARJETA
};

const TARJETA_EDITAR = {
  titulo: 'Editar empresa',
  botonIzqTipo: 'volver',
  ...TARJETA
};

export default {
  name: 'VcFormEmpresa',

  components: {
    BaseTarjeta,
    VcFormError,
    VcBotonSubmit,
    VcBotonReset
  },

  props: {
    empresa: {
      type: Object,
      default: function() {
        return COMPANIA_POR_DEFECTO;
      }
    }
  },

  data() {
    return {
      compania: null,
      validacion: null,
      tarjeta: null,
      estaCargando: false
    };
  },

  computed: {
    esNueva() {
      return _.isEqual(COMPANIA_POR_DEFECTO, this.empresa);
    },

    fueModificada() {
      return !_.isEqual(this.empresa, this.compania);
    }
  },

  watch: {
    empresa: {
      immediate: true,
      handler: function(empresa) {
        this.compania = { ...empresa };
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
      apiEmpresa
        .guardar(this.compania)
        .then((respuesta) => {
          const { status: STATUS } = respuesta;

          if (STATUS === 201) {
            this.exito(respuesta.notificacion);

            this.restaurar();

            const ID = respuesta.data.data.id || null;
            this.$emit(EVENTO_GUARDADO, ID);

            BusEventos.$emit('VcFormEmpresa:guardada');
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
      apiEmpresa
        .actualizar(this.compania.id, this.compania)
        .then((respuesta) => {
          const { status: STATUS } = respuesta;

          if (STATUS === 200) {
            this.exito(respuesta.notificacion);

            this.restaurar();

            this.$emit(EVENTO_ACTUALIZADO);

            BusEventos.$emit('VcFormEmpresa:guardada');
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
      this.compania = { ...this.empresa };
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
