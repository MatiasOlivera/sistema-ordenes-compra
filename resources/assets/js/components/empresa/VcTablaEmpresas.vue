<template lang="html">

    <base-tabla
        :nombre="this.$options.static.nombre"
        :url="this.$options.static.url"
        :columnas="this.$options.static.columnas"
        :opciones="this.$options.static.opciones"
        :campoNombre="this.$options.static.campoNombre"
        :obtenerTabla="obtenerTabla"
        @ver-perfil="verPerfil"
        @editar="editar"
        @dar-de-baja="darDeBaja"
        @dar-de-alta="darDeAlta"
    >
    </base-tabla>

</template>

<script>
import BaseTabla             from '../../components/BaseTabla.vue';
import DarBajaInstanciaMixin from '../../mixins/dar_baja_instancia_mixin.js';
import DarAltaInstanciaMixin from '../../mixins/dar_alta_instancia_mixin.js';

export default {
    name: 'vc-tabla-empresas',
    components: { BaseTabla },
    mixins: [
        DarBajaInstanciaMixin,
        DarAltaInstanciaMixin
    ],
    data() {
        return {
            obtenerTabla: false
        }
    },
    created() {
        BusEventos.$on('VcFormEmpresa:guardada', () => {
            this.obtenerRegistros();
        });

        BusEventos.$on('VcPerfilEmpresa:eliminada', () => {
            this.obtenerRegistros();
        });

        BusEventos.$on('VcPerfilEmpresa:restaurada', () => {
            this.obtenerRegistros();
        });
    },
    static: {
        nombre: 'empresas',
        url: '/empresas',

        columnas: [
            'nombre_fantasia'
        ],

        opciones: {
            headings: {
                'nombre_fantasia': 'Nombre de fantasía'
            },
            orderBy: {
                column: 'nombre_fantasia',
                ascending: true
            },
            sortable: ['nombre_fantasia']
        },

        campoNombre: 'nombre_fantasia',

        mensajes: {
            alta: {
                error: {
                    noEncontrado: {
                        titulo: 'No encontrada',
                        mensaje: 'La empresa no existe o ha sido eliminada'
                    },
                    porDefecto: {
                        titulo: 'Error',
                        mensaje: 'No se pudo dar de alta a la empresa'
                    }
                }
            },
            baja: {
                error: {
                    noEncontrado: {
                        titulo: 'No encontrada',
                        mensaje: 'La empresa no existe o ha sido eliminada'
                    },
                    porDefecto: {
                        titulo: 'Error',
                        mensaje: 'No se pudo dar de baja la empresa'
                    }
                }
            }
        }
    },
    methods: {
        verPerfil(id) {
            BusEventos.$emit('VcTablaEmpresas:verPerfil', id);
            this.$emit('mostrar-perfil')
        },

        editar(id) {
            BusEventos.$emit('VcTablaEmpresas:editar', id);
            this.$emit('mostrar-form');
        },

        darDeBaja(id) {
            this.$_darBajaInstanciaMixin_eliminar(
                `${this.$options.static.url}/${id}`,
                () => { this.obtenerRegistros() },
                this.$options.static.mensajes.baja
            );
        },

        darDeAlta(id) {
            this.$_darAltaInstanciaMixin_restaurar(
                `${this.$options.static.url}/${id}/restore`,
                () => {
                    this.obtenerRegistros();
                    BusEventos.$emit('VcTablaEmpresas:restaurada', id);
                },
                this.$options.static.mensajes.alta
            )
        },

        obtenerRegistros() {
            this.obtenerTabla = true;
            this.$nextTick(() => {
                this.obtenerTabla = false;
            });
        }
    }
}
</script>

<style lang="css">
</style>