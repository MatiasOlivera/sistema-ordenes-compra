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
            :empresa="empresaParaEditar"
            @actualizado="actualizada"
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
        
        <!-- Actividades económicas -->
        <vc-tarjeta-actividades
            :actividadesNoAsociadas="actividadesNoAsociadas"
            :actividades="empresa.actividades"
            :mensaje="$options.static.tarjetaActividades.mensaje"
            @buscar="buscarActividad"
            @dar-de-alta="darDeAltaActividad"
            @dar-de-baja="darDeBajaActividad"
        >
        </vc-tarjeta-actividades>
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
import VcDetalleEmpresa     from './VcDetalleEmpresa.vue';
import VcFormEmpresa        from './VcFormEmpresa.vue';
import VcTarjetaJuridicas   from '../persona_juridica/VcTarjetaJuridicas.vue';
import VcTarjetaActividades from '../actividad_economica/VcTarjetaActividades.vue';

export default {
    name: 'vc-perfil-empresa',
    mixins: [ ObtenerInstanciaMixin ],
    components: {
        VcDetalleEmpresa,
        VcFormEmpresa,
        VcTarjetaJuridicas,
        VcTarjetaActividades
    },
    data() {
        return {
            id: null,
            empresa: {
                nombre_fantasia: '',
                es_mayorista: false,
                created_at: new Date(),
                updated_at: new Date(),
                deleted_at: new Date(),
                juridicas: [],
                actividades: []
            },
            juridicasNoAsociadas: [],
            actividadesNoAsociadas: [],
            ui: {
                detalle: {
                    visible: true
                }
            }
        }
    },
    computed: {
        empresaParaEditar() {
            return _.pick(this.empresa, ['id', 'nombre_fantasia', 'es_mayorista']);
        }
    },
    watch: {
        id: function(id) {
            if (id !== null) this.obtener();
        }
    },
    created() {        
        BusEventos.$on('VcTablaEmpresas:verPerfil', (id) => {
            this.setID(id);
            this.verEmpresa();
        });
        
        BusEventos.$on('VcTablaEmpresas:editar', (id) => {
            this.setID(id);
            this.editarEmpresa();
        });
        
        BusEventos.$on('VcTablaEmpresas:restaurada', (id) => { this.actualizar(id) });
    },
    static: {
        url: {
            empresas: '/empresas',
            juridicas: '/juridicas',
            actividades: '/actividades-economicas'
        },
        tarjetaJuridicas: {
            mensaje: 'No existen personas jurídicas asociadas a esta empresa'
        },
        tarjetaActividades: {
            mensaje: 'Todavía no han sido cargados los rubros a los que se dedica esta empresa'
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
        
        actualizada() {
            this.obtener();
            this.verEmpresa();
        },
        
        obtener() {
            this.$_obtenerInstanciaMixin_obtener(
                `${this.$options.static.url.empresas}/${this.id}`,
                (response) => { this.empresa = response.data }
            );
        },
        
        editarEmpresa() {
            this.ui.detalle.visible = false;
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
        },
        
        buscarActividad(valorBuscado) {
            axios.get(this.$options.static.url.actividades, {
                params: {
                    busqueda: valorBuscado,
                    limite: 10,
                    pagina: 1,
                    ordenarPor: 'descripcion',
                    ascendente: 1,
                    soloEliminados: 0,
                    empresaId: this.empresa.id
                }
            })
            .then((response) => {
                let actividades = response.data.data;
                this.actividadesNoAsociadas = actividades;
            })
            .catch((error) => {
                if (error.response) {
                    let status = error.response.status;
    
                    switch (status) {
                        case 404:
                            this.error({
                                title: 'No encontrados',
                                message: 'No se ha encontrado ningún rubro'
                            });
    
                            break;
                        default:
                            this.error({
                                title: 'Error',
                                message: 'No se pudo traer los rubros'
                            });
                    }
                }
            })
        },
        
        darDeAltaActividad(id) {
            if (!_.isNull(id) && !_.isUndefined(id)) {
                const url = `${this.$options.static.url.empresas}/${this.id}/actividades/${id}`;
                
                axios.post(url)
                .then((response) => {
                    if (response.status === 201) {
                        this.exito({
                            message: response.data.mensaje
                        });
                    }
                })
                .catch((error) => {
                    if (error.response && error.response.status === 400) {
                        this.error({
                            message: error.response.data.mensaje
                        });
                    }
                })
                .finally(() => {
                    this.obtener();
                });
            }
        },
        
        darDeBajaActividad(id) {
            if (!_.isNull(id) && !_.isUndefined(id)) {
                const url = `${this.$options.static.url.empresas}/${this.id}/actividades/${id}`;
                
                axios.delete(url)
                .then((response) => {
                    if (response.status === 200) {
                        this.exito({
                            message: response.data.mensaje
                        });
                    }
                })
                .catch((error) => {
                    if (error.response && error.response.status === 400) {
                        this.error({
                            message: error.response.data.mensaje
                        });
                    }
                })
                .finally(() => {
                    this.obtener();
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
