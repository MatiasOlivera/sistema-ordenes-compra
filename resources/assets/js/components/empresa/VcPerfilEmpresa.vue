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
        
        <!-- Personas jurídicas -->
        <vc-tarjeta-juridicas
            :juridicasNoAsociadas="juridicasNoAsociadas"
            :juridicas="empresa.juridicas"
            :mensaje="$options.static.tarjetaJuridicas.mensaje"
            @buscar="buscarJuridica"
            @dar-de-alta="darDeAltaJuridica"
            @dar-de-baja="darDeBajaJuridica"
        >
        </vc-tarjeta-juridicas>
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
import VcDetalleEmpresa   from './VcDetalleEmpresa.vue';
import VcFormEmpresa      from './VcFormEmpresa';
import VcTarjetaJuridicas from '../persona_juridica/VcTarjetaJuridicas.vue'

export default {
    name: 'vc-perfil-empresa',
    mixins: [ ObtenerInstanciaMixin ],
    components: {
        VcDetalleEmpresa,
        VcFormEmpresa,
        VcTarjetaJuridicas
    },
    data() {
        return {
            id: null,
            empresa: {
                nombre_fantasia: '',
                es_mayorista: null,
                created_at: new Date(),
                updated_at: new Date(),
                deleted_at: new Date(),
                juridicas: []
            },
            juridicasNoAsociadas: [],
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
            empresas: '/empresas',
            juridicas: '/juridicas'
        },
        tarjetaJuridicas: {
            mensaje: 'No existen personas jurídicas asociadas a esta empresa'
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
        },
        
        buscarJuridica(valorBuscado) {
            axios.get(this.$options.static.url.juridicas, {
                params: {
                    busqueda: valorBuscado,
                    limite: 10,
                    pagina: 1,
                    ordenarPor: 'denominacion',
                    ascendente: 1,
                    soloEliminados: 0,
                    empresaId: this.empresa.id
                }
            })
            .then((response) => {
                let juridicas = response.data.data;
                this.juridicasNoAsociadas = juridicas;
            })
            .catch((error) => {
                if (error.response) {
                    let status = error.response.status;

                    switch (status) {
                        case 404:
                            this.error({
                                title: 'No encontrados',
                                message: 'No se ha encontrado ningúna persona jurídica'
                            });

                            break;
                        default:
                            this.error({
                                title: 'Error',
                                message: 'No se pudo traer las personas jurídicas'
                            });
                    }
                }
            })
        },
        
        darDeAltaJuridica(id) {
            if (!_.isNull(id) && !_.isUndefined(id)) {
                axios.post(`/juridicas/${id}/empresas/${this.id}`)
                .then((response) => {
                    if (response.status === 201) {
                        this.exito({
                            message: response.data.mensaje
                        });
                        
                        this.obtener();
                    }
                })
                .catch((error) => {
                    if (error.response && error.response.status === 400) {
                        this.error({
                            message: error.response.data.mensaje
                        });
                    }
                });
            }
        },
        
        darDeBajaJuridica(id) {
            if (!_.isNull(id) && !_.isUndefined(id)) {
                axios.delete(`/juridicas/${id}/empresas/${this.id}`)
                .then((response) => {
                    if (response.status === 200) {
                        this.exito({
                            message: response.data.mensaje
                        });
                        
                        this.obtener();
                    }
                })
                .catch((error) => {
                    if (error.response && error.response.status === 400) {
                        this.error({
                            message: error.response.data.mensaje
                        });
                    }
                });
            }
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
