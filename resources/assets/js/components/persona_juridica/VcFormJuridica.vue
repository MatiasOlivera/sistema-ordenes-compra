<template lang="html">

    <base-formulario
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

        <fieldset class="form-group">
            <label for="tipoOrganizacion">Tipo de organización</label>

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

</template>

<script>
import BaseFormulario from '../../components/BaseFormulario.vue';
import VcFormError from '../../components/VcFormError.vue';
import FiltroCuitMixin from '../../mixins/persona_juridica/filtro_cuit_mixin.js';

export default {
    name: 'vc-form-juridica',
    components: {
        BaseFormulario,
        VcFormError
    },
    mixins: [ FiltroCuitMixin ],
    data() {
        return {
            id: null,
            juridica: null,
            
            tiposOrganizacion: [{
                id: '',
                descripcion: 'Seleccione un tipo de organización'
            }],
            
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
        }
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
                    page: 1,
                    limit: 50,
                    orderBy: 'descripcion',
                    ascending: 1
                }
            })
            .then((response) => {
                let tipos = response.data.data;
                tipos.forEach((tipo) => {
                    this.tiposOrganizacion.push(tipo)
                });
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
        
        guardado() {
            this.$emit('cerrar');
            BusEventos.$emit('VcFormJuridica:guardada', this.id);
            this.resetearTodo();
        },
        
        cerrar() {
            this.$emit('cerrar');
            this.resetearTodo();
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
        
        resetearTodo() {
            this.resetearJuridica();
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
