<template lang="html">

  <div class="row">
    <div class="col-10">
      <p>{{ nombre }}</p>
    </div>
    <div class="col-2">
      <vc-boton-baja
        :tooltip="tooltip"
        :nombre="nombre"
        @confirmado="darDeBaja"
      />
    </div>
  </div>

</template>

<script>
/**
 * Componentes
 */
import VcBotonBaja from '../VcBotonBaja.vue';

export default {
  name: 'VcTarjetaEmpresasItem',

  components: { VcBotonBaja },

  props: {
    id: {
      type: Number,
      required: true
    },

    nombre: {
      type: String,
      required: true
    }
  },

  data() {
    return {
      tooltip: 'Eliminar relación'
    };
  },

  methods: {
    darDeBaja() {
      this.$emit('dar-de-baja', this.id);
    }
  }
};
</script>

<style lang="css">
</style>
