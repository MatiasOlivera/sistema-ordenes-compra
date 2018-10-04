<template>

  <button
    type="button"
    name="nuevo"
    class="btn btn-primary"
  >
    <plus-circle-icon class="icono"/> {{ descripcion }}
  </button>

</template>

<script>
import { PlusCircleIcon } from 'vue-feather-icons';

export default {
  name: 'VcBotonNuevo',

  components: { PlusCircleIcon },

  props: {
    descripcion: {
      type: String,
      required: true,
      validator: function(descripcion) {
        const BOTONES = ['Nuevo', 'Nueva'];
        return BOTONES.includes(descripcion);
      }
    }
  }
};
</script>

<style scoped>
</style>
