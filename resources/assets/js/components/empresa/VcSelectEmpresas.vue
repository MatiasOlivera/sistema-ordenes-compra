<template lang="html">
    
    <multiselect
        v-model="seleccionActual"
        :id="$options.name"
        :options="empresas"
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
        @search-change="obtenerEmpresas"
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
import MultiselectConfigMixin from '../../mixins/multiselect_config_mixin.js';

export default {
    name: 'vc-select-empresas',
    mixins: [
        MultiselectConfigMixin
    ],
    props: {
        seleccionadas: {
            type: Array,
            default: function() {
                return [];
            }
        }
    },
    data() {
        return {
            empresas: [],
            seleccionActual: [],
            estaCargando: false
        }
    },
    watch: {
        seleccionadas: function(empresas) {
            this.seleccionActual = empresas;
        }
    },
    static: {
        url: {
            empresas: '/empresas'
        },
        multiple: true,
        trackBy: 'id',
        label: 'nombre_fantasia'
    },
    methods: {
        obtenerEmpresas(busqueda) {
            this.estaCargando = true;
            
            axios.get(this.$options.static.url.empresas, {
                params: {
                    busqueda: busqueda,
                    limite: 10,
                    pagina: 1,
                    ordenarPor: 'nombre_fantasia',
                    ascendente: 1,
                    soloEliminados: 0
                }
            })
            .then((response) => {
                let empresas = response.data.data;
                this.empresas = empresas;
                
                this.estaCargando = false;
            })
            .catch((error) => {
                if (error.response) {
                    let status = error.response.status;

                    switch (status) {
                        case 404:
                            this.error({
                                title: 'No encontrados',
                                message: 'No se ha encontrado ningúna empresa'
                            });

                            break;
                        default:
                            this.error({
                                title: 'Error',
                                message: 'No se pudo traer las empresas'
                            });
                    }
                }
            })
        },
        
        input(seleccionadas) {
            this.$emit('input', seleccionadas);
        }
    }
}
</script>

<style lang="css">
</style>
