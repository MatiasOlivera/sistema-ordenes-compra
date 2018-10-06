<template>

  <div>
    <div class="d-flex justify-content-center mb-2">
      <vc-boton-nuevo
        :descripcion="botonNuevo"
        @click.native="irAlFormularioNuevo"
      />
    </div>

    <vc-tabla-juridicas/>
  </div>

</template>

<script>
import VcBotonNuevo from '../../components/VcBotonNuevo.vue';
import VcTablaJuridicas from '../../components/persona_juridica/VcTablaJuridicas.vue';
import { RUTA_JURIDICA_CREAR } from '../../router/rutas';

export default {
  name: 'ViewJuridicasListado',

  components: {
    VcBotonNuevo,
    VcTablaJuridicas
  },

  data() {
    return {
      botonNuevo: 'Nueva'
    };
  },

  methods: {
    irAlFormularioNuevo() {
      this.$router.push({ name: RUTA_JURIDICA_CREAR });
    }
  }
};
</script>

<style scoped>
</style>
