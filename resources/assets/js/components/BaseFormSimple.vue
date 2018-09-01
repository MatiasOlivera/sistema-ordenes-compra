<template lang="html">

  <form @submit.prevent="guardar">
    <!-- Campos -->
    <slot/>

    <!-- Botones -->
    <div class="row mt-4">
      <div class="col">
        <button
          type="submit"
          name="submit"
          class="btn btn-primary btn-sm"
        >
          <save-icon class="icono"/> Guardar
        </button>
      </div>
    </div>
  </form>

</template>

<script>
/**
 * Componentes
 */
import { SaveIcon } from 'vue-feather-icons';

export default {
  name: 'BaseFormSimple',

  components: { SaveIcon },

  methods: {
    guardar() {
      this.$emit('guardar');
    }
  }
};
</script>

<style lang="css">
</style>
