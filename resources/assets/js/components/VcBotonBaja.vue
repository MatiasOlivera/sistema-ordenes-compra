<template lang="html">

    <button
        @click="confirmar"
        type="button"
        name="baja"
        class="btn btn-sm btn-outline-danger"
        data-toggle="tooltip"
        data-placement="top"
        :title="tooltip"
    >
        <trash-icon class="icono"></trash-icon>
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
import { TrashIcon } from 'vue-feather-icons';

export default {
    name: 'vc-boton-baja',
    mixins: [ TooltipMixin ],
    components: { TrashIcon },
    props: {
        tooltip: {
            type: String,
            default: 'Dar de baja'
        },
        nombre: {
            type: String
        }
    },
    static: {
        elemento: 'button[name="baja"]'
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
            ? `¿Estás seguro que quieres eliminar a ${this.nombre}?`
            : '¿Estás seguro que quieres eliminarlo?';
            
            this.pregunta({
                title: 'Confirmar la eliminación',
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
