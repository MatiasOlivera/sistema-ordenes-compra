<template lang="html">
    
    <base-tabla
        :nombre="nombre"
        :url="url"
        :columnas="columnas"
        :opciones="opciones"
        :obtenerTabla="obtenerTabla"
        @ver-perfil="verPerfil"
        @editar="editar"
        @eliminar="eliminar"
    >
    </base-tabla>
    
</template>

<script>
import BaseTabla from './BaseTabla.vue';

export default {
    components: { BaseTabla },
    data() {
        return {
            nombre: 'juridicas',
            url: '/juridicas',
            columnas: [
                'denominacion',
                'cuit',
                'tipo_organizacion.descripcion'
            ],
            opciones: {
                headings: {
                    'denominacion': 'Denominación',
                    'cuit': 'CUIT',
                    'tipo_organizacion.descripcion': 'Tipo de organización'
                },
                orderBy: {
                    column: 'denominacion',
                    ascending: true
                },
                sortable: ['denominacion', 'cuit']
            },
            obtenerTabla: false
        }
    },
    methods: {
        verPerfil(id) {
            BusEventos.$emit('VcTablaJuridicas:verPerfil', id);
        },
        editar(id) {
            BusEventos.$emit('VcTablaJuridicas:editar', id);
        },
        eliminar(id) {
            this.$emit('eliminar', id);
        },
        obtenerJuridicas() {
            this.obtenerTabla = true;
            this.$nextTick(() => {
                this.obtenerTabla = false;
            });
        }
    },
    created() {
        BusEventos.$on('VcFormJuridica:guardada', () => {
            this.obtenerJuridicas();
        });
        BusEventos.$on('ViewJuridicas:eliminada', () => {
            this.obtenerJuridicas();
        });
    }
}
</script>

<style lang="css">
</style>
