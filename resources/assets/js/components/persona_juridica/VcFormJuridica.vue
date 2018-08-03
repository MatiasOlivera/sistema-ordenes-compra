<template lang="html">

    <div>
        <base-formulario
            v-if="!tipoOrganizacionForm.visible"
            :titulos="$options.static.titulos"
            :url="$options.static.url.juridicas"
            :id="id"
            :modelo="juridica"
            :modeloPorDefecto="$options.static.juridicaPorDefecto"
            :mensajes="$options.static.mensajes"
            @obtenido="setJuridica"
            @validado="validado"
            @guardado="guardado"
            @deshacer="setJuridica"
            @limpiar="resetearTodo"
            @cerrar="cerrar"
        >
        
            <fieldset class="form-group">
                <label for="cuit">CUIT
                    <span
                        v-if="digitosCuit"
                        class="text-muted"
                    >
                        {{ digitosCuit }} - {{ juridica.cuit | formatoCuit }}
                    </span>
                </label>

                <input
                    v-model="juridica.cuit"
                    :class="{'is-invalid' : validacion.cuit}"
                    type="text"
                    name="cuit"
                    class="form-control"
                    id="cuit"
                    aria-describedby="cuitAyuda"
                >

                <small
                    v-if="!validacion.cuit"
                    id="cuitAyuda"
                    class="form-text text-muted"
                >
                    El CUIT de la persona jurídica sin puntos ni guiones medios
                </small>
                <vc-form-error
                    v-else
                    :error="validacion.cuit"
                >
                </vc-form-error>
            </fieldset>

            <fieldset class="form-group">
                <label for="denominacion">Denominación / Razón social</label>

                <input
                    v-model="juridica.denominacion"
                    :class="{'is-invalid' : validacion.denominacion}"
                    type="text"
                    name="denominacion"
                    class="form-control"
                    id="denominacion"
                    aria-describedby="denominacionAyuda"
                >

                <small
                    v-if="!validacion.denominacion"
                    id="denominacionAyuda"
                    class="form-text text-muted"
                >
                    La denominación de la organización o razón social registrada en AFIP
                </small>
                <vc-form-error
                    v-else
                    :error="validacion.denominacion"
                >
                </vc-form-error>
            </fieldset>
            
            <fieldset>
                <label for="tipoOrganizacion">Tipo de organización</label>

                <div class="input-group">
                    <select
                        v-model="juridica.tipo_organizacion_id"
                        :class="{'is-invalid' : validacion.tipo_organizacion_id}"
                        name="tipoOrganizacion"
                        id="tipoOrganizacion"
                        class="custom-select"
                        aria-describedby="denominacionAyuda"
                    >
                        <option
                            v-for="tipo in tiposOrganizacion"
                            :key="tipo.id"
                            :value="tipo.id"
                            v-text="tipo.descripcion"
                        >
                        </option>
                    </select>
                    <div class="input-group-append">
                        <button
                            @click="mostrarFormTipoOrg"
                            type="button"
                            class="btn btn-secondary"
                        >
                            <plus-circle-icon class="icono"></plus-circle-icon>
                        </button>
                    </div>
                </div>
                
                <small
                    v-if="!validacion.tipo_organizacion_id"
                    id="tipoOrganizacionAyuda"
                    class="form-text text-muted"
                >
                    El tipo de organización de la persona jurídica
                </small>
                <vc-form-error
                    v-else
                    :error="validacion.tipo_organizacion_id"
                >
                </vc-form-error>
            </fieldset>
            
        </base-formulario>
        
        <vc-form-tipo-org
            v-if="tipoOrganizacionForm.visible"
            @guardado="guardadoFormTipoOrg"
            @cerrar="cerrarFormTipoOrg"
        >
        </vc-form-tipo-org>
    </div>

</template>

<script>
import { PlusCircleIcon } from 'vue-feather-icons';
import BaseFormulario     from '../../components/BaseFormulario.vue';
import VcFormError        from '../../components/VcFormError.vue';
import VcFormTipoOrg      from '../../components/tipo_organizacion/VcFormTipoOrg.vue';
import FiltroCuitMixin    from '../../mixins/persona_juridica/filtro_cuit_mixin.js';

