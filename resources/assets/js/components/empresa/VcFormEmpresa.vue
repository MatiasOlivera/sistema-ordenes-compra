<template lang="html">
    
    <base-formulario
        :titulos="$options.static.titulos"
        :url="$options.static.url.empresas"
        :id="id"
        :modelo="empresa"
        :modeloPorDefecto="$options.static.empresaPorDefecto"
        :mensajes="$options.static.mensajes"
        @obtenido="setEmpresa"
        @validado="validado"
        @guardado="guardado"
        @deshacer="setEmpresa"
        @limpiar="resetearTodo"
        @cerrar="cerrar"
    >
        
        <fieldset class="form-group">
            <label for="nombre_fantasia">Nombre de fantasía</label>
            
            <input
                v-model="empresa.nombre_fantasia"
                :class="{'is-invalid' : validacion.nombre_fantasia}"
                type="text"
                name="nombre_fantasia"
                class="form-control"
                id="nombre_fantasia"
                aria-describedby="nombre_fantasiaAyuda"
            >
            
            <small
                v-if="!validacion.nombre_fantasia"
                id="nombre_fantasiaAyuda"
                class="form-text text-muted"
            >
                El nombre comercial de la empresa/negocio
            </small>
            <vc-form-error
                v-else
                :error="validacion.nombre_fantasia"
            >
            </vc-form-error>
        </fieldset>
        
        <fieldset class="custom-control custom-checkbox">
            <input
                v-model="empresa.es_mayorista"
                :class="{'is-invalid' : validacion.es_mayorista}"
                type="checkbox"
                name="es_mayorista"
                class="custom-control-input"
                id="es_mayorista"
            >
            <label class="custom-control-label" for="es_mayorista">
                {{ mayorista }}
            </label>
            
            <vc-form-error
                v-if="validacion.es_mayorista"
                :error="validacion.es_mayorista"
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
    name: 'vc-form-empresa',
    components: {
        BaseFormulario,
        VcFormError
    },
    data() {
        return {
            id: null,
            empresa: null,
            validacion: null
        }
    },
    computed: {
        mayorista() {
            return this.empresa.es_mayorista
            ? 'Es mayorista'
            : 'No es mayorista';
        }
    },
    static: {
        titulos: {
            crear: 'Nueva empresa',
            editar: 'Editar empresa'
        },
        
        url: {
            empresas: '/empresas'
        },
        
        mensajes: {
            obtener: {
                error: {
                    noEncontrado: {
                        titulo: 'No encontrada',
                        mensaje: 'La empresa no existe o ha sido eliminada'
                    },
                    porDefecto: {
                        titulo: 'Error',
                        mensaje: 'No se pudo traer los datos de la empresa'
                    }
                }
            },
            enviar: {
                error: {
                    porDefecto: {
                        titulo: 'Error',
                        mensaje: 'No se pudo crear la empresa'
                    }
                }
            }
        },
        
        empresaPorDefecto: {
            nombre_fantasia: null,
            es_mayorista: false
        },
        
        validacionPorDefecto: {
            nombre_fantasia: null,
            es_mayorista: null
        }
    },
    created() {
        this.resetearTodo();

        BusEventos.$on('VcTablaEmpresas:editar', (id) => { this.setID(id) });
        BusEventos.$on('VcPerfilEmpresa:editar', (id) => { this.setID(id) });
    },
    methods: {        
        setID(id) {
            this.id = id;
        },
        
        setEmpresa(empresa) {
            this.empresa = empresa;
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
            BusEventos.$emit('VcFormEmpresa:guardada', this.id);
            this.resetearTodo();
        },
        
        cerrar() {
            this.$emit('cerrar');
            this.resetearTodo();
        },
        
        resetearId() {
            this.id = null;
        },
        
        resetearEmpresa() {
            this.empresa = { ...this.$options.static.empresaPorDefecto };
        },
        
        resetearValidacion() {
            this.validacion = { ...this.$options.static.validacionPorDefecto };
        },
        
        resetearTodo() {
            this.resetearEmpresa();
            this.resetearId();
            this.resetearValidacion();
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
