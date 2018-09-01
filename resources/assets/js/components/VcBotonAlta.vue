<template lang="html">

  <button
    :title="tooltip"
    type="button"
    name="alta"
    class="btn btn-sm btn-outline-primary"
    data-toggle="tooltip"
    data-placement="top"
    @click="confirmar"
  >
    <arrow-up-icon class="icono"/>
  </button>

</template>

<script>
/**
 * Componentes
 */
import { ArrowUpIcon } from 'vue-feather-icons';

/**
 * Mixins
 */
import TooltipMixin from '../mixins/tooltip_mixin';

export default {
  name: 'VcBotonAlta',

  components: { ArrowUpIcon },

  mixins: [TooltipMixin],

  props: {
    tooltip: {
      type: String,
      default: 'Dar de alta'
    },

    nombre: {
      type: String,
      default: ''
    }
  },

  static: {
    elemento: 'button[name="alta"]'
  },

  methods: {
    confirmar() {
      function ocultarNotificacion(instancia, notificacion) {
        instancia.hide({ transitionOut: 'fadeOut' }, notificacion, 'button');
      }

      const MENSAJE =
        this.nombre !== ''
          ? `¿Estás seguro que quieres dar de alta a ${this.nombre}?`
          : '¿Estás seguro que quieres darlo de alta?';

      this.pregunta({
        title: 'Confirmar el alta',
        message: MENSAJE,
        timeout: false,
        buttons: [
          [
            '<button>Si</button>',
            (instance, toast) => {
              ocultarNotificacion(instance, toast);
              this.$emit('confirmado');
            },
            true
          ],
          [
            '<button>No</button>',
            (instance, toast) => {
              ocultarNotificacion(instance, toast);
            }
          ]
        ]
      });

      this.$_TooltipMixin_ocultarTooltip();
    }
  },

  notifications: {
    pregunta: {
      title: '',
      message: '',
      type: 'question'
    }
  }
};
</script>

<style lang="css">
</style>
