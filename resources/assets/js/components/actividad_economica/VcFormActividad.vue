<template lang="html">

    <base-formulario
        :titulos="$options.static.titulos"
        :url="$options.static.url.actividades"
        :id="id"
        :modelo="actividad"
        :modeloPorDefecto="$options.static.actividadPorDefecto"
        :mensajes="$options.static.mensajes"
        @obtenido="setActividad"
        @validado="validado"
        @guardado="guardado"
        @deshacer="setActividad"
        @limpiar="resetearTodo"
        @cerrar="cerrar"
    >
    
        <fieldset class="form-group">
            <label for="descripcion">Descripción</label>

            <input
                v-model="actividad.descripcion"
                :class="{'is-invalid' : validacion.descripcion}"
                type="text"
                name="descripcion"
                class="form-control"
                id="descripcion"
            >
            <vc-form-error
                v-if="validacion.descripcion"
                :error="validacion.descripcion"
            >
            </vc-form-error>
        </fieldset>
    
    </base-formulario>

</template>

<script>
/**
 * Componentes
 */
import BaseFormulario from '../../components/BaseFormulario.vue';
import VcFormError    from '../../components/VcFormError.vue';


export default {
    name: 'vc-form-actividad',
    components: {
        BaseFormulario,
        VcFormError
    },
    data() {
        return {
            id: null,
            actividad: null,
            validacion: null
        }
    },
    static: {
        titulos: {
            crear: 'Nuevo rubro',
            editar: 'Editar rubro'
        },
        
        url: {
            actividades: '/actividades-economicas'
        },
        
        mensajes: {
            obtener: {
                error: {
                    noEncontrado: {
                        titulo: 'No encontrado',
                        mensaje: 'El rubro no existe o ha sido eliminado'
                    },
                    porDefecto: {
                        titulo: 'Error',
                        mensaje: 'No se pudo traer los datos del rubro'
                    }
                }
            },
            enviar: {
                error: {
                    porDefecto: {
                        titulo: 'Error',
                        mensaje: 'No se pudo crear el rubro'
                    }
                }
            }
        },
        
        actividadPorDefecto: {
            descripcion: null
        },
        
        validacionPorDefecto: {
            descripcion: null
        }
    },
    created() {
        this.resetearTodo();

        BusEventos.$on('VcTablaActividades:editar', (id) => { this.setID(id) });
        BusEventos.$on('VcPerfilActividad:editar', (id) => { this.setID(id) });
    },
    methods: {        
        setID(id) {
            this.id = id;
        },
        
        setActividad(actividad) {
            this.actividad = actividad;
        },
        
        validado(errores) {
            this.validacion = errores;
        },
        
        guardado(id) {
            if (id !== null) {
                this.setID(id);
            }
            
            this.$emit('cerrar');
            this.$emit('guardado', this.id);
            BusEventos.$emit('VcFormActividad:guardado', this.id);
            this.resetearTodo();
        },
        
        cerrar() {
            this.$emit('cerrar');
            this.resetearTodo();
        },
        
        resetearId() {
            this.id = null;
        },
        
        resetearActividad() {
            this.actividad = { ...this.$options.static.actividadPorDefecto };
        },
        
        resetearValidacion() {
            this.validacion = { ...this.$options.static.validacionPorDefecto };
        },
        
        resetearTodo() {
            this.resetearActividad();
            this.resetearId();
            this.resetearValidacion();
        }
    }
}
</script>

<style lang="css">
</style>
