<template lang="html">

    <div>

        <!-- Título -->
        <div class="text-center mb-2">
            <h1 class="h3">{{ titulo }}</h1>
        </div>

        <!-- Nuevo modelo -->
        <div class="d-flex justify-content-center mb-2">
            <button
                v-if="!form.visible"
                @click="mostrarForm(false)"
                type="button" name="nuevo" class="btn btn-primary"
            >
                <plus-circle-icon class="icono"></plus-circle-icon> {{ botonNuevo }}
            </button>
        </div>

        <div class="row justify-content-center align-items-start">
            <!-- Perfil -->
            <div
                v-show="perfil.visible"
                class="col-xl-6"
            >
                <slot
                    name="perfil"
                    :ocultarPerfil="ocultarPerfil"
                    :mostrarForm="mostrarForm"
                >
                </slot>
            </div>

            <!-- Formulario -->
            <div
                v-show="form.visible"
                class="col-xl-6"
            >
                <slot
                    name="formulario"
                    :ocultarForm="ocultarForm"
                >
                </slot>
            </div>
        </div>

        <!-- Tabla -->
        <div class="my-4">
            <slot
                name="tabla"
                :mostrarPerfil="mostrarPerfil"
                :mostrarForm="mostrarForm"
            >
            </slot>
        </div>

    </div>

</template>

<script>
import { PlusCircleIcon } from 'vue-feather-icons';
import VueScrollTo from 'vue-scrollto'

export default {
    components: { PlusCircleIcon },
    props: {
        titulo: {
            type: String,
            required: true
        },
        botonNuevo: {
            type: String,
            required: true,
            validator: function (descripcion) {
                const botones = ['Nuevo', 'Nueva'];
                return botones.includes(descripcion);
            }
        }
    },
    data() {
        return {
            perfil: {
                visible: false
            },
            form: {
                visible: false
            }
        }
    },
    methods: {
        scrollHaciaArriba() {
            this.$scrollTo('#main', 500, { easing: 'ease-in' });
        },
        mostrarPerfil() {
            this.perfil.visible = true;
            this.scrollHaciaArriba();
        },
        ocultarPerfil() {
            this.perfil.visible = false;
        },
        mostrarForm(scroll) {
            if (!_.isBoolean(scroll)) {
                throw new Error('El argumento debe ser un booleano');
            }
            
            this.form.visible = true;
            if (scroll) this.scrollHaciaArriba()
        },
        ocultarForm() {
            this.form.visible = false;
        }
    }
}
</script>

<style lang="css">
</style>
