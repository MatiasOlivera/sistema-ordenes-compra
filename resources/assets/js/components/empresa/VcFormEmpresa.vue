<template lang="html">
    
    <base-formulario
        :titulos="$options.static.titulos"
        :url="$options.static.url.empresas"
        :id="id"
        :modelo="empresa"
        :modeloPorDefecto="$options.static.empresaPorDefecto"
        :mensajes="$options.static.mensajes"
        @obtenido="obtenido"
        @validado="validado"
        @guardado="guardado"
        @deshacer="deshacer"
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
        
        <hr>
        
        <fieldset class="form-group">
            <label for="vc-select-juridicas">Personas jurídicas</label>
            
            <vc-select-juridicas
                :seleccionadas="empresa.juridicas"
                @input="selectJuridicasInput"
            >
            </vc-select-juridicas>
        </fieldset>
    
    </base-formulario>
    
</template>

<script>
import BaseFormulario    from '../../components/BaseFormulario.vue';
import VcFormError       from '../../components/VcFormError.vue';
import VcSelectJuridicas from '../../components/persona_juridica/VcSelectJuridicas.vue';

export default {
    name: 'vc-form-empresa',
    components: {
        BaseFormulario,
        VcFormError,
        VcSelectJuridicas
    },
    data() {
        return {
            id: null,
            empresa: null,
            validacion: null,
            juridicasGuardadas: null
        }
    },
    computed: {
        mayorista() {
            return this.empresa.es_mayorista
            ? 'Es mayorista'
            : 'No es mayorista';
        },
        
        idsJuridicas() {
            if (_.isEmpty(this.empresa.juridicas)) {
                return [];
            } else {
                return this.empresa.juridicas.map(
                    function (juridica) { return juridica.id; }
                );
            }
        },
        
        idsJuridicasGuardadas() {
            if (_.isEmpty(this.juridicasGuardadas)) {
                return [];
            } else {
                return this.juridicasGuardadas.map(
                    function (juridica) { return juridica.id; }
                );
            }
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
            es_mayorista: false,
            juridicas: []
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
        
        obtenido(empresa) {
            this.empresa = empresa;
            this.juridicasGuardadas = empresa.juridicas;
        },
        
        validado(errores) {
            this.validacion = errores;
        },
        
        guardado(id) {
            if (id !== null) {
                this.setID(id);
            }
            
            if(! _.isEmpty(this.idsJuridicas)) {
                let nuevas = _.difference(this.idsJuridicas, this.idsJuridicasGuardadas);
                
                if (! _.isEmpty(nuevas)) {
                    nuevas.forEach((id) => {
                        axios.post(`/juridicas/${id}/empresas/${this.id}`)
                        .then((response) => {
                            if (response.status === 201) {
                                this.exito({
                                    message: response.data.mensaje
                                });
                            }
                        })
                        .catch((error) => {
                            if (error.response && error.response.status === 400) {
                                this.error({
                                    message: error.response.data.mensaje
                                });
                            }
                        });
                    });
                }
                
                let eliminadas = _.difference(this.idsJuridicasGuardadas, this.idsJuridicas);
                
                if (! _.isEmpty(eliminadas)) {
                    eliminadas.forEach((id) => {
                        axios.delete(`/juridicas/${id}/empresas/${this.id}`)
                        .then((response) => {
                            if (response.status === 200) {
                                this.exito({
                                    message: response.data.mensaje
                                });
                            }
                        })
                        .catch((error) => {
                            if (error.response && error.response.status === 400) {
                                this.error({
                                    message: error.response.data.mensaje
                                });
                            }
                        });
                    });
                }
            }
            
            this.$emit('cerrar');
            this.$emit('guardado', this.id);
            BusEventos.$emit('VcFormEmpresa:guardada', this.id);
            this.resetearTodo();
        },
        
        deshacer(empresa) {
            this.empresa = empresa;
            this.juridicasGuardadas = empresa.juridicas;
        },
        
        cerrar() {
            this.$emit('cerrar');
            this.resetearTodo();
        },
        
        selectJuridicasInput(juridicas) {
            this.empresa.juridicas = juridicas;
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
