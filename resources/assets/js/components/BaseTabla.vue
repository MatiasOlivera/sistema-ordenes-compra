<template lang="html">

    <v-server-table
        :ref="nombre"
        :name="nombre"
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
    
        <template slot="perfil" slot-scope="{ row: {id} }">
            <button @click="verPerfil(id)" type="button" name="perfil"
            class="btn btn-sm btn-outline-info">
                <info-icon class="icono"></info-icon> Perfil
            </button>
        </template>

        <template slot="editar" slot-scope="{ row: {id} }">
            <vc-boton-editar @click.native="editar(id)"></vc-boton-editar>
        </template>

        <template slot="baja" slot-scope="{ row: fila }">
            <vc-boton-baja
                :nombre="fila[campoNombre]"
                @confirmado="darDeBaja(fila.id)"
            >
            </vc-boton-baja>
        </template>
        
        <template slot="alta" slot-scope="{ row: fila }">
            <vc-boton-alta
                :nombre="fila[campoNombre]"
                @confirmado="darDeAlta(fila.id)"
            >
            </vc-boton-alta>
        </template>
    </v-server-table>

</template>

<script>
import { InfoIcon } from 'vue-feather-icons';
import VcBotonEditar from '../components/VcBotonEditar.vue';
import VcBotonBaja from '../components/VcBotonBaja.vue';
import VcBotonAlta from '../components/VcBotonAlta.vue';

export default {
    components: {
        InfoIcon,
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
            const porDefecto = ['perfil', 'editar', 'baja'];

            /**
             * Ocultar las columnas editar y eliminar
             * cuando se ven los registros eliminados
             */
            if (this.soloEliminados) {
                porDefecto.splice(1, 2);
                porDefecto.push('alta');
            }
            
            return especificas.concat(porDefecto);
        },
        
        todasOpciones() {
            let opcionesPorDefecto = {
                requestFunction: (data) => {
                    let binario = this.soloEliminados ? 1 : 0;
                    let eliminados = { soloEliminados: binario };
                    
                    let parametros = { ...data, ...eliminados };
                    
                    return axios.get(this.url, {
                        params: parametros
                    }).catch(function (error) {
                        this.dispatch('error', error);
                    }.bind(this));
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
