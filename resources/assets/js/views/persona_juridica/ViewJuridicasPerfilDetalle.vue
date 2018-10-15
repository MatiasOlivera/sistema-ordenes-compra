<template>

  <vc-detalle-juridica
    :juridica="juridica"
  />

</template>

<script>
import { mapState } from 'vuex';
import { MODULO_JURIDICAS } from '../../store/tipos_modulos';
import VcDetalleJuridica from '../../components/persona_juridica/VcDetalleJuridica.vue';

export default {
  name: 'ViewJuridicasPerfilDetalle',

  components: { VcDetalleJuridica },

  computed: {
    ...mapState(MODULO_JURIDICAS, ['juridica'])
  }
};
</script>

<style scoped>
</style>
