<template lang="html">

    <button
        @click="confirmar"
        type="button"
        name="eliminar"
        class="btn btn-sm btn-outline-danger"
    >
        <trash-icon class="icono"></trash-icon> Eliminar
    </button>

</template>

<script>
import { TrashIcon } from 'vue-feather-icons';

export default {
    components: { TrashIcon },
    props: {
        nombre: {
            type: String
        }
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
