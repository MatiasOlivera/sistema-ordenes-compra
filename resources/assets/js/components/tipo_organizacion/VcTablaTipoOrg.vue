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
    name: 'vc-tabla-tipo-org',
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
        BusEventos.$on('VcFormTipoOrg:guardado', () => {
            this.obtenerRegistros();
        });
        
        BusEventos.$on('VcPerfilTipoOrg:eliminado', () => {
            this.obtenerRegistros();
        });
        
        BusEventos.$on('VcPerfilTipoOrg:restaurado', () => {
            this.obtenerRegistros();
        });
    },
    static: {
        nombre: 'tipos_organizacion',
        url: '/tipos-organizacion',
        columnas: ['descripcion'],
        
        opciones: {
            headings: {
                'descripcion': 'Descripción'
            },
            orderBy: {
                column: 'descripcion',
                ascending: true
            },
            sortable: ['descripcion']
        },
        
        campoNombre: 'descripcion',
        
        mensajes: {
            alta: {
                error: {
                    noEncontrado: {
                        titulo: 'No encontrado',
                        mensaje: 'El tipo de organización no existe o ha sido eliminado'
                    },
                    porDefecto: {
                        titulo: 'Error',
                        mensaje: 'No se pudo dar de alta al tipo de organización'
                    }
                }
            },
            baja: {
                error: {
                    noEncontrado: {
                        titulo: 'No encontrado',
                        mensaje: 'El tipo de organización no existe o ha sido eliminado'
                    },
                    porDefecto: {
                        titulo: 'Error',
                        mensaje: 'No se pudo dar de baja al tipo de organización'
                    }
                }
            }
        }
    },
    methods: {
        verPerfil(id) {
            BusEventos.$emit('VcTablaTipoOrg:verPerfil', id);
            this.$emit('mostrar-perfil')
        },
        
        editar(id) {
            BusEventos.$emit('VcTablaTipoOrg:editar', id);
            this.$emit('mostrar-perfil');
        },
        
        darDeBaja(id) {
            this.$_darBajaInstanciaMixin_eliminar(
                `${this.$options.static.url}/${id}`,
                () => {
                    this.obtenerRegistros();
                    BusEventos.$emit('VcTablaTipoOrg:eliminado', id);
                },
                this.$options.static.mensajes.baja
            );
        },
        
        darDeAlta(id) {
            this.$_darAltaInstanciaMixin_restaurar(
                `${this.$options.static.url}/${id}/restore`,
                () => {
                    this.obtenerRegistros();
                    BusEventos.$emit('VcTablaTipoOrg:restaurado', id);
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
