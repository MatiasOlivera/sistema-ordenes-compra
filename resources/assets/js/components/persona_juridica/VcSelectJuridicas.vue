<template lang="html">
    
    <multiselect
        v-model="seleccionActual"
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
        @search-change="obtenerJuridicas"
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
import FiltroCuitMixin        from '../../mixins/persona_juridica/filtro_cuit_mixin.js';

export default {
    name: 'vc-select-juridicas',
    mixins: [
        MultiselectConfigMixin,
        FiltroCuitMixin
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
            juridicas: [],
            seleccionActual: [],
            estaCargando: false
        }
    },
    watch: {
        seleccionadas: function(juridicas) {
            this.seleccionActual = juridicas;
        }
    },
    static: {
        url: {
            juridicas: '/juridicas'
        },
        multiple: true,
        trackBy: 'id'
    },
    methods: {
        obtenerJuridicas(busqueda) {
            this.estaCargando = true;
            
            axios.get(this.$options.static.url.juridicas, {
                params: {
                    busqueda: busqueda,
                    limite: 10,
                    pagina: 1,
                    ordenarPor: 'denominacion',
                    ascendente: 1,
                    soloEliminados: 0
                }
            })
            .then((response) => {
                let juridicas = response.data.data;
                this.juridicas = juridicas;
                
                this.estaCargando = false;
            })
            .catch((error) => {
                if (error.response) {
                    let status = error.response.status;

                    switch (status) {
                        case 404:
                            this.error({
                                title: 'No encontrados',
                                message: 'No se ha encontrado ningúna persona jurídica'
                            });

                            break;
                        default:
                            this.error({
                                title: 'Error',
                                message: 'No se pudo traer las personas jurídicas'
                            });
                    }
                }
            })
        },
        
        juridicaConCuit({ denominacion, cuit }) {
            let cuitConFormato = this.$options.filters.formatoCuit(cuit);
            return `${denominacion} (${cuitConFormato})`;
        },
        
        input(seleccionadas) {
            this.$emit('input', seleccionadas);
        }
    }
}
</script>

<style lang="css">
</style>
