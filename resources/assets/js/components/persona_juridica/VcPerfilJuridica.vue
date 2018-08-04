<template lang="html">
    
    <div>
        <!-- Detalle de la persona jurídica -->
        <vc-detalle-juridica
            v-show="ui.detalle.visible"
            :juridica="juridica"
            @editar="editarJuridica"
            @dar-de-baja="obtener"
            @dar-de-alta="obtener"
            @cerrar="cerrar"
        >
        </vc-detalle-juridica>
        
        <vc-form-juridica
            v-show="!ui.detalle.visible"
            @cerrar="verJuridica"
        >
        </vc-form-juridica>
    </div>
    
</template>

<script>
/**
 * Mixins
 */
import ObtenerInstanciaMixin from '../../mixins/obtener_instancia_mixin.js';

/**
 * Componentes
 */
import VcDetalleJuridica from './VcDetalleJuridica.vue';
import VcFormJuridica    from './VcFormJuridica.vue';


export default {
    name: 'vc-perfil-juridica',
    mixins: [ ObtenerInstanciaMixin ],
    components: {
        VcDetalleJuridica,
        VcFormJuridica
    },
    data() {
        return {
            id: null,
            juridica: {
                cuit: null,
                denominacion: '',
                tipo_organizacion: {
                    descripcion: ''
                },
                created_at: new Date(),
                updated_at: new Date(),
                deleted_at: new Date()
            },
            ui: {
                detalle: {
                    visible: true
                }
            }
        }
    },
    watch: {
        id: function(id) {
            if (id !== null) this.obtener();
        }
    },
    created() {
        BusEventos.$on('VcTablaJuridicas:verPerfil', (id) => { this.setID(id) });
        BusEventos.$on('VcTablaJuridicas:restaurada', (id) => { this.actualizar(id) });
        BusEventos.$on('VcFormJuridica:guardada', (id) => { this.actualizar(id) });
    },
    static: {
        url: {
            juridicas: '/juridicas'
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
                `${this.$options.static.url.juridicas}/${this.id}`,
                (response) => { this.juridica = response.data }
            );
        },
        
        editarJuridica() {
            this.ui.detalle.visible = false;
            BusEventos.$emit('VcPerfilJuridica:editar', this.id);
        },
        
        verJuridica() {
            this.ui.detalle.visible = true;
        },
        
        cerrar() {
            this.$emit('cerrar');
        }
    },
    notifications: {
        exito: {
            title: 'Exito',
            message: '',
            type: 'success'
        },
        error: {
            title: 'Error',
            message: '',
            type: 'error'
        }
    }
}
</script>

<style lang="css">
</style>