export default {
    name: 'vc-form-juridica',
    components: {
        BaseFormulario,
        VcFormError,
        VcFormTipoOrg,
        PlusCircleIcon
    },
    mixins: [ FiltroCuitMixin ],
    data() {
        return {
            id: null,
            juridica: null,
            tiposOrganizacion: null,
            
            tipoOrganizacionForm: {
                visible: false
            },
            
            validacion: null
        }
    },
    computed: {
        digitosCuit() {
            if (this.juridica.cuit) {
                let cuit = this.juridica.cuit;
                let digitos = cuit.toString().length;
                let numero = digitos === 1 ? 'digito' : 'digitos';
                return `${digitos} ${numero}`;
            }
            return null;
        }
    },
    static: {
        titulos: {
            crear: 'Nueva persona jurídica',
            editar: 'Editar persona jurídica'
        },
        
        url: {
            juridicas: '/juridicas',
            tiposOrganizacion: '/tipos-organizacion'
        },
        
        mensajes: {
            obtener: {
                error: {
                    noEncontrado: {
                        titulo: 'No encontrada',
                        mensaje: 'La persona jurídica no existe o ha sido eliminada'
                    },
                    porDefecto: {
                        titulo: 'Error',
                        mensaje: 'No se pudo traer los datos de la persona jurídica'
                    }
                }
            },
            enviar: {
                error: {
                    porDefecto: {
                        titulo: 'Error',
                        mensaje: 'No se pudo crear la persona jurídica'
                    }
                }
            }
        },
        
        juridicaPorDefecto: {
            cuit: null,
            denominacion: null,
            tipo_organizacion_id: ''
        },
        
        validacionPorDefecto: {
            cuit: null,
            denominacion: null,
            tipo_organizacion_id: null
        },
        
        tiposOrganizacionPorDefecto: [{
            id: '',
            descripcion: 'Seleccione un tipo de organización'
        }]
    },
    created() {
        this.resetearTodo();
        this.obtenerTiposOrganizacion();

        BusEventos.$on('VcTablaJuridicas:editar', (id) => { this.setID(id) });
        BusEventos.$on('VcPerfilJuridica:editar', (id) => { this.setID(id) });
    },
    methods: {
        obtenerTiposOrganizacion() {
            axios.get(this.$options.static.url.tiposOrganizacion, {
                params: {
                    limite: 50,
                    pagina: 1,
                    ordenarPor: 'descripcion',
                    ascendente: 1,
                    soloEliminados: 0
                }
            })
            .then((response) => {
                let tipos = response.data.data;
                this.resetearTiposOrganizacion();
                this.tiposOrganizacion = this.tiposOrganizacion.concat(tipos);
            })
            .catch((error) => {
                if (error.response) {
                    let status = error.response.status;

                    switch (status) {
                        case 404:
                            this.error({
                                title: 'No encontrados',
                                message: 'No se ha encontrado ningún tipo de organización'
                            });

                            break;
                        default:
                            this.error({
                                title: 'Error',
                                message: 'No se pudo traer los tipos de organización'
                            });
                    }
                }
            })
        },
        
        mostrarFormTipoOrg() {
            this.tipoOrganizacionForm.visible = true;
        },
        
        cerrarFormTipoOrg() {
            this.tipoOrganizacionForm.visible = false;
        },
        
        guardadoFormTipoOrg(id) {
            this.obtenerTiposOrganizacion();
            this.juridica.tipo_organizacion_id = id;
        },
        
        setID(id) {
            this.id = id;
        },
        
        setJuridica(juridica) {
            if (juridica.tipo_organizacion === null) {
                juridica.tipo_organizacion_id = '';
            }
            
            this.juridica = juridica;
        },
        
        validado(errores) {
            this.validacion = errores;
        },
        
        guardado(id) {
            if (id !== null) {
                this.setID(id);
            }
            
            this.$emit('cerrar');
            BusEventos.$emit('VcFormJuridica:guardada', this.id);
            this.resetearFormulario();
        },
        
        cerrar() {
            this.$emit('cerrar');
            this.resetearFormulario();
        },      
        
        resetearId() {
            this.id = null;
        },
        
        resetearJuridica() {
            this.juridica = { ...this.$options.static.juridicaPorDefecto };
        },
        
        resetearValidacion() {
            this.validacion = { ...this.$options.static.validacionPorDefecto };
        },
        
        resetearTiposOrganizacion() {
            this.tiposOrganizacion = [ ...this.$options.static.tiposOrganizacionPorDefecto ];
        },
        
        resetearFormulario() {
            this.resetearJuridica();
            this.resetearId();
            this.resetearValidacion();
        },
        
        resetearTodo() {
            this.resetearJuridica();
            this.resetearId();
            this.resetearValidacion();
            this.resetearTiposOrganizacion();
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
