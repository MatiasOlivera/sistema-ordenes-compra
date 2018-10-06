<template>

  <div class="row justify-content-center">
    <div class="col-xl-6">
      <vc-perfil-juridica/>
    </div>
  </div>

</template>

<script>
import VcPerfilJuridica from '../../components/persona_juridica/VcPerfilJuridica.vue';

export default {
  name: 'ViewJuridicasPerfil',

  components: {
    VcPerfilJuridica
  }
};
</script>

<style scoped>
</style>
