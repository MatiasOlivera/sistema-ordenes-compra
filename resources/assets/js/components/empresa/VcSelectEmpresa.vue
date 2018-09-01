<template lang="html">

  <multiselect
    v-model="seleccionada"
    :id="$options.name"
    :options="empresas"
    :multiple="multiple"
    :track-by="trackBy"
    :label="label"
    :searchable="searchable"
    :placeholder="placeholder"
    :internal-search="internalSearch"
    :select-label="selectLabel"
    :select-group-label="selectGroupLabel"
    :selected-label="selectedLabel"
    :deselect-label="deselectLabel"
    :deselect-group-label="deselectGroupLabel"
    :limit-text="limitText"
    :loading="estaCargando"
    :open-direction="openDirection"
    @search-change="buscarEmpresas"
    @input="input"
  >
    <template slot="maxElements">
      <p>Haz llegado al máximo permitido de opciones seleccionadas. Primero quite una opción seleccionada para elegir otra.</p>
    </template>

    <template slot="noResult">
      <p>No se encontraron registros que coincidan con tu búsqueda.</p>
    </template>
  </multiselect>

</template>

<script>
/**
 * Mixins
 */
import MultiselectConfigMixin from '../../mixins/multiselect_config_mixin';

export default {
  name: 'VcSelectEmpresa',

  mixins: [MultiselectConfigMixin],

  props: {
    empresas: {
      type: Array,
      required: true
    }
  },

  data() {
    return {
      seleccionada: [],
      estaCargando: false,
      multiple: false,
      trackBy: 'id',
      label: 'nombre_fantasia'
    };
  },

  watch: {
    empresas: function() {
      this.estaCargando = false;
    }
  },

  methods: {
    buscarEmpresas(valorBuscado) {
      this.estaCargando = true;
      this.$emit('buscar', valorBuscado);
    },

    input(seleccionada) {
      this.$emit('input', seleccionada);
    }
  }
};
</script>

<style lang="css">
</style>
