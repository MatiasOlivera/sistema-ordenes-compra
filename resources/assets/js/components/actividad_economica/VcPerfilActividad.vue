<template lang="html">
    
    <base-perfil
        :titulo="titulo"
        :nombreInstancia="actividad.descripcion"
        :eliminado="eliminado"
        @editar="editar"
        @dar-de-baja="darDeBaja"
        @dar-de-alta="darDeAlta"
        @cerrar="cerrar"
    >
        <dl>
            <dt>Descripcion:</dt>
            <dd>{{ actividad.descripcion }}</dd>
            
            <dt>Creado:</dt>
            <dd>
                {{ actividad.created_at | moment('from') }}, 
                {{ actividad.created_at | moment('L LT a') }}
            </dd>
            
            <dt>Actualizado:</dt>
            <dd>
                {{ actividad.updated_at | moment('from') }}, 
                {{ actividad.updated_at | moment('L LT a') }}
            </dd>
            
            <template v-if="eliminado">
                <dt>Eliminado:</dt>
                <dd>
                    {{ actividad.deleted_at | moment('from') }}, 
                    {{ actividad.deleted_at | moment('L LT a') }}
                </dd>
            </template>
        </dl>
    </base-perfil>
    
</template>

<script>
/**
 * Componentes
 */
import BasePerfil            from '../../components/BasePerfil.vue';
import ObtenerInstanciaMixin from '../../mixins/obtener_instancia_mixin.js';
import DarBajaInstanciaMixin from '../../mixins/dar_baja_instancia_mixin.js';
import DarAltaInstanciaMixin from '../../mixins/dar_alta_instancia_mixin.js';


export default {
    name: 'vc-perfil-actividad',
    components: { BasePerfil },
    mixins: [
        ObtenerInstanciaMixin,
        DarBajaInstanciaMixin,
        DarAltaInstanciaMixin
    ],
    data() {
        return {
            id: null,
            actividad: null
        }
    },
    computed: {
        titulo() {
            return `Detalle de ${this.actividad.descripcion}`;
        },
        
        eliminado() {
            return _.isNull(this.actividad.deleted_at) ? false : true;
        },
        
        urlEspecifica() {
            return `${this.$options.static.url.actividades}/${this.id}`;
        }
    },
    watch: {
        id: function(id) {
            if (id !== null) this.obtener();
        }
    },
    created() {
        this.resetearActividad();
        
        BusEventos.$on('VcTablaActividades:verPerfil', (id) => { this.setID(id) });
        BusEventos.$on('VcTablaActividades:restaurado', (id) => { this.actualizar(id) });
        BusEventos.$on('VcFormActividad:guardado', (id) => { this.actualizar(id) });
    },
    static: {
        url: {
            actividades: '/actividades-economicas'
        },
        
        actividadPorDefecto: {
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
                (response) => { this.actividad = response.data }
            );
        },
        
        editar() {
            BusEventos.$emit('VcPerfilActividad:editar', this.id);
            this.$emit('mostrar-form');
        },
        
        darDeBaja() {
            this.$_darBajaInstanciaMixin_eliminar(
                this.urlEspecifica,
                () => {
                    this.obtener();
                    BusEventos.$emit('VcPerfilActividad:eliminado')
                }
            );
        },
        
        darDeAlta() {
            this.$_darAltaInstanciaMixin_restaurar(
                `${this.urlEspecifica}/restore`,
                () => {
                    this.obtener();
                    BusEventos.$emit('VcPerfilActividad:restaurado')
                }
            )
        },
        
        cerrar() {
            this.$emit('cerrar');
        },
        
        resetearActividad() {
            this.actividad = { ...this.$options.static.actividadPorDefecto };
        }
    }
}
</script>

<style lang="css">
</style>
