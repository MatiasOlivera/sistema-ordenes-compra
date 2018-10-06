<template lang="html">

  <div class="container">
    <el-titulo :titulo="titulo"/>

    <router-view/>
  </div>

</template>

<script>
import ElTitulo from '../../components/ElTitulo.vue';

export default {
  name: 'ViewJuridicas',

  components: {
    ElTitulo
  },

  data() {
    return {
      titulo: 'Personas Jurídicas'
    };
  }
};
</script>

<style lang="css">
</style>
