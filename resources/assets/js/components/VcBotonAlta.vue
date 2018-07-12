<template lang="html">
    
    <button
        @click="confirmar"
        type="button"
        name="alta"
        class="btn btn-sm btn-outline-primary"
    >
        <arrow-up-icon class="icono"></arrow-up-icon> Dar de alta
    </button>
    
</template>

<script>
import { ArrowUpIcon } from 'vue-feather-icons';

export default {
    components: { ArrowUpIcon },
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
