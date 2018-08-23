<template lang="html">

    <div>
        <base-tarjeta
            v-if="!tipoOrganizacionForm.visible"
            :titulo="tarjeta.titulo"
            :botonIzqVisible="tarjeta.botonIzqVisible"
            :botonIzqTipo="tarjeta.botonIzqTipo"
            :confirmacionRequerida="fueModificada"
            :confirmacionNotificacion="tarjeta.confirmacion.notificacion"
            @cerrar="cerrar"
        >

            <form @submit.prevent="enviar">
                <fieldset class="form-group">
                    <label for="cuit">CUIT
                        <span
                            v-if="digitosCuit"
                            class="text-muted"
                        >
                            {{ digitosCuit }} - {{ juridica.cuit | formatoCuit }}
                        </span>
                    </label>

                    <input
                        v-model="juridica.cuit"
                        :class="{'is-invalid' : validacion.cuit}"
                        type="text"
                        name="cuit"
                        class="form-control"
                        id="cuit"
                        aria-describedby="cuitAyuda"
                    >

                    <small
                        v-if="!validacion.cuit"
                        id="cuitAyuda"
                        class="form-text text-muted"
                    >
                        El CUIT de la persona jurídica sin puntos ni guiones medios
                    </small>
                    <vc-form-error
                        v-else
                        :error="validacion.cuit"
                    >
                    </vc-form-error>
                </fieldset>

                <fieldset class="form-group">
                    <label for="denominacion">Denominación / Razón social</label>

                    <input
                        v-model="juridica.denominacion"
                        :class="{'is-invalid' : validacion.denominacion}"
                        type="text"
                        name="denominacion"
                        class="form-control"
                        id="denominacion"
                        aria-describedby="denominacionAyuda"
                    >

                    <small
                        v-if="!validacion.denominacion"
                        id="denominacionAyuda"
                        class="form-text text-muted"
                    >
                        La denominación de la organización o razón social registrada en AFIP
                    </small>
                    <vc-form-error
                        v-else
                        :error="validacion.denominacion"
                    >
                    </vc-form-error>
                </fieldset>

                <fieldset>
                    <label for="vc-select-tipo-org">
                        Tipo de organización

                        <plus-icon
                            id="iconoNuevo"
                            class="icono ml-2"
                            @click="mostrarFormTipoOrg"
                        >
                        </plus-icon>
                    </label>

                    <vc-select-tipo-org
                        :tiposOrganizacion="tiposOrganizacion"
                        :tipo="juridica.tipo_organizacion"
                        :error="validacion.tipo_organizacion_id"
                        @buscar="buscarTiposOrganizacion"
                        @input="inputTiposOrganizacion"
                    >
                    </vc-select-tipo-org>
                </fieldset>

                <div class="row mt-4">
                    <div class="col">
                        <vc-boton-submit :disabled="estaCargando">
                        </vc-boton-submit>
                    </div>

                    <div class="col-auto ml-auto">
                        <vc-boton-reset @click.native="restaurar">
                        </vc-boton-reset>
                    </div>
                </div>
            </form>

        </base-tarjeta>

        <vc-form-tipo-org
            v-if="tipoOrganizacionForm.visible"
            @guardado="guardadoFormTipoOrg"
            @cerrar="cerrarFormTipoOrg"
        >
        </vc-form-tipo-org>
    </div>

</template>

<script>
import { apiPersonaJuridica } from '../../common/api/persona_juridica.js';
import { objetoTienePropiedades } from '../../common/components/validadores.js';
import { JURIDICA_POR_DEFECTO, JURIDICA_CLAVES } from '../../common/components/persona_juridica.js';

/**
 * Eventos
 */
import { EVENTO_GUARDADO, EVENTO_ACTUALIZADO } from '../../common/components/eventos_formulario.js';
import { EVENTO_CERRAR } from '../../common/components/eventos_tarjeta.js';

/**
 * Valores por defecto
 */
const VALIDACION_POR_DEFECTO = {
    cuit: null,
    denominacion: null,
    tipo_organizacion_id: null
};

const TARJETA = {
    botonIzqVisible: true,
    confirmacion: {
        notificacion: {
            titulo: 'Cerrar formulario',
            mensaje: 'Se perderán todos los cambios de la persona jurídica que no se hayan guardado. ¿Estás seguro?'
        }
    }
};

const TARJETA_NUEVO = {
    titulo: 'Nueva persona jurídica',
    botonIzqTipo: 'cerrar',
    ...TARJETA
};

const TARJETA_EDITAR = {
    titulo: 'Editar persona jurídica',
    botonIzqTipo: 'volver',
    ...TARJETA
};

/**
 * Componentes
 */
import { PlusIcon } from 'vue-feather-icons';
import BaseTarjeta from '../../components/BaseTarjeta.vue';
import VcFormError from '../../components/VcFormError.vue';
import VcBotonSubmit from '../../components/VcBotonSubmit.vue';
import VcBotonReset from '../../components/VcBotonReset.vue';
import VcFormTipoOrg from '../../components/tipo_organizacion/VcFormTipoOrg.vue';
import VcSelectTipoOrg from '../../components/tipo_organizacion/VcSelectTipoOrg.vue';

/**
 * Mixins
 */
import FiltroCuitMixin from '../../mixins/persona_juridica/filtro_cuit_mixin.js';


