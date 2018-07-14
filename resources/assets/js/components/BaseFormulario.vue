<template lang="html">
    
    <form @submit.prevent="guardar">

        <!-- Cabecera -->
        <base-cabecera
            :titulo="titulo"
            @cerrar="cerrar"
        >
        </base-cabecera>

        <!-- Campos -->
        <slot></slot>

        <!-- Botones -->
        <div class="row mt-4">
            <div class="col-auto">
                <button type="submit" name="submit" class="btn btn-primary">
                    <save-icon class="icono"></save-icon> Guardar
                </button>
            </div>

            <div class="col-auto ml-auto">
                <button
                    v-if="id === null"
                    @click.prevent="limpiar"
                    type="reset"
                    name="reset"
                    class="btn btn-secondary"
                >
                    <delete-icon class="icono"></delete-icon> Limpiar
                </button>
                
                <button
                    v-else
                    @click="deshacer"
                    type="button"
                    name="deshacer"
                    class="btn btn-secondary"
                >
                    <rotate-ccw-icon class="icono"></rotate-ccw-icon> Deshacer
                </button>
            </div>
        </div>

    </form>

</template>

<script>
import { SaveIcon, DeleteIcon, RotateCcwIcon } from 'vue-feather-icons';
import BaseCabecera from '../components/BaseCabecera.vue';
import ObtenerInstanciaMixin from '../mixins/obtener_instancia_mixin.js';

export default {
    name: 'base-formulario',
    components: {
        BaseCabecera,
        SaveIcon,
        DeleteIcon,
        RotateCcwIcon
    },
    mixins: [ ObtenerInstanciaMixin ],
    props: {
        titulos: {
            type: Object,
            required: true,
            default: {
                crear: 'Nuevo modelo',
                editar: 'Editar modelo'
            }
        },
        url: {
            type: String,
            required: true
        },
        modelo: {
            type: Object,
            required: true
        },
        modeloPorDefecto: {
            type: Object,
            required: true
        },
        id: {
            type: Number,
            default: null
        },
        mensajes: {
            type: Object,
            required: true,
            default: {
                obtener: {
                    error: {
                        noEncontrado: {
                            titulo: '',
                            mensaje: ''
                        },
                        porDefecto: {
                            titulo: '',
                            mensaje: ''
                        }
                    }
                },
                enviar: {
                    error: {
                        porDefecto: {
                            titulo: '',
                            mensaje: ''
                        }
                    }
                }
            }
        }
    },
    data() {
        return {
            modeloObtenido: {}
        }
    },
    computed: {
        urlEspecifica() {
            return `${this.url}/${this.id}`;
        },
        titulo() {
            return this.id ? this.titulos.editar : this.titulos.crear;
        }
    },
    watch: {
        id: function(id) {
            if (id !== null) this.obtener();
        }
    },
    methods: {
        obtener() {
            this.$_obtenerInstanciaMixin_obtener(
                this.urlEspecifica,
                (response) => {
                    let modelo = response.data;
                    // Crear un nuevo objeto para evitar la reactividad
                    this.modeloObtenido = { ...modelo };
                    this.$emit('obtenido', modelo);
                }
            );
        },
        guardar() {
            let url = '';
            let metodo = '';

            if (!this.modelo.id) {
                url = this.url;
                metodo = 'POST';
            } else {
                url = this.urlEspecifica;
                metodo = 'PUT';
            }

            this.enviar(metodo, url);
        },
        enviar(metodo, url) {
            axios({
                method: metodo,
                url: url,
                data: this.modelo
            })
            .then((response) => {
                let status = response.status;
                let notificacion = {
                    title: '',
                    message: response.data.mensaje
                };

                switch(status) {
                    case 200:
                        notificacion.title = 'Actualizado';
                        break;
                    case 201:
                        notificacion.title = 'Guardado';
                        break;
                    default:
                        break;
                }

                this.exito(notificacion);
                
                let id = null;
                
                if (response.data.hasOwnProperty('data')) {
                    id = response.data.data.id;
                }
                
                this.$emit('guardado', id);
            })
            .catch((error) => {
                let status = error.response.status;
                let porDefecto = this.mensajes.enviar.error.porDefecto;

                switch (status) {
                    case 422:
                        let mensajes = error.response.data.errors;
                        this.$emit('validado', mensajes);
                        break;
                    case 400:
                        var error = error.response.data.mensaje;

                        if (error) {
                            this.error({
                                title: 'Error',
                                message: error
                            });
                        }
                        break;
                    default:
                        this.error({
                            title: porDefecto.titulo,
                            message: porDefecto.mensaje
                        });
                }
            });
        },
        limpiar() {
            this.$emit('limpiar');
        },
        deshacer() {
            // Crear un nuevo objeto para evitar la reactividad
            let modelo = { ...this.modeloObtenido };
            this.$emit('deshacer', modelo);
        },
        emitirCerrar() {
            this.$emit('cerrar');
        },
        cerrar() {
            let iguales = false;

            if (!this.modelo.id) {
                iguales = _.isEqual(this.modeloPorDefecto, this.modelo);
            } else {
                iguales = _.isEqual(this.modeloObtenido, this.modelo);
            }

            if (!iguales) {
                function ocultarNotificacion(instancia, notificacion) {
                    instancia.hide({
                        transitionOut: 'fadeOut'
                    }, notificacion, 'button');
                }

                this.pregunta({
                    title: 'Cerrar formulario',
                    message: 'Se perderán todos los cambios de que no se hayan guardado. ¿Estás seguro?',
                    timeout: false,
                    buttons: [
                        [
                            '<button>Si</button>',
                            (instance, toast) => {
                                ocultarNotificacion(instance, toast);
                                this.emitirCerrar();
                            },
                            true
                        ],
                        [
                            '<button>No</button>',
                            (instance, toast) => {
                                ocultarNotificacion(instance, toast);
                            }
                        ]
                    ]
                });
            } else {
                this.emitirCerrar();
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
        },
        pregunta: {
            title: 'Pregunta',
            message: '',
            type: 'question'
        }
    }
}
</script>

<style lang="css">
</style>
