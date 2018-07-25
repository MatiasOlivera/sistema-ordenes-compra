<template lang="html">
    
    <base-perfil
        :titulo="titulo"
        :nombreInstancia="rubro.descripcion"
        :eliminado="eliminado"
        @editar="editar"
        @dar-de-baja="darDeBaja"
        @dar-de-alta="darDeAlta"
        @cerrar="cerrar"
    >
        <dl>
            <dt>Descripcion:</dt>
            <dd>{{ rubro.descripcion }}</dd>
            
            <dt>Creado:</dt>
            <dd>
                {{ rubro.created_at | moment('from') }}, 
                {{ rubro.created_at | moment('L LT a') }}
            </dd>
            
            <dt>Actualizado:</dt>
            <dd>
                {{ rubro.updated_at | moment('from') }}, 
                {{ rubro.updated_at | moment('L LT a') }}
            </dd>
            
            <template v-if="eliminado">
                <dt>Eliminado:</dt>
                <dd>
                    {{ rubro.deleted_at | moment('from') }}, 
                    {{ rubro.deleted_at | moment('L LT a') }}
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
    name: 'vc-perfil-rubro',
    components: { BasePerfil },
    mixins: [
        ObtenerInstanciaMixin,
        DarBajaInstanciaMixin,
        DarAltaInstanciaMixin
    ],
    data() {
        return {
            id: null,
            rubro: null
        }
    },
    computed: {
        titulo() {
            return `Detalle de ${this.rubro.descripcion}`;
        },
        
        eliminado() {
            return _.isNull(this.rubro.deleted_at) ? false : true;
        },
        
        urlEspecifica() {
            return `${this.$options.static.url.rubros}/${this.id}`;
        }
    },
    watch: {
        id: function(id) {
            if (id !== null) this.obtener();
        }
    },
    created() {
        this.resetearRubro();
        
        BusEventos.$on('VcTablaRubros:verPerfil', (id) => { this.setID(id) });
        BusEventos.$on('VcTablaRubros:restaurado', (id) => { this.actualizar(id) });
        BusEventos.$on('VcFormRubro:guardado', (id) => { this.actualizar(id) });
    },
    static: {
        url: {
            rubros: '/rubros'
        },
        
        rubroPorDefecto: {
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
                (response) => { this.rubro = response.data }
            );
        },
        
        editar() {
            BusEventos.$emit('VcPerfilRubro:editar', this.id);
            this.$emit('mostrar-form');
        },
        
        darDeBaja() {
            this.$_darBajaInstanciaMixin_eliminar(
                this.urlEspecifica,
                () => {
                    this.obtener();
                    BusEventos.$emit('VcPerfilRubro:eliminado')
                }
            );
        },
        
        darDeAlta() {
            this.$_darAltaInstanciaMixin_restaurar(
                `${this.urlEspecifica}/restore`,
                () => {
                    this.obtener();
                    BusEventos.$emit('VcPerfilRubro:restaurado')
                }
            )
        },
        
        cerrar() {
            this.$emit('cerrar');
        },
        
        resetearRubro() {
            this.rubro = { ...this.$options.static.rubroPorDefecto };
        }
    }
}
</script>

<style lang="css">
</style>
