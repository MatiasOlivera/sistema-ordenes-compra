<template lang="html">

  <div class="invalid-feedback">
    {{ error }}
  </div>

</template>

<script>
export default {
  name: 'VcFormError',

  props: {
    error: {
      type: String,
      required: true
    }
  }
};
</script>

<style lang="css">
</style>
