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
                    v-if="nuevoModelo"
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

export default {
    name: 'base-formulario',
    components: {
        BaseCabecera,
        SaveIcon,
        DeleteIcon,
        RotateCcwIcon
    },
    props: {
        titulos: {
            type: Object,
            required: true,
            default: {
                crear: 'Nuevo modelo',
                editar: 'Editar modelo'
            }
        },
        nuevoModelo: {
            type: Boolean,
            required: true,
            default: true
        },
        confirmarAlEliminar: {
            type: Boolean,
            required: true,
            default: false
        }
    },
    computed: {
        titulo() {
            return this.nuevoModelo ? this.titulos.crear : this.titulos.editar;
        }
    },
    methods: {
        guardar() {
            this.$emit('guardar');
        },
        limpiar() {
            this.$emit('limpiar');
        },
        deshacer() {
            this.$emit('deshacer');
        },
        emitirCerrar() {
            this.$emit('cerrar');
        },
        cerrar() {
            if (this.confirmarAlEliminar) {
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
        pregunta: {
            title: '',
            message: '',
            type: 'question'
        }
    }
}
</script>

<style lang="css">
</style>
