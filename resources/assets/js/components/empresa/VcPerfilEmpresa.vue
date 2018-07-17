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
        <dl>
            <dt>Nombre de fantasía:</dt>
            <dd>{{ empresa.nombre_fantasia }}</dd>
            
            <dt>Es mayorista:</dt>
            <dd>
                <check-icon
                    v-if="empresa.es_mayorista === 1"
                    class="icono"
                >
                </check-icon>
                <x-icon
                    v-else
                    class="icono"
                >
                </x-icon>
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
    </base-perfil>
    
</template>

<script>
import { CheckIcon, XIcon }  from 'vue-feather-icons';
import BasePerfil            from '../../components/BasePerfil.vue';
import ObtenerInstanciaMixin from '../../mixins/obtener_instancia_mixin.js';
import DarBajaInstanciaMixin from '../../mixins/dar_baja_instancia_mixin.js';
import DarAltaInstanciaMixin from '../../mixins/dar_alta_instancia_mixin.js';

export default {
    name: 'vc-perfil-empresa',
    components: {
        BasePerfil,
        CheckIcon,
        XIcon
    },
    mixins: [
        ObtenerInstanciaMixin,
        DarBajaInstanciaMixin,
        DarAltaInstanciaMixin
    ],
    data() {
        return {
            id: null,
            empresa: null
        }
    },
    computed: {
        titulo() {
            return `Perfil de ${this.empresa.nombre_fantasia}`;
        },
                
        eliminado() {
            return _.isNull(this.empresa.deleted_at) ? false : true;
        },
        
        urlEspecifica() {
            return `${this.$options.static.url.empresas}/${this.id}`;
        }
    },
    watch: {
        id: function(id) {
            if (id !== null) this.obtener();
        }
    },
    created() {
        this.resetearEmpresa();
        
        BusEventos.$on('VcTablaEmpresas:verPerfil', (id) => { this.setID(id) });
        BusEventos.$on('VcTablaEmpresas:restaurada', (id) => { this.actualizar(id) });
        BusEventos.$on('VcFormEmpresa:guardada', (id) => { this.actualizar(id) });
    },
    static: {
        url: {
            empresas: '/empresas'
        },
        
        empresaPorDefecto: {
            nombre_fantasia: '',
            es_mayorista: null,
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
                (response) => { this.empresa = response.data }
            );
        },
        
        editar() {
            BusEventos.$emit('VcPerfilEmpresa:editar', this.id);
            this.$emit('mostrar-form');
        },
        
        darDeBaja() {
            this.$_darBajaInstanciaMixin_eliminar(
                this.urlEspecifica,
                () => {
                    this.obtener();
                    BusEventos.$emit('VcPerfilEmpresa:eliminada')
                }
            );
        },
        
        darDeAlta() {
            this.$_darAltaInstanciaMixin_restaurar(
                `${this.urlEspecifica}/restore`,
                () => {
                    this.obtener();
                    BusEventos.$emit('VcPerfilEmpresa:restaurada')
                }
            )
        },
        
        cerrar() {
            this.$emit('cerrar');
        },
        
        resetearEmpresa() {
            this.empresa = { ...this.$options.static.empresaPorDefecto };
        }
    }
}
</script>

<style lang="css">
</style>