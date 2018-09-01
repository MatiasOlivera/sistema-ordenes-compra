<template lang="html">

  <div>
    <check-icon
      v-if="estado"
      class="icono"
    />

    <x-icon
      v-else
      class="icono"
    />
  </div>

</template>

<script>
import { CheckIcon, XIcon } from 'vue-feather-icons';

export default {
  name: 'VcIconoEstado',

  components: {
    CheckIcon,
    XIcon
  },

  props: {
    estado: {
      type: Boolean,
      required: true
    }
  }
};
</script>

<style lang="css">
</style>