export default {
    name: 'vc-form-juridica',
    components: {
        PlusIcon,
        BaseTarjeta,
        VcFormError,
        VcBotonSubmit,
        VcBotonReset,
        VcSelectTipoOrg,
        VcFormTipoOrg
    },
    mixins: [FiltroCuitMixin],
    props: {
        personaJuridica: {
            type: Object,
            validator: function(juridica) {
                return objetoTienePropiedades(juridica, JURIDICA_CLAVES);
            },
            default: function() {
                return JURIDICA_POR_DEFECTO;
            }
        }
    },
    data() {
        return {
            juridica: null,
            validacion: null,
            tarjeta: null,
            estaCargando: false,

            tiposOrganizacion: [],
            tipoOrganizacionForm: {
                visible: false
            }
        }
    },
    computed: {
        esNueva() {
            return _.isEqual(JURIDICA_POR_DEFECTO, this.personaJuridica);
        },

        fueModificada() {
            return !_.isEqual(this.personaJuridica, this.juridica);
        },

        digitosCuit() {
            if (this.juridica.cuit) {
                let cuit = this.juridica.cuit;
                let digitos = cuit.toString().length;
                let numero = digitos === 1 ? 'digito' : 'digitos';
                return `${digitos} ${numero}`;
            }
            return null;
        }
    },
    watch: {
        personaJuridica: {
            immediate: true,
            handler: function(juridica) {
                this.juridica = { ...juridica };
            }
        }
    },
    created() {
        this.tarjeta = this.esNueva ? TARJETA_NUEVO : TARJETA_EDITAR;
        this.resetearValidacion();
    },
    methods: {
        buscarTiposOrganizacion(valorBuscado) {
            axios.get('/tipos-organizacion', {
                params: {
                    busqueda: valorBuscado,
                    limite: 10,
                    pagina: 1,
                    ordenarPor: 'descripcion',
                    ascendente: 1,
                    soloEliminados: 0
                }
            })
            .then((respuesta) => {
                const STATUS = respuesta.status;

                if (STATUS === 200) {
                    this.tiposOrganizacion = respuesta.data.data;
                }
            })
            .catch((error) => {
                if (error.response) {
                    let status = error.response.status;

                    switch (status) {
                        case 404:
                            this.error({
                                title: 'No encontrados',
                                message: 'No se ha encontrado ningún tipo de organización'
                            });

                            break;
                        default:
                            this.error({
                                title: 'Error',
                                message: 'No se pudo traer los tipos de organización'
                            });
                    }
                }
            })
        },

        inputTiposOrganizacion(juridica) {
            let id = null;

            if (_.isObject(juridica) && juridica.hasOwnProperty('id')) {
                this.juridica.tipo_organizacion = juridica;
                id = juridica.id;
            }

            this.juridica.tipo_organizacion_id = id;
        },

        mostrarFormTipoOrg() {
            this.tipoOrganizacionForm.visible = true;
        },

        cerrarFormTipoOrg() {
            this.tipoOrganizacionForm.visible = false;
        },

        guardadoFormTipoOrg(tipoOrganizacion) {
            this.juridica.tipo_organizacion_id = tipoOrganizacion.id;
            this.juridica.tipo_organizacion = tipoOrganizacion;
            this.cerrarFormTipoOrg();
        },

        enviar() {
            if (this.fueModificada) {
                this.estaCargando = true;
                this.esNueva ? this.guardar() : this.actualizar();
            }
        },

        guardar() {
            apiPersonaJuridica.guardar(this.juridica)
                .then((respuesta) => {
                    let status = respuesta.status;

                    if (status === 201) {
                        this.exito(respuesta.notificacion);

                        this.restaurar();

                        this.$emit(EVENTO_GUARDADO);

                        BusEventos.$emit('VcFormJuridica:guardado');
                    }
                })
                .catch(({
                    notificacion,
                    validacion
                }) => {

                    if (validacion) {
                        this.validacion = validacion;
                    }

                    if (notificacion) {
                        this.error(notificacion);
                    }
                })
                .finally(() => {
                    this.estaCargando = false;
                });
        },

        actualizar() {
            apiPersonaJuridica.actualizar(this.juridica.id, this.juridica)
                .then((respuesta) => {
                    let status = respuesta.status;

                    if (status === 200) {
                        this.exito(respuesta.notificacion);

                        this.restaurar();

                        this.$emit(EVENTO_ACTUALIZADO);

                        BusEventos.$emit('VcFormJuridica:guardado');
                    }
                })
                .catch(({
                    notificacion,
                    validacion
                }) => {

                    if (validacion) {
                        this.validacion = validacion;
                    }

                    if (notificacion) {
                        this.error(notificacion);
                    }
                })
                .finally(() => {
                    this.estaCargando = false;
                });
        },

        restaurar() {
            this.resetearJuridica();
            this.resetearValidacion();
        },

        resetearJuridica() {
            this.juridica = { ...this.personaJuridica };
        },

        resetearValidacion() {
            this.validacion = { ...VALIDACION_POR_DEFECTO };
        },

        cerrar() {
            this.restaurar();
            this.$emit(EVENTO_CERRAR);
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

<style lang="css" scoped>
#iconoNuevo {
    margin-bottom: 5px;
}
</style>
