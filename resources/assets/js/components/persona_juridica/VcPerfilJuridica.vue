<template lang="html">
    
    <div>
        <!-- Detalle de la persona jurídica -->
        <vc-detalle-juridica
            v-show="ui.detalle.visible"
            :juridica="juridica"
            @editar="editar"
            @dado-de-baja="obtener"
            @dado-de-alta="obtener"
            @cerrar="cerrar"
        >
        </vc-detalle-juridica>
        
        <vc-form-juridica
            v-show="!ui.detalle.visible"
            :personaJuridica="juridica"
            @actualizado="actualizada"
            @cerrar="verDetalle"
        >
        </vc-form-juridica>
        
        <!-- Empresas -->
        <vc-tarjeta-empresas
            :empresasNoAsociadas="tarjetaEmpresas.empresas"
            :empresas="juridica.empresas"
            :mensaje="tarjetaEmpresas.mensaje"
            @buscar="buscarEmpresa"
            @dar-de-alta="darDeAltaEmpresa"
            @dar-de-baja="darDeBajaEmpresa"
        >
        </vc-tarjeta-empresas>
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
import VcTarjetaEmpresas from '../empresa/VcTarjetaEmpresas.vue';


export default {
    name: 'vc-perfil-juridica',
    mixins: [ ObtenerInstanciaMixin ],
    components: {
        VcDetalleJuridica,
        VcFormJuridica,
        VcTarjetaEmpresas
    },
    data() {
        return {
            id: null,
            juridica: {
                cuit: null,
                denominacion: '',
                tipo_organizacion_id: null,
                tipo_organizacion: {
                    descripcion: ''
                },
                created_at: new Date(),
                updated_at: new Date(),
                deleted_at: new Date(),
                empresas: []
            },
            tarjetaEmpresas: {
                empresas: [],
                mensaje: 'No existen empresas asociadas a esta persona jurídica'
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
        BusEventos.$on('VcTablaJuridicas:verPerfil', (id) => {
            this.setID(id);
            this.verDetalle();
        });

        BusEventos.$on('VcTablaJuridicas:editar', (id) => {
            this.setID(id);
            this.editar();
        });

        BusEventos.$on('VcTablaJuridicas:eliminada', (id) => {
            this.actualizar(id);
        });

        BusEventos.$on('VcTablaJuridicas:restaurada', (id) => {
            this.actualizar(id);
        });
    },
    static: {
        url: {
            juridicas: '/juridicas',
            empresas: '/empresas'
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
        
        actualizada() {
            this.obtener();
            this.verDetalle();
        },
        
        editar() {
            this.ui.detalle.visible = false;
            BusEventos.$emit('VcPerfilJuridica:editar', this.id);
        },
        
        verDetalle() {
            this.ui.detalle.visible = true;
        },
        
        cerrar() {
            this.$emit('cerrar');
        },
        
        buscarEmpresa(valorBuscado) {
            axios.get(this.$options.static.url.empresas, {
                params: {
                    busqueda: valorBuscado,
                    limite: 10,
                    pagina: 1,
                    ordenarPor: 'nombre_fantasia',
                    ascendente: 1,
                    soloEliminados: 0,
                    juridicaId: this.juridica.id
                }
            })
            .then((response) => {
                let empresas = response.data.data;
                this.tarjetaEmpresas.empresas = empresas;
            })
            .catch((error) => {
                if (error.response) {
                    let status = error.response.status;

                    switch (status) {
                        case 404:
                            this.error({
                                title: 'No encontrados',
                                message: 'No se ha encontrado ningúna empresa'
                            });

                            break;
                        default:
                            this.error({
                                title: 'Error',
                                message: 'No se pudo traer las empresas'
                            });
                    }
                }
            })
        },
        
        darDeAltaEmpresa(id) {
            if (!_.isNull(id) && !_.isUndefined(id)) {
                axios.post(`/juridicas/${this.id}/empresas/${id}`)
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
        
        darDeBajaEmpresa(id) {
            if (!_.isNull(id) && !_.isUndefined(id)) {
                axios.delete(`/juridicas/${this.id}/empresas/${id}`)
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
