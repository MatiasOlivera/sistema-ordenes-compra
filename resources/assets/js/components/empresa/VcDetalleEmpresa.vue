<template lang="html">
    
    <base-perfil
        :titulo="titulo"
        :nombreInstancia="empresa.nombre_fantasia"
        :eliminado="eliminado"
        @editar="editar"
        @dar-de-baja="darDeBaja"
        @dar-de-alta="darDeAlta"
        @cerrar="cerrar"
    >
    
        <template slot="acciones">
        
            <button
                v-if="esProveedor"
                @click="bajaProveedor"
                type="button"
                name="bajaProveedor"
                class="btn btn-sm btn-outline-warning"
            >
                <truck-icon class="icono"></truck-icon> Baja proveedor
            </button>
            
            <button
                v-else
                @click="altaProveedor"
                type="button"
                name="altaProveedor"
                class="btn btn-sm btn-outline-primary"
            >
                <truck-icon class="icono"></truck-icon> Alta proveedor
            </button>
        
        </template>
    
        <template>
            
            <dl>
                <dt>Nombre de fantasía:</dt>
                <dd>{{ empresa.nombre_fantasia }}</dd>
                
                <dt>Mayorista:</dt>
                <dd>
                    <vc-icono-estado :estado="empresa.es_mayorista">
                    </vc-icono-estado>
                </dd>
                
                <dt>Proveedor:</dt>
                <dd>
                    <vc-icono-estado :estado="esProveedor">
                    </vc-icono-estado>
                </dd>
                
                <dt>Creado:</dt>
                <dd>
                    {{ empresa.created_at | moment('from') }}, 
                    {{ empresa.created_at | moment('L LT a') }}
                </dd>
                
                <dt>Actualizado:</dt>
                <dd>
                    {{ empresa.updated_at | moment('from') }}, 
                    {{ empresa.updated_at | moment('L LT a') }}
                </dd>
                
                <template v-if="eliminado">
                    <dt>Eliminado:</dt>
                    <dd>
                        {{ empresa.deleted_at | moment('from') }}, 
                        {{ empresa.deleted_at | moment('L LT a') }}
                    </dd>
                </template>
            </dl>
            
        </template>
    
    </base-perfil>
    
</template>

<script>
/**
 * Mixins
 */
 import DarBajaInstanciaMixin from '../../mixins/dar_baja_instancia_mixin.js';
 import DarAltaInstanciaMixin from '../../mixins/dar_alta_instancia_mixin.js';
 
/**
 * Componentes
 */
import { TruckIcon } from 'vue-feather-icons';
import BasePerfil    from '../../components/BasePerfil.vue';
import VcIconoEstado from '../../components/VcIconoEstado.vue';


export default {
    name: 'vc-detalle-empresa',
    mixins: [
        DarBajaInstanciaMixin,
        DarAltaInstanciaMixin
    ],
    components: {
        BasePerfil,
        VcIconoEstado,
        TruckIcon
    },
    props: {
        empresa: {
            type: Object,
            required: true
        }
    },
    computed: {
        titulo() {
            return `Perfil de ${this.empresa.nombre_fantasia}`;
        },
        
        esProveedor() {
            return ! _.isNull(this.empresa.proveedor);
        },
                
        eliminado() {
            return ! _.isNull(this.empresa.deleted_at);
        },
        
        urlEspecifica() {
            return `${this.$options.static.url.empresas}/${this.empresa.id}`;
        }
    },
    static: {
        url: {
            empresas: '/empresas'
        }
    },
    methods: {        
        editar() {
            this.$emit('editar');
        },
        
        altaProveedor() {
            axios.post(`${this.urlEspecifica}/proveedor`)
            .then((response) => {
                this.$emit('alta-proveedor');
                BusEventos.$emit('VcPerfilEmpresa:altaProveedor');
                
                this.exito({
                    title: 'Éxito',
                    message: response.data.mensaje
                });
            })
            .catch((error) => {
                this.error({
                    title: 'Error',
                    message: error.response.data.mensaje
                });
            })
        },
        
        bajaProveedor() {
            this.$_darBajaInstanciaMixin_eliminar(
                `${this.urlEspecifica}/proveedor`,
                () => {
                    this.$emit('baja-proveedor');
                    BusEventos.$emit('VcPerfilEmpresa:bajaProveedor');
                }
            );
        },
        
        darDeBaja() {
            this.$_darBajaInstanciaMixin_eliminar(
                this.urlEspecifica,
                () => {
                    this.$emit('dar-de-baja');
                    BusEventos.$emit('VcPerfilEmpresa:eliminada')
                }
            );
        },
        
        darDeAlta() {
            this.$_darAltaInstanciaMixin_restaurar(
                `${this.urlEspecifica}/restore`,
                () => {
                    this.$emit('dar-de-alta');
                    BusEventos.$emit('VcPerfilEmpresa:restaurada')
                }
            )
        },
        
        cerrar() {
            this.$emit('cerrar');
        }
    }
}
</script>

<style lang="css">
</style>
