<template lang="html">

  <div class="row">
    <div class="col-10">
      <p>{{ actividad }}</p>
    </div>
    <div class="col-2">
      <vc-boton-baja
        :tooltip="$options.static.tooltip"
        :nombre="actividad"
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
  name: 'VcTarjetaActividadesItem',

  components: { VcBotonBaja },

  props: {
    id: {
      type: Number,
      required: true
    },
    actividad: {
      type: String,
      required: true
    }
  },

  static: {
    tooltip: 'Eliminar relación'
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
