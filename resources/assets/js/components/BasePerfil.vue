<template lang="html">

    <div>
        <!-- Cabecera -->
        <base-cabecera
            :titulo="titulo"
            @cerrar="cerrar"
        >
        </base-cabecera>

        <!-- Botones -->
        <div class="mb-3">
            <vc-boton-editar
                v-if="!eliminado"
                @click="editar"
            >
            </vc-boton-editar>
            
            <slot name="acciones"></slot>
            
            <vc-boton-alta
                v-if="eliminado"
                :nombre="nombreInstancia"
                @confirmado="darDeAlta"
            >
            </vc-boton-alta>
            <vc-boton-baja
                v-else
                :nombre="nombreInstancia"
                @confirmado="darDeBaja"
            >
            </vc-boton-baja>
            
        </div>
        
        <!-- Datos -->
        <slot></slot>
    </div>

</template>

<script>
import BaseCabecera from '../components/BaseCabecera.vue';
import VcBotonEditar from '../components/VcBotonEditar.vue';
import VcBotonBaja from '../components/VcBotonBaja.vue';
import VcBotonAlta from '../components/VcBotonAlta.vue';

export default {
    name: 'base-perfil',
    components: {
        BaseCabecera,
        VcBotonEditar,
        VcBotonBaja,
        VcBotonAlta
    },
    props: {
        titulo: {
            type: String,
            required: true
        },
        nombreInstancia: {
            type: String,
            required: true
        },
        eliminado: {
            type: Boolean,
            required: true,
            default: false
        }
    },
    methods: {
        editar() {
            this.$emit('editar');
        },
        darDeBaja() {
            this.$emit('dar-de-baja')
        },
        darDeAlta() {
            this.$emit('dar-de-alta');
        },
        cerrar() {
            this.$emit('cerrar');
        }
    }
}
</script>

<style lang="css">
</style>
