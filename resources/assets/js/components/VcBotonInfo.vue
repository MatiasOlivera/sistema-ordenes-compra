<template lang="html">

  <button
    :title="tooltip"
    type="button"
    name="info"
    class="btn btn-sm btn-outline-info"
    data-toggle="tooltip"
    data-placement="top"
    @click="click"
  >
    <info-icon class="icono"/>
  </button>

</template>

<script>
/**
 * Componentes
 */
import { InfoIcon } from 'vue-feather-icons';

/**
 * Mixins
 */
import TooltipMixin from '../mixins/tooltip_mixin';

export default {
  name: 'VcBotonInfo',

  components: { InfoIcon },

  mixins: [TooltipMixin],

  props: {
    tooltip: {
      type: String,
      default: 'Perfil'
    }
  },

  static: {
    elemento: 'button[name="info"]'
  },

  methods: {
    click() {
      this.$_TooltipMixin_ocultarTooltip();
      this.$emit('click');
    }
  }
};
</script>

<style lang="css">
</style>
