<template lang="html">

    <v-server-table
        :ref="nombre"
        :name="nombre"
        :url="url"
        :columns="todasColumnas"
        :options="todasOpciones"
    >
        <template slot="afterFilter">
            <div class="custom-control custom-checkbox ml-3">
                <input
                    v-model="soloEliminados"
                    type="checkbox"
                    class="custom-control-input"
                    id="eliminados"
                >
                <label class="custom-control-label" for="eliminados">
                    Solo eliminados
                </label>
            </div>
            
            <slot name="filtros"></slot>
        </template>
    
        <template slot="acciones" slot-scope="{ row: fila, row: {id} }">
            <vc-boton-info
                @click.native="verPerfil(id)"
            >
            </vc-boton-info>
                                    
            <vc-boton-editar
                @click.native="editar(id)"
            >
            </vc-boton-editar>
            
            <vc-boton-alta
                v-if="soloEliminados"
                :nombre="fila[campoNombre]"
                @confirmado="darDeAlta(fila.id)"
            >
            </vc-boton-alta>
            
            <vc-boton-baja
                v-else
                :nombre="fila[campoNombre]"
                @confirmado="darDeBaja(fila.id)"
            >
            </vc-boton-baja>
        </template>
    </v-server-table>

</template>

<script>
import VcBotonInfo   from '../components/VcBotonInfo.vue';
import VcBotonEditar from '../components/VcBotonEditar.vue';
import VcBotonBaja   from '../components/VcBotonBaja.vue';
import VcBotonAlta   from '../components/VcBotonAlta.vue';

export default {
    components: {
        VcBotonInfo,
        VcBotonEditar,
        VcBotonBaja,
        VcBotonAlta
    },
    props: {
        nombre: {
            type: String,
            required: true
        },
        
        url: {
            type: String,
            required: true
        },
        
        columnas: {
            type: Array,
            required: true
        },
        
        opciones: {
            type: Object,
            required: true
        },
        
        obtenerTabla: {
            type: Boolean,
            default: false
        },
        
        campoNombre: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            soloEliminados: false
        }
    },
    computed: {
        todasColumnas() {
            const especificas = this.columnas;
            const porDefecto = ['acciones'];
            return especificas.concat(porDefecto);
        },
        
        todasOpciones() {
            let opcionesPorDefecto = {
                requestAdapter: (data) => {
                    let binario = this.soloEliminados ? 1 : 0;
                    data.soloEliminados = binario;
                    
                    return data;
                }
            };
            
            return {...opcionesPorDefecto, ...this.opciones};
        }
    },
    watch: {
        obtenerTabla(estado) {
            if (estado) this.obtenerModelos();
        },
        
        soloEliminados() {
            this.obtenerModelos();
        }
    },
    methods: {
        verPerfil(id) {
            this.$emit('ver-perfil', id);
        },
        
        editar(id) {
            this.$emit('editar', id);
        },
        
        darDeBaja(id) {
            this.$emit('dar-de-baja', id);
        },
        
        darDeAlta(id) {
            this.$emit('dar-de-alta', id);
        },
        
        obtenerModelos() {
            this.$refs[this.nombre].getData();
        }
    }
}
</script>

<style lang="css">
</style>
