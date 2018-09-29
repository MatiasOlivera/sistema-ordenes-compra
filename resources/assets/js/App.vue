<template>
  <div>
    <la-cabecera/>

    <router-view/>
  </div>
</template>

<script>
import LaCabecera from './components/LaCabecera.vue';

export default {
  name: 'App',
  components: { LaCabecera }
};
</script>

<style>
</style>
