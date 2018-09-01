<template lang="html">

  <button
    type="reset"
    name="reset"
    class="btn btn-secondary btn-sm"
  >
    <delete-icon class="icono"/> Deshacer todo
  </button>

</template>

<script>
/**
 * Componentes
 */
import { DeleteIcon } from 'vue-feather-icons';

export default {
  name: 'VcBotonReset',

  components: { DeleteIcon }
};
</script>

<style lang="css">
</style>
