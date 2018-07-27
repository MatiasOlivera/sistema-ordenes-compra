<template lang="html">
    
    <button
        @click="confirmar"
        type="button"
        name="alta"
        class="btn btn-sm btn-outline-primary"
        data-toggle="tooltip"
        data-placement="top"
        :title="tooltip"
    >
        <arrow-up-icon class="icono"></arrow-up-icon>
    </button>
    
</template>

<script>
/**
 * Mixins
 */
import TooltipMixin from '../mixins/tooltip_mixin.js';

/**
 * Componentes
 */
import { ArrowUpIcon } from 'vue-feather-icons';

export default {
    name: 'vc-boton-alta',
    mixins: [ TooltipMixin ],
    components: { ArrowUpIcon },
    props: {
        tooltip: {
            type: String,
            default: 'Dar de alta'
        },
        nombre: {
            type: String
        }
    },
    static: {
        elemento: 'button[name="alta"]'
    },
    methods: {        
        confirmar() {
            
            function ocultarNotificacion(instancia, notificacion) {
                instancia.hide(
                    {transitionOut: 'fadeOut'},
                    notificacion,
                    'button'
                );
            }
            
            let mensaje = this.nombre
            ? `¿Estás seguro que quieres dar de alta a ${this.nombre}?`
            : '¿Estás seguro que quieres darlo de alta?';
            
            this.pregunta({
                title: 'Confirmar el alta',
                message: mensaje,
                timeout: false,
                buttons: [
                    [
                        '<button>Si</button>',
                        (instance, toast) => {
                            ocultarNotificacion(instance, toast);
                            this.$emit('confirmado');
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
            
            this.$_TooltipMixin_ocultarTooltip();
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
