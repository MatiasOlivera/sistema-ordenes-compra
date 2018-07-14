<template lang="html">

    <base-formulario
        :titulos="$options.static.titulos"
        :url="$options.static.url.tiposOrganizacion"
        :id="id"
        :modelo="tipo"
        :modeloPorDefecto="$options.static.tipoPorDefecto"
        :mensajes="$options.static.mensajes"
        @obtenido="setTipo"
        @validado="validado"
        @guardado="guardado"
        @deshacer="setTipo"
        @limpiar="resetearTodo"
        @cerrar="cerrar"
    >
    
        <fieldset class="form-group">
            <label for="descripcion">Descripción</label>

            <input
                v-model="tipo.descripcion"
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
            tipo: null,
            validacion: null
        }
    },
    static: {
        titulos: {
            crear: 'Nuevo tipo de organización',
            editar: 'Editar tipo de organización'
        },
        
        url: {
            tiposOrganizacion: '/tipos-organizacion'
        },
        
        mensajes: {
            obtener: {
                error: {
                    noEncontrado: {
                        titulo: 'No encontrado',
                        mensaje: 'El tipo de organización no existe o ha sido eliminado'
                    },
                    porDefecto: {
                        titulo: 'Error',
                        mensaje: 'No se pudo traer los datos del tipo de organización'
                    }
                }
            },
            enviar: {
                error: {
                    porDefecto: {
                        titulo: 'Error',
                        mensaje: 'No se pudo crear el tipo de organización'
                    }
                }
            }
        },
        
        tipoPorDefecto: {
            descripcion: null
        },
        
        validacionPorDefecto: {
            descripcion: null
        }
    },
    created() {
        this.resetearTodo();

        BusEventos.$on('VcTablaTipoOrg:editar', (id) => { this.setID(id) });
        BusEventos.$on('VcPerfilTipoOrg:editar', (id) => { this.setID(id) });
    },
    methods: {        
        setID(id) {
            this.id = id;
        },
        
        setTipo(tipo) {
            this.tipo = tipo;
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
            BusEventos.$emit('VcFormTipoOrg:guardado', this.id);
            this.resetearTodo();
        },
        
        cerrar() {
            this.$emit('cerrar');
            this.resetearTodo();
        },
        
        resetearId() {
            this.id = null;
        },
        
        resetearTipo() {
            this.tipo = { ...this.$options.static.tipoPorDefecto };
        },
        
        resetearValidacion() {
            this.validacion = { ...this.$options.static.validacionPorDefecto };
        },
        
        resetearTodo() {
            this.resetearTipo();
            this.resetearId();
            this.resetearValidacion();
        }
    },
    notifications: {
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
