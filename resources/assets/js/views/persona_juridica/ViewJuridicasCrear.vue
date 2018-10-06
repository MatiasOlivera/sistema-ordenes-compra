<template>

  <div class="row justify-content-center">
    <div class="col-xl-6">
      <vc-form-juridica
        @cerrar="irAlListado"
      />
    </div>
  </div>

</template>

<script>
import VcFormJuridica from '../../components/persona_juridica/VcFormJuridica.vue';
import { RUTA_JURIDICAS } from '../../router/rutas';

export default {
  name: 'ViewJuridicasCrear',

  components: {
    VcFormJuridica
  },

  methods: {
    irAlListado() {
      this.$router.push({ name: RUTA_JURIDICAS });
    }
  }
};
</script>

<style scoped>
</style>
