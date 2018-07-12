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
            <dt>CUIT:</dt>
            <dd>{{ juridica.cuit | formatoCuit }}</dd>
            
            <dt>Tipo de organización:</dt>
            <dd>
                <template v-if="juridica.tipo_organizacion">
                    {{ juridica.tipo_organizacion.descripcion }}
                </template>
            </dd>
            
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
import BasePerfil from '../../components/BasePerfil.vue';
import ObtenerInstanciaMixin from '../../mixins/obtener_instancia_mixin.js';
import DarBajaInstanciaMixin from '../../mixins/dar_baja_instancia_mixin.js';
import DarAltaInstanciaMixin from '../../mixins/dar_alta_instancia_mixin.js';
import FiltroCuitMixin from '../../mixins/persona_juridica/filtro_cuit_mixin.js';

export default {
    name: 'vc-perfil-juridica',
    components: { BasePerfil },
    mixins: [
        ObtenerInstanciaMixin,
        DarBajaInstanciaMixin,
        DarAltaInstanciaMixin,
        FiltroCuitMixin
    ],
    data() {
        return {
            id: null,
            juridica: null
        }
    },
    computed: {
        titulo() {
            return `Perfil de ${this.juridica.denominacion}`;
        },
        
        eliminado() {
            return _.isNull(this.juridica.deleted_at) ? false : true;
        },
        
        urlEspecifica() {
            return `${this.$options.static.url.juridicas}/${this.id}`;
        }
    },
    watch: {
        id: function(id) {
            if (id !== null) this.obtener();
        }
    },
    created() {
        this.resetearJuridica();
        
        BusEventos.$on('VcTablaJuridicas:verPerfil', (id) => { this.setID(id) });
        BusEventos.$on('VcTablaJuridicas:restaurada', (id) => { this.actualizar(id) });
        BusEventos.$on('VcFormJuridica:guardada', (id) => { this.actualizar(id) });
    },
    static: {
        url: {
            juridicas: '/juridicas'
        },
        
        juridicaPorDefecto: {
            cuit: null,
            denominacion: '',
            tipo_organizacion: {
                descripcion: null
            },
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
                (response) => { this.juridica = response.data }
            );
        },
        
        editar() {
            BusEventos.$emit('VcPerfilJuridica:editar', this.id);
            this.$emit('mostrar-form');
        },
        
        darDeBaja() {
            this.$_darBajaInstanciaMixin_eliminar(
                this.urlEspecifica,
                () => {
                    this.obtener();
                    BusEventos.$emit('VcPerfilJuridica:eliminada')
                }
            );
        },
        
        darDeAlta() {
            this.$_darAltaInstanciaMixin_restaurar(
                `${this.urlEspecifica}/restore`,
                () => {
                    this.obtener();
                    BusEventos.$emit('VcPerfilJuridica:restaurada')
                }
            )
        },
        
        cerrar() {
            this.$emit('cerrar');
        },
        
        resetearJuridica() {
            this.juridica = { ...this.$options.static.juridicaPorDefecto };
        }
    }
}
</script>

<style lang="css">
</style>
