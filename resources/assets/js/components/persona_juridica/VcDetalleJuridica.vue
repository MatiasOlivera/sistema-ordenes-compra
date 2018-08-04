<template lang="html">
    
    <base-perfil
        :titulo="titulo"
        :nombreInstancia="juridica.denominacion"
        :eliminado="eliminado"
        @editar="editar"
        @dar-de-baja="darDeBaja"
        @dar-de-alta="darDeAlta"
        @cerrar="cerrar"
    >
    
        <dl>
            <dt>Denominación:</dt>
            <dd>{{ juridica.denominacion }}</dd>
            
            <dt>CUIT:</dt>
            <dd>{{ juridica.cuit | formatoCuit }}</dd>
            
            <dt>Tipo de organización:</dt>
            <dd>{{ juridica.tipo_organizacion.descripcion }}</dd>
            
            <dt>Creado:</dt>
            <dd>
                {{ juridica.created_at | moment('from') }}, 
                {{ juridica.created_at | moment('L LT a') }}
            </dd>
            
            <dt>Actualizado:</dt>
            <dd>
                {{ juridica.updated_at | moment('from') }}, 
                {{ juridica.updated_at | moment('L LT a') }}
            </dd>
            
            <template v-if="eliminado">
                <dt>Eliminado:</dt>
                <dd>
                    {{ juridica.deleted_at | moment('from') }}, 
                    {{ juridica.deleted_at | moment('L LT a') }}
                </dd>
            </template>
            
        </dl>
        
    </base-perfil>
    
</template>

<script>
/**
 * Mixins
 */
 import DarBajaInstanciaMixin from '../../mixins/dar_baja_instancia_mixin.js';
 import DarAltaInstanciaMixin from '../../mixins/dar_alta_instancia_mixin.js';
 import FiltroCuitMixin       from '../../mixins/persona_juridica/filtro_cuit_mixin.js';
 
/**
 * Componentes
 */
import BasePerfil from '../../components/BasePerfil.vue';


export default {
    name: 'vc-detalle-juridica',
    mixins: [
        DarBajaInstanciaMixin,
        DarAltaInstanciaMixin,
        FiltroCuitMixin
    ],
    components: { BasePerfil },
    props: {
        juridica: {
            type: Object,
            required: true
        }
    },
    computed: {
        titulo() {
            return `Perfil de ${this.juridica.denominacion}`;
        },
        
        eliminado() {
            return ! _.isNull(this.juridica.deleted_at);
        }
    },
    static: {
        url: {
            juridicas: '/juridicas'
        }
    },
    methods: {
        editar() {
            this.$emit('editar');
        },
        
        cerrar() {
            this.$emit('cerrar');
        },
        
        darDeBaja() {
            this.$_darBajaInstanciaMixin_eliminar(
                `${this.$options.static.url.juridicas}/${this.id}`,
                () => {
                    this.$emit('dar-de-baja');
                    BusEventos.$emit('VcPerfilJuridica:eliminada')
                }
            );
        },
        
        darDeAlta() {
            this.$_darAltaInstanciaMixin_restaurar(
                `${this.$options.static.url.juridicas}/${this.id}/restore`,
                () => {
                    this.$emit('dar-de-alta');
                    BusEventos.$emit('VcPerfilJuridica:restaurada')
                }
            )
        }
    }
}
</script>

<style lang="css">
</style>
