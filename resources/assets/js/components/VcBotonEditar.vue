<template lang="html">

  <button
    :title="tooltip"
    type="button"
    name="editar"
    class="btn btn-sm btn-outline-primary"
    data-toggle="tooltip"
    data-placement="top"
    @click="click"
  >
    <edit-icon class="icono"/>
  </button>

</template>

<script>
/**
 * Componentes
 */
import { EditIcon } from 'vue-feather-icons';

/**
 * Mixins
 */
import TooltipMixin from '../mixins/tooltip_mixin';

export default {
  name: 'VcBotonEditar',

  components: { EditIcon },

  mixins: [TooltipMixin],

  data() {
    return {
      tooltip: 'Editar'
    };
  },

  static: {
    elemento: 'button[name="editar"]'
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
