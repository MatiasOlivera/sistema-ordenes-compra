<template lang="html">
    
    <multiselect
        v-model="seleccionada"
        :id="$options.name"
        :options="juridicas"
        :multiple="$options.static.multiple"
        :track-by="$options.static.trackBy"
        :custom-label="juridicaConCuit"
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
        @search-change="buscarJuridicas"
        @input="input"
    >
        <template slot="maxElements">
            Haz llegado al máximo permitido de opciones seleccionadas. Primero quite una opción seleccionada para elegir otra.
        </template>
        
        <template slot="noResult">
            No se encontraron registros que coincidan con tu búsqueda.
        </template>
    </multiselect>
    
</template>

<script>
/**
 * Mixins
 */
import MultiselectConfigMixin from '../../mixins/multiselect_config_mixin.js';
import FiltroCuitMixin        from '../../mixins/persona_juridica/filtro_cuit_mixin.js';

export default {
    name: 'vc-select-juridica',
    mixins: [
        MultiselectConfigMixin,
        FiltroCuitMixin
    ],
    props: {
        juridicas: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            seleccionada: [],
            estaCargando: false
        }
    },
    watch: {
        juridicas: function() {
            this.estaCargando = false;
        }
    },
    static: {
        multiple: false,
        trackBy: 'id'
    },
    methods: {
        buscarJuridicas(valorBuscado) {
            this.estaCargando = true;
            this.$emit('buscar', valorBuscado);
        },
        
        juridicaConCuit({ denominacion, cuit }) {
            let cuitConFormato = this.$options.filters.formatoCuit(cuit);
            return `${denominacion} (${cuitConFormato})`;
        },
        
        input(seleccionada) {
            this.$emit('input', seleccionada);
        }
    }
}
</script>

<style lang="css">
</style>
