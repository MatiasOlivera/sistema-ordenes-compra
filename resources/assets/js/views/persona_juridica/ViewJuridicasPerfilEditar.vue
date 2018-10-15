<template>

  <vc-form-juridica
    :persona-juridica="juridica"
    @cerrar="irAlDetalle"
  />

</template>

<script>
import { mapState } from 'vuex';
import { MODULO_JURIDICAS } from '../../store/tipos_modulos';
import { RUTA_JURIDICA_PERFIL } from '../../router/rutas';
import VcFormJuridica from '../../components/persona_juridica/VcFormJuridica.vue';

export default {
  name: 'ViewJuridicasPerfilEditar',

  components: { VcFormJuridica },

  computed: {
    ...mapState(MODULO_JURIDICAS, ['juridica'])
  },

  methods: {
    irAlDetalle() {
      this.$router.push({ name: RUTA_JURIDICA_PERFIL });
    }
  }
};
</script>

<style scoped>
</style>
