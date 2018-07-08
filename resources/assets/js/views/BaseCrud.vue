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
                @click="mostrarForm"
                type="button" name="nuevo" class="btn btn-primary"
            >
                <plus-circle-icon class="icono"></plus-circle-icon> {{ botonNuevo }}
            </button>
        </div>
        
        <div class="row">
            <!-- Perfil -->
            <div
                v-show="perfil.visible"
                class="col-xl-6 p-3 mb-2 bg-white rounded box-shadow"
            >
                <slot
                    name="perfil"
                    :ocultarPerfil="ocultarPerfil"    
                >
                </slot>
            </div>
            
            <!-- Formulario -->
            <div
                v-show="form.visible"
                class="col-xl-6 p-3 mb-2 bg-white rounded box-shadow"
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
        mostrarPerfil() {
            this.perfil.visible = true;
        },
        ocultarPerfil() {
            this.perfil.visible = false;
        },
        mostrarForm() {
            this.form.visible = true;
        },
        ocultarForm() {
            this.form.visible = false;
        }
    }
}
</script>

<style lang="css">
</style>
