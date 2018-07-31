<template lang="html">
    
    <div>
        <!-- Detalle de la empresa -->
        <vc-detalle-empresa
            v-show="ui.detalle.visible"
            :empresa="empresa"
            @editar="editarEmpresa"
            @dar-de-baja="obtener"
            @dar-de-alta="obtener"
            @alta-proveedor="obtener"
            @baja-proveedor="obtener"
            @cerrar="cerrar"
        >
        </vc-detalle-empresa>
        
        <vc-form-empresa
            v-show="!ui.detalle.visible"
            @cerrar="verEmpresa"
        >
        </vc-form-empresa>
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
import VcDetalleEmpresa from './VcDetalleEmpresa.vue';
import VcFormEmpresa    from './VcFormEmpresa';

export default {
    name: 'vc-perfil-empresa',
    mixins: [ ObtenerInstanciaMixin ],
    components: {
        VcDetalleEmpresa,
        VcFormEmpresa
    },
    data() {
        return {
            id: null,
            empresa: {
                nombre_fantasia: '',
                es_mayorista: null,
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
        BusEventos.$on('VcTablaEmpresas:verPerfil', (id) => { this.setID(id) });
        BusEventos.$on('VcTablaEmpresas:restaurada', (id) => { this.actualizar(id) });
        BusEventos.$on('VcFormEmpresa:guardada', (id) => { this.actualizar(id) });
    },
    static: {
        url: {
            empresas: '/empresas'
        },
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
                `${this.$options.static.url.empresas}/${this.id}`,
                (response) => { this.empresa = response.data }
            );
        },
        
        editarEmpresa() {
            this.ui.detalle.visible = false;
            BusEventos.$emit('VcPerfilEmpresa:editar', this.id);
        },
        
        verEmpresa() {
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
