<template>

  <div class="text-center mb-2">
    <h1 class="h3">{{ titulo }}</h1>
  </div>

</template>

<script>
export default {
  name: 'ElTitulo',

  props: {
    titulo: {
      type: String,
      required: true
    }
  }
};
</script>

<style scoped>
</style>
