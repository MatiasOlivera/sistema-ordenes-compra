<template lang="html">
    
    <base-perfil
        :titulo="titulo"
        :nombreInstancia="actividad.descripcion"
        :eliminado="eliminado"
        @editar="editar"
        @dar-de-baja="darDeBaja"
        @dar-de-alta="darDeAlta"
        @cerrar="cerrar"
    >
        <dl>
            <dt>Descripcion:</dt>
            <dd>{{ actividad.descripcion }}</dd>
            
            <dt>Creado:</dt>
            <dd>
                {{ actividad.created_at | moment('from') }}, 
                {{ actividad.created_at | moment('L LT a') }}
            </dd>
            
            <dt>Actualizado:</dt>
            <dd>
                {{ actividad.updated_at | moment('from') }}, 
                {{ actividad.updated_at | moment('L LT a') }}
            </dd>
            
            <template v-if="eliminado">
                <dt>Eliminado:</dt>
                <dd>
                    {{ actividad.deleted_at | moment('from') }}, 
                    {{ actividad.deleted_at | moment('L LT a') }}
                </dd>
            </template>
        </dl>
    </base-perfil>
    
</template>

<script>
import { apiActividad }           from '../../common/api/actividad_economica.js';
import { objetoTienePropiedades } from '../../common/components/validadores.js';
import { ACTIVIDAD_CLAVES }       from '../../common/components/actividad_economica.js';

/**
 * Componentes
 */
import BasePerfil from '../../components/BasePerfil.vue';


export default {
    name: 'vc-detalle-actividad',
    components: { BasePerfil },
    props: {
        actividad: {
            type: Object,
            validator: function(actividad) {
                return objetoTienePropiedades(actividad, ACTIVIDAD_CLAVES);
            },
            required: true
        }
    },
    computed: {
        titulo() {
            return `Detalle de ${this.actividad.descripcion}`;
        },
        
        eliminado() {
            return _.isNull(this.actividad.deleted_at) ? false : true;
        }
    },
    methods: {
        editar() {
            this.$emit('editar');
        },
        
        cerrar() {
            this.$emit('cerrar');
        },
        
        darDeBaja() {
            apiActividad.darDeBaja(this.actividad.id)
            .then((respuesta) => {
                const STATUS = respuesta.status;

                if (STATUS === 200) {
                    this.exito(respuesta.notificacion);
                    
                    this.$emit('dado-de-baja');
                    BusEventos.$emit('VcPerfilActividad:eliminado')
                }
            })
            .catch(({notificacion}) => {
                if (notificacion) {
                    this.error(notificacion);
                }
            });
        },
        
        darDeAlta() {
            apiActividad.darDeAlta(this.actividad.id)
            .then((respuesta) => {
                const STATUS = respuesta.status;

                if (STATUS === 200) {
                    this.exito(respuesta.notificacion);
                    
                    this.$emit('dado-de-alta');
                    BusEventos.$emit('VcPerfilActividad:restaurado')
                }
            })
            .catch(({notificacion}) => {
                if (notificacion) {
                    this.error(notificacion);
                }
            });
        }
    },
    notifications: {
        exito: {
            title: 'Exito',
            message: '',
            type: 'success'
        },
        error: {
            title: 'Error',
            message: '',
            type: 'error'
        }
    }
}
</script>

<style lang="css">
</style>
