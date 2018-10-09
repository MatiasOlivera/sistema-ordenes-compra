<template lang="html">

  <div class="mb-4 p-3 bg-white rounded box-shadow">
    <div class="row border-bottom border-gray mb-4">
      <div class="col-auto">
        <div class="d-flex flex-row">
          <h3 class="h6">{{ titulo }}</h3>
          <plus-icon
            v-if="botonNuevoVisible"
            id="iconoNuevo"
            class="icono ml-2"
            @click="nuevo"
          />
        </div>
      </div>

      <div
        v-if="botonIzqVisible"
        class="col-auto ml-auto"
      >
        <a
          href="#"
          class="text-muted"
          @click.prevent="cerrar"
        >
          <template v-if="botonIzqEsCerrar">
            <x-icon class="icono"/> Cerrar
          </template>

          <template v-else>
            <arrow-left-icon class="icono"/> Volver
          </template>
        </a>
      </div>
    </div>

    <slot/>
  </div>

</template>

<script>
/**
 * Componentes
 */
import { PlusIcon, XIcon, ArrowLeftIcon } from 'vue-feather-icons';

import { EVENTO_CERRAR } from '../common/components/eventos_tarjeta';

const EVENTO_NUEVO = 'nuevo';

export default {
  name: 'BaseTarjeta',

  components: {
    PlusIcon,
    XIcon,
    ArrowLeftIcon
  },

  props: {
    titulo: {
      type: String,
      required: true
    },

    botonNuevoVisible: {
      type: Boolean,
      default: false
    },

    botonIzqVisible: {
      type: Boolean,
      default: false
    },

    botonIzqTipo: {
      type: String,
      default: 'cerrar',
      validator: function(tipo) {
        const tipos = ['cerrar', 'volver'];
        return tipos.includes(tipo);
      }
    },

    confirmacionRequerida: {
      type: Boolean,
      default: false
    },

    confirmacionNotificacion: {
      type: Object,
      default: function() {
        return {
          titulo: 'Cerrar tarjeta',
          mensaje: '¿Estás seguro?'
        };
      }
    }
  },
  computed: {
    botonIzqEsCerrar() {
      return this.botonIzqTipo === 'cerrar';
    }
  },
  methods: {
    nuevo() {
      this.$emit(EVENTO_NUEVO);
    },

    cerrar() {
      if (this.confirmacionRequerida) {
        this.confirmarAlCerrar();
      } else {
        this.$emit(EVENTO_CERRAR);
      }
    },

    confirmarAlCerrar() {
      function ocultarNotificacion(instancia, notificacion) {
        instancia.hide(
          {
            transitionOut: 'fadeOut'
          },
          notificacion,
          'button'
        );
      }

      this.pregunta({
        titulo: this.confirmacionNotificacion.titulo,
        mensaje: this.confirmacionNotificacion.mensaje,
        timeout: false,
        buttons: [
          [
            '<button>Si</button>',
            (instance, toast) => {
              this.$emit(EVENTO_CERRAR);
              ocultarNotificacion(instance, toast);
            },
            true
          ],
          [
            '<button>No</button>',
            (instance, toast) => {
              ocultarNotificacion(instance, toast);
            }
          ]
        ],
        displayMode: 'once'
      });
    }
  },

  notifications: {
    pregunta: {
      titulo: '',
      mensaje: '',
      tipo: 'pregunta'
    }
  }
};
</script>

<style lang="css" scoped>
#iconoNuevo {
  margin-top: 2px;
  margin-bottom: 0px;
}
</style>
