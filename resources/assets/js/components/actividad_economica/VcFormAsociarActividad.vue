<template lang="html">

  <base-form-simple
    @guardar="guardar"
  >

    <fieldset class="form-group">
      <label for="vc-select-actividad">Rubro</label>

      <vc-select-actividad
        :actividades="actividades"
        @buscar="selectActividadBuscar"
        @input="selectActividadInput"
      />
    </fieldset>

  </base-form-simple>

</template>

<script>
/**
 * Componentes
 */
import BaseFormSimple from '../BaseFormSimple.vue';
import VcSelectActividad from './VcSelectActividad.vue';

export default {
  name: 'VcFormAsociarActividad',

  components: {
    BaseFormSimple,
    VcSelectActividad
  },

  props: {
    actividades: {
      type: Array,
      default: function() {
        return [];
      }
    }
  },

  data() {
    return {
      actividad: {}
    };
  },

  methods: {
    selectActividadBuscar(valorBuscado) {
      this.$emit('buscar', valorBuscado);
    },

    selectActividadInput(actividad) {
      this.actividad = actividad;
    },

    guardar() {
      this.$emit('guardar', this.actividad);
    }
  }
};
</script>

<style lang="css">
</style>
