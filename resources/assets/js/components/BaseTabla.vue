<template lang="html">

    <v-server-table
        :ref="nombre"
        :name="nombre"
        :url="url"
        :columns="todasColumnas"
        :options="opciones"
    >
        <template slot="perfil" slot-scope="{ row: {id} }">
            <button @click="verPerfil(id)" type="button" name="perfil"
            class="btn btn-sm btn-outline-info">
                <info-icon class="icono"></info-icon> Perfil
            </button>
        </template>

        <template slot="editar" slot-scope="{ row: {id} }">
            <vc-boton-editar @click.native="editar(id)"></vc-boton-editar>
        </template>

        <template slot="eliminar" slot-scope="{ row: fila }">
            <vc-boton-eliminar
                :nombre="fila[campoNombre]"
                @confirmado="eliminar(fila.id)"
            >
            </vc-boton-eliminar>
        </template>
    </v-server-table>

</template>

<script>
import { InfoIcon } from 'vue-feather-icons';
import VcBotonEditar from '../components/VcBotonEditar.vue';
import VcBotonEliminar from '../components/VcBotonEliminar.vue';

export default {
    components: {
        InfoIcon,
        VcBotonEditar,
        VcBotonEliminar
    },
    props: {
        nombre: {
            type: String,
            required: true
        },
        url: {
            type: String,
            required: true
        },
        columnas: {
            type: Array,
            required: true
        },
        opciones: {
            type: Object,
            required: true
        },
        obtenerTabla: {
            type: Boolean,
            default: false
        },
        campoNombre: {
            type: String,
            required: true
        }
    },
    computed: {
        todasColumnas() {
            const especificas = this.columnas;
            const porDefecto  = ['perfil', 'editar', 'eliminar'];
            return especificas.concat(porDefecto);
        }
    },
    watch: {
        obtenerTabla(estado) {
            if (estado) this.obtenerModelos();
        }
    },
    methods: {
        verPerfil(id) {
            this.$emit('ver-perfil');
        },
        editar(id) {
            this.$emit('editar', id);
        },
        eliminar(id) {
            this.$emit('eliminar', id);
        },
        obtenerModelos() {
            this.$refs[this.nombre].getData();
        }
    }
}
</script>

<style lang="css">
</style>
