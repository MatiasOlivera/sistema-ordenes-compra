<template lang="html">

  <button
    type="submit"
    name="submit"
    class="btn btn-primary btn-sm"
  >
    <save-icon class="icono"/> Guardar
  </button>

</template>

<script>
/**
 * Componentes
 */
import { SaveIcon } from 'vue-feather-icons';

export default {
  name: 'VcBotonSubmit',

  components: { SaveIcon }
};
</script>

<style lang="css">
</style>
