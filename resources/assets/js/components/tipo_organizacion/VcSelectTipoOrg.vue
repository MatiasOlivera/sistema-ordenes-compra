<template lang="html">
    
    <div>
        <multiselect
            v-model="seleccionado"
            :id="$options.name"
            :options="tiposOrganizacion"
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
            @search-change="buscarTiposOrganizacion"
            @input="input"
            >
            <template slot="maxElements">
                Haz llegado al máximo permitido de opciones seleccionadas. Primero quite una opción seleccionada para elegir otra.
            </template>
            
            <template slot="noResult">
                No se encontraron registros que coincidan con tu búsqueda.
            </template>
        </multiselect>
        
        <div v-if="error">
            <p class="small text-danger">{{ error }}</p>
        </div>
    </div>
    
</template>

<script>
/**
 * Mixins
 */
import MultiselectConfigMixin from '../../mixins/multiselect_config_mixin.js';


export default {
    name: 'vc-select-tipo-org',
    mixins: [ MultiselectConfigMixin ],
    props: {
        tiposOrganizacion: {
            type: Array,
            required: true
        },
        
        tipo: {
            type: Object,
            default: null
        },
        
        error: {
            type: String
        }
    },
    data() {
        return {
            seleccionado: [],
            estaCargando: false,
            placeholder: 'Selecciona un tipo de organización',
            multiple: false,
            trackBy: 'id',
            label: 'descripcion'
        }
    },
    watch: {
        tiposOrganizacion: function() {
            this.estaCargando = false;
        },
        
        tipo: {
            immediate: true,
            handler: function(tipo) {
                if (_.isObject(tipo)) this.seleccionado = [ tipo ];
            }
        }
    },
    methods: {
        buscarTiposOrganizacion(valorBuscado) {
            if (!this.estaCargando) {
                this.estaCargando = true;
                this.$emit('buscar', valorBuscado);
            }
        },
        
        input(seleccionado) {
            this.$emit('input', seleccionado);
        }
    }
}
</script>

<style lang="css">
</style>
