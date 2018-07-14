<template lang="html">
    
    <base-perfil
        :titulo="titulo"
        :nombreInstancia="tipo.descripcion"
        :eliminado="eliminado"
        @editar="editar"
        @dar-de-baja="darDeBaja"
        @dar-de-alta="darDeAlta"
        @cerrar="cerrar"
    >
        <dl>
            <dt>Descripcion:</dt>
            <dd>{{ tipo.descripcion }}</dd>
            
            <dt>Creado:</dt>
            <dd>
                {{ tipo.created_at | moment('from') }}, 
                {{ tipo.created_at | moment('L LT a') }}
            </dd>
            
            <dt>Actualizado:</dt>
            <dd>
                {{ tipo.updated_at | moment('from') }}, 
                {{ tipo.updated_at | moment('L LT a') }}
            </dd>
            
            <template v-if="eliminado">
                <dt>Eliminado:</dt>
                <dd>
                    {{ tipo.deleted_at | moment('from') }}, 
                    {{ tipo.deleted_at | moment('L LT a') }}
                </dd>
            </template>
        </dl>
    </base-perfil>
    
</template>

<script>
import BasePerfil            from '../../components/BasePerfil.vue';
import ObtenerInstanciaMixin from '../../mixins/obtener_instancia_mixin.js';
import DarBajaInstanciaMixin from '../../mixins/dar_baja_instancia_mixin.js';
import DarAltaInstanciaMixin from '../../mixins/dar_alta_instancia_mixin.js';

export default {
    name: 'vc-perfil-tipo-org',
    components: { BasePerfil },
    mixins: [
        ObtenerInstanciaMixin,
        DarBajaInstanciaMixin,
        DarAltaInstanciaMixin
    ],
    data() {
        return {
            id: null,
            tipo: null
        }
    },
    computed: {
        titulo() {
            return `Detalle de ${this.tipo.descripcion}`;
        },
        
        eliminado() {
            return _.isNull(this.tipo.deleted_at) ? false : true;
        },
        
        urlEspecifica() {
            return `${this.$options.static.url.tiposOrganizacion}/${this.id}`;
        }
    },
    watch: {
        id: function(id) {
            if (id !== null) this.obtener();
        }
    },
    created() {
        this.resetearTipo();
        
        BusEventos.$on('VcTablaTipoOrg:verPerfil', (id) => { this.setID(id) });
        BusEventos.$on('VcTablaTipoOrg:restaurado', (id) => { this.actualizar(id) });
        BusEventos.$on('VcFormTipoOrg:guardado', (id) => { this.actualizar(id) });
    },
    static: {
        url: {
            tiposOrganizacion: '/tipos-organizacion'
        },
        
        tipoPorDefecto: {
            descripcion: '',
            created_at: new Date(),
            updated_at: new Date(),
            deleted_at: new Date()
        }
    },
    methods: {
        setID(id) {
            this.id = id;
        },
        
        actualizar(id) {
            if (id !== null && this.id === id) {
                this.obtener();
            }
        },
        
        obtener() {
            this.$_obtenerInstanciaMixin_obtener(
                this.urlEspecifica,
                (response) => { this.tipo = response.data }
            );
        },
        
        editar() {
            BusEventos.$emit('VcPerfilTipoOrg:editar', this.id);
            this.$emit('mostrar-form');
        },
        
        darDeBaja() {
            this.$_darBajaInstanciaMixin_eliminar(
                this.urlEspecifica,
                () => {
                    this.obtener();
                    BusEventos.$emit('VcPerfilTipoOrg:eliminado')
                }
            );
        },
        
        darDeAlta() {
            this.$_darAltaInstanciaMixin_restaurar(
                `${this.urlEspecifica}/restore`,
                () => {
                    this.obtener();
                    BusEventos.$emit('VcPerfilTipoOrg:restaurado')
                }
            )
        },
        
        cerrar() {
            this.$emit('cerrar');
        },
        
        resetearTipo() {
            this.tipo = { ...this.$options.static.tipoPorDefecto };
        }
    }
}
</script>

<style lang="css">
</style>
