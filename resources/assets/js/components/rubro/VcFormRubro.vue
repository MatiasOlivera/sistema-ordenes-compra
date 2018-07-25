<template lang="html">

    <base-formulario
        :titulos="$options.static.titulos"
        :url="$options.static.url.rubros"
        :id="id"
        :modelo="rubro"
        :modeloPorDefecto="$options.static.rubroPorDefecto"
        :mensajes="$options.static.mensajes"
        @obtenido="setRubro"
        @validado="validado"
        @guardado="guardado"
        @deshacer="setRubro"
        @limpiar="resetearTodo"
        @cerrar="cerrar"
    >
    
        <fieldset class="form-group">
            <label for="descripcion">Descripción</label>

            <input
                v-model="rubro.descripcion"
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
import BaseFormulario from '../../components/BaseFormulario.vue';
import VcFormError    from '../../components/VcFormError.vue';

export default {
    name: 'vc-form-tipo-org',
    components: {
        BaseFormulario,
        VcFormError
    },
    data() {
        return {
            id: null,
            rubro: null,
            validacion: null
        }
    },
    static: {
        titulos: {
            crear: 'Nuevo rubro',
            editar: 'Editar rubro'
        },
        
        url: {
            rubros: '/rubros'
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
        
        rubroPorDefecto: {
            descripcion: null
        },
        
        validacionPorDefecto: {
            descripcion: null
        }
    },
    created() {
        this.resetearTodo();

        BusEventos.$on('VcTablaRubros:editar', (id) => { this.setID(id) });
        BusEventos.$on('VcPerfilRubro:editar', (id) => { this.setID(id) });
    },
    methods: {        
        setID(id) {
            this.id = id;
        },
        
        setRubro(rubro) {
            this.rubro = rubro;
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
            BusEventos.$emit('VcFormRubro:guardado', this.id);
            this.resetearTodo();
        },
        
        cerrar() {
            this.$emit('cerrar');
            this.resetearTodo();
        },
        
        resetearId() {
            this.id = null;
        },
        
        resetearRubro() {
            this.rubro = { ...this.$options.static.rubroPorDefecto };
        },
        
        resetearValidacion() {
            this.validacion = { ...this.$options.static.validacionPorDefecto };
        },
        
        resetearTodo() {
            this.resetearRubro();
            this.resetearId();
            this.resetearValidacion();
        }
    }
}
</script>

<style lang="css">
</style>
