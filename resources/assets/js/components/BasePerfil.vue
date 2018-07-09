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
            <vc-boton-editar @click.native="editar">
            </vc-boton-editar>
            
            <vc-boton-eliminar
                :nombre="nombreInstancia"
                @confirmado="eliminar"
            >
            </vc-boton-eliminar>
        </div>
        
        <!-- Datos -->
        <slot></slot>
    </div>

</template>

<script>
import BaseCabecera from '../components/BaseCabecera.vue';
import VcBotonEditar from '../components/VcBotonEditar.vue';
import VcBotonEliminar from '../components/VcBotonEliminar.vue';

export default {
    name: 'base-perfil',
    components: {
        BaseCabecera,
        VcBotonEditar,
        VcBotonEliminar
    },
    props: {
        titulo: {
            type: String,
            required: true
        },
        nombreInstancia: {
            type: String,
            required: true
        }
    },
    methods: {
        editar() {
            this.$emit('editar');
        },
        eliminar() {
            this.$emit('eliminar')
        },
        cerrar() {
            this.$emit('cerrar');
        }
    }
}
</script>

<style lang="css">
</style>
