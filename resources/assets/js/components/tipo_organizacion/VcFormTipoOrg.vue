<template lang="html">

    <base-tarjeta
        :titulo="tarjeta.titulo"
        :botonIzqVisible="tarjeta.botonIzqVisible"
        :botonIzqTipo="tarjeta.botonIzqTipo"
        :confirmacionRequerida="fueModificado"
        :confirmacionNotificacion="tarjeta.confirmacion.notificacion"
        @cerrar="cerrar"
    >
        
        <form @submit.prevent="enviar">
            <fieldset class="form-group">
                <label for="descripcion">Descripción</label>
    
                <input
                    v-model="tipo.descripcion"
                    :class="{'is-invalid' : validacion.descripcion}"
                    type="text"
                    name="descripcion"
                    class="form-control"
                    id="descripcion"
                >
                <vc-form-error
                    v-if="validacion.descripcion"
                    :error="validacion.descripcion"
                >
                </vc-form-error>
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
    
</template>

<script>
import { apiTipoOrganizacion }           from '../../common/api/tipo_organizacion.js';
import { objetoTienePropiedades }        from '../../common/components/validadores.js';
import { TIPO_POR_DEFECTO, TIPO_CLAVES } from '../../common/components/tipo_organizacion.js';

/**
 * Eventos
 */
import { EVENTO_GUARDADO, EVENTO_ACTUALIZADO } from '../../common/components/eventos_formulario.js';
import { EVENTO_CERRAR } from '../../common/components/eventos_tarjeta.js';

/**
 * Valores por defecto
 */
const VALIDACION_POR_DEFECTO = {
    descripcion: null
};

const TARJETA = {
    botonIzqVisible: true,
    confirmacion: {
        notificacion: {
            titulo: 'Cerrar formulario',
            mensaje: 'Se perderán todos los cambios del tipo de organización que no se hayan guardado. ¿Estás seguro?'
        }
    }
};

const TARJETA_NUEVO = {
    titulo: 'Nuevo tipo de organización',
    botonIzqTipo: 'cerrar',
    ...TARJETA
};

const TARJETA_EDITAR = {
    titulo: 'Editar tipo de organización',
    botonIzqTipo: 'volver',
    ...TARJETA
};

/**
 * Componentes
 */
import BaseTarjeta   from '../../components/BaseTarjeta.vue';
import VcFormError   from '../../components/VcFormError.vue';
import VcBotonSubmit from '../../components/VcBotonSubmit.vue';
import VcBotonReset  from '../../components/VcBotonReset.vue';


export default {
    name: 'vc-form-tipo-org',
    components: {
        BaseTarjeta,
        VcFormError,
        VcBotonSubmit,
        VcBotonReset
    },
    props: {
        tipoOrganizacion: {
            type: Object,
            validator: function(tipo) {
                return objetoTienePropiedades(tipo, TIPO_CLAVES);
            },
            default: function() {
                return TIPO_POR_DEFECTO;
            }
        }
    },
    data() {
        return {
            tipo: null,
            validacion: null,
            tarjeta: null,
            estaCargando: false
        }
    },
    computed: {
        esNuevo() {
            return _.isEqual(TIPO_POR_DEFECTO, this.tipoOrganizacion);
        },

        fueModificado() {
            return !_.isEqual(this.tipoOrganizacion, this.tipo);
        },
    },
    watch: {
        tipoOrganizacion: {
            immediate: true,
            handler: function(tipo) {
                this.tipo = { ...tipo };
            }
        }
    },
    created() {
        this.tarjeta = this.esNuevo ? TARJETA_NUEVO : TARJETA_EDITAR;
        this.resetearValidacion();
    },
    methods: {
        enviar() {
            if (this.fueModificado) {
                this.estaCargando = true;
                this.esNuevo ? this.guardar() : this.actualizar();
            }
        },

        guardar() {
            apiTipoOrganizacion.guardar(this.tipo)
                .then((respuesta) => {
                    let status = respuesta.status;

                    if (status === 201) {
                        this.exito(respuesta.notificacion);

                        this.restaurar();

                        let ID = respuesta.data.data.id;
                        this.$emit(EVENTO_GUARDADO, ID);

                        BusEventos.$emit('VcFormTipoOrg:guardado');
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
            apiTipoOrganizacion.actualizar(this.tipo.id, this.tipo)
                .then((respuesta) => {
                    let status = respuesta.status;

                    if (status === 200) {
                        this.exito(respuesta.notificacion);

                        this.restaurar();

                        this.$emit(EVENTO_ACTUALIZADO);

                        BusEventos.$emit('VcFormTipoOrg:guardado');
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
            this.tipo = { ...this.tipoOrganizacion };
            this.resetearValidacion();
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

<style lang="css">
</style>
