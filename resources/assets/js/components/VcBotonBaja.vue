<template lang="html">

  <button
    :title="tooltip"
    type="button"
    name="baja"
    class="btn btn-sm btn-outline-danger"
    data-toggle="tooltip"
    data-placement="top"
    @click="confirmar"
  >
    <trash-icon class="icono"/>
  </button>

</template>

<script>
/**
 * Componentes
 */
import { TrashIcon } from 'vue-feather-icons';

/**
 * Mixins
 */
import TooltipMixin from '../mixins/tooltip_mixin';

export default {
  name: 'VcBotonBaja',

  components: { TrashIcon },

  mixins: [TooltipMixin],

  props: {
    tooltip: {
      type: String,
      default: 'Dar de baja'
    },

    nombre: {
      type: String,
      default: ''
    }
  },

  static: {
    elemento: 'button[name="baja"]'
  },

  methods: {
    confirmar() {
      function ocultarNotificacion(instancia, notificacion) {
        instancia.hide({ transitionOut: 'fadeOut' }, notificacion, 'button');
      }

      const MENSAJE =
        this.nombre !== ''
          ? `¿Estás seguro que quieres eliminar a ${this.nombre}?`
          : '¿Estás seguro que quieres eliminarlo?';

      this.pregunta({
        title: 'Confirmar la eliminación',
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
