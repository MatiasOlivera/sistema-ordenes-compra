<template lang="html">
    
    <multiselect
        v-model="seleccionado"
        :id="$options.name"
        :options="actividades"
        :multiple="$options.static.multiple"
        :track-by="$options.static.trackBy"
        :label="$options.static.label"
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
        @search-change="buscarActividades"
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


export default {
    name: 'vc-select-actividad',
    mixins: [ MultiselectConfigMixin ],
    props: {
        actividades: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            seleccionado: [],
            estaCargando: false
        }
    },
    watch: {
        actividades: function() {
            this.estaCargando = false;
        }
    },
    static: {
        multiple: false,
        trackBy: 'id',
        label: 'descripcion'
    },
    methods: {
        buscarActividades(valorBuscado) {
            this.estaCargando = true;
            this.$emit('buscar', valorBuscado);
        },
        
        input(seleccionado) {
            this.$emit('input', seleccionado);
        }
    }
}
</script>

<style lang="css">
</style>
