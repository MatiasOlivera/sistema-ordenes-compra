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
    name: 'vc-tabla-juridicas',
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
        BusEventos.$on('VcFormJuridica:guardada', () => {
            this.obtenerRegistros();
        });
        
        BusEventos.$on('VcPerfilJuridica:eliminada', () => {
            this.obtenerRegistros();
        });
        
        BusEventos.$on('VcPerfilJuridica:restaurada', () => {
            this.obtenerRegistros();
        });
    },
    static: {
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
        
        campoNombre: 'denominacion',
        
        mensajes: {
            alta: {
                error: {
                    noEncontrado: {
                        titulo: 'No encontrada',
                        mensaje: 'La persona jurídica no existe o ha sido eliminada'
                    },
                    porDefecto: {
                        titulo: 'Error',
                        mensaje: 'No se pudo dar de alta a la persona jurídica'
                    }
                }
            },
            baja: {
                error: {
                    noEncontrado: {
                        titulo: 'No encontrada',
                        mensaje: 'La persona jurídica no existe o ha sido eliminada'
                    },
                    porDefecto: {
                        titulo: 'Error',
                        mensaje: 'No se pudo dar de baja a la persona jurídica'
                    }
                }
            }
        }
    },
    methods: {
        verPerfil(id) {
            BusEventos.$emit('VcTablaJuridicas:verPerfil', id);
            this.$emit('mostrar-perfil');
        },
        
        editar(id) {
            BusEventos.$emit('VcTablaJuridicas:editar', id);
            this.$emit('mostrar-perfil');
        },
        
        darDeBaja(id) {
            this.$_darBajaInstanciaMixin_eliminar(
                `${this.$options.static.url}/${id}`,
                () => {
                    this.obtenerRegistros();
                    BusEventos.$emit('VcTablaJuridicas:eliminada', id);
                },
                this.$options.static.mensajes.baja
            );
        },
        
        darDeAlta(id) {
            this.$_darAltaInstanciaMixin_restaurar(
                `${this.$options.static.url}/${id}/restore`,
                () => {
                    this.obtenerRegistros();
                    BusEventos.$emit('VcTablaJuridicas:restaurada', id);
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
