<template lang="html">
    
    <div class="mb-4 p-3 bg-white rounded box-shadow">
        <div class="row border-bottom border-gray mb-4">
            <div class="col-auto">
                <div class="d-flex flex-row">
                    <h3 class="h6">{{ titulo }}</h3>
                    <plus-icon
                        v-if="botonNuevoVisible"
                        id="iconoNuevo"
                        class="icono ml-2"
                        @click="nuevo"
                    >
                    </plus-icon>
                </div>
            </div>
    
            <div
                v-if="botonIzqVisible"
                class="col-auto ml-auto"
            >
                    <a
                        @click.prevent="cerrar"
                        href="#"
                        class="text-muted"
                    >
                        <template v-if="botonIzqEsCerrar">
                            <x-icon class="icono"></x-icon> Cerrar
                        </template>
                        
                        <template v-else>
                            <arrow-left-icon class="icono"></arrow-left-icon> Volver
                        </template>
                    </a>
            </div>
        </div>
        
        <slot></slot>
    </div>
    
</template>

<script>
import { EVENTO_CERRAR } from '../common/components/eventos_tarjeta.js';
const EVENTO_NUEVO = 'nuevo';

/**
 * Componentes
 */
import { PlusIcon, XIcon, ArrowLeftIcon } from 'vue-feather-icons';

export default {
    name: 'base-tarjeta',
    components: {
        PlusIcon,
        XIcon,
        ArrowLeftIcon
    },
    props: {
        titulo: {
            type: String,
            required: true
        },
        
        botonNuevoVisible: {
            type: Boolean,
            default: false
        },
        
        botonIzqVisible: {
            type: Boolean,
            default: false
        },
        
        botonIzqTipo: {
            type: String,
            default: 'cerrar',
            validator: function(tipo) {
                const tipos = ['cerrar', 'volver'];
                return tipos.includes(tipo);
            }
        },
        
        confirmacionRequerida: {
            type: Boolean,
            default: false
        },
        
        confirmacionNotificacion: {
            type: Object,
            default: function() {
                return {
                    titulo: 'Cerrar tarjeta',
                    mensaje: '¿Estás seguro?'
                }
            }
        }
    },
    computed: {
        botonIzqEsCerrar() {
            return this.botonIzqTipo === 'cerrar';
        }
    },
    methods: {
        nuevo() {
            this.$emit(EVENTO_NUEVO);
        },
        
        cerrar() {
            this.confirmacionRequerida
            ? this.confirmarAlCerrar()
            : this.$emit(EVENTO_CERRAR);
        },
        
        confirmarAlCerrar() {
            function ocultarNotificacion(instancia, notificacion) {
                instancia.hide({
                    transitionOut: 'fadeOut'
                }, notificacion, 'button');
            }

            this.pregunta({
                title: this.confirmacionNotificacion.titulo,
                message: this.confirmacionNotificacion.mensaje,
                timeout: false,
                buttons: [
                    [
                        '<button>Si</button>',
                        (instance, toast) => {
                            this.$emit(EVENTO_CERRAR);
                            ocultarNotificacion(instance, toast);
                        },
                        true
                    ],
                    [
                        '<button>No</button>',
                        (instance, toast) => {
                            ocultarNotificacion(instance, toast);
                        }
                    ]
                ],
                displayMode: 'once'
            });
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

<style lang="css" scoped>
    #iconoNuevo {
        margin-top: 2px;
        margin-bottom: 0px;
    }
</style>
