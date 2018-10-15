<template lang="html">

  <div>
    <base-tarjeta
      v-if="!tipoOrganizacionForm.visible"
      :titulo="tarjeta.titulo"
      :boton-izq-visible="tarjeta.botonIzqVisible"
      :boton-izq-tipo="tarjeta.botonIzqTipo"
      :confirmacion-requerida="fueModificada"
      :confirmacion-notificacion="tarjeta.confirmacion.notificacion"
      @cerrar="cerrar"
    >

      <form @submit.prevent="enviar">
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
            id="cuit"
            v-model="juridica.cuit"
            :class="{'is-invalid' : validacion.cuit}"
            type="text"
            name="cuit"
            class="form-control"
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
          />
        </fieldset>

        <fieldset class="form-group">
          <label for="denominacion">Denominación / Razón social</label>

          <input
            id="denominacion"
            v-model="juridica.denominacion"
            :class="{'is-invalid' : validacion.denominacion}"
            type="text"
            name="denominacion"
            class="form-control"
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
          />
        </fieldset>

        <fieldset>
          <label for="vc-select-tipo-org">
            Tipo de organización

            <plus-icon
              id="iconoNuevo"
              class="icono ml-2"
              @click="mostrarFormTipoOrg"
            />
          </label>

          <vc-select-tipo-org
            :tipos-organizacion="tiposOrganizacion"
            :tipo="juridica.tipo_organizacion"
            :error="validacion.tipo_organizacion_id"
            @buscar="buscarTiposOrganizacion"
            @input="inputTiposOrganizacion"
          />
        </fieldset>

        <div class="row mt-4">
          <div class="col">
            <vc-boton-submit :disabled="estaCargando"/>
          </div>

          <div class="col-auto ml-auto">
            <vc-boton-reset @click.native="restaurar"/>
          </div>
        </div>
      </form>

    </base-tarjeta>

    <vc-form-tipo-org
      v-if="tipoOrganizacionForm.visible"
      @guardado="guardadoFormTipoOrg"
      @cerrar="cerrarFormTipoOrg"
    />
  </div>

</template>

<script>
import { PlusIcon } from 'vue-feather-icons';
import { mapActions } from 'vuex';

import {
  CREAR_JURIDICA,
  ACTUALIZAR_JURIDICA
} from '../../store/tipos_acciones';
import { MODULO_JURIDICAS } from '../../store/tipos_modulos';

import { objetoTienePropiedades } from '../../common/components/validadores';
import {
  JURIDICA_POR_DEFECTO,
  JURIDICA_CLAVES
} from '../../common/components/persona_juridica';

/**
 * Eventos
 */
import { EVENTO_CERRAR } from '../../common/components/eventos_tarjeta';

/**
 * Componentes
 */
import BaseTarjeta from '../BaseTarjeta.vue';
import VcFormError from '../VcFormError.vue';
import VcBotonSubmit from '../VcBotonSubmit.vue';
import VcBotonReset from '../VcBotonReset.vue';
import VcFormTipoOrg from '../tipo_organizacion/VcFormTipoOrg.vue';
import VcSelectTipoOrg from '../tipo_organizacion/VcSelectTipoOrg.vue';

/**
 * Mixins
 */
import FiltroCuitMixin from '../../mixins/persona_juridica/filtro_cuit_mixin';

/**
 * Valores por defecto
 */
const VALIDACION_POR_DEFECTO = {
  cuit: null,
  denominacion: null,
  tipo_organizacion_id: null
};

const TARJETA = {
  botonIzqVisible: true,
  confirmacion: {
    notificacion: {
      titulo: 'Cerrar formulario',
      mensaje:
        'Se perderán todos los cambios de la persona jurídica que no se hayan guardado. ¿Estás seguro?'
    }
  }
};

const TARJETA_NUEVO = {
  titulo: 'Nueva persona jurídica',
  botonIzqTipo: 'cerrar',
  ...TARJETA
};

const TARJETA_EDITAR = {
  titulo: 'Editar persona jurídica',
  botonIzqTipo: 'volver',
  ...TARJETA
};

export default {
  name: 'VcFormJuridica',

  components: {
    PlusIcon,
    BaseTarjeta,
    VcFormError,
    VcBotonSubmit,
    VcBotonReset,
    VcSelectTipoOrg,
    VcFormTipoOrg
  },

  mixins: [FiltroCuitMixin],

  props: {
    personaJuridica: {
      type: Object,
      validator: function(juridica) {
        return objetoTienePropiedades(juridica, JURIDICA_CLAVES);
      },
      default: function() {
        return JURIDICA_POR_DEFECTO;
      }
    }
  },

  data() {
    return {
      juridica: null,
      validacion: null,
      tarjeta: null,
      estaCargando: false,

      tiposOrganizacion: [],
      tipoOrganizacionForm: {
        visible: false
      }
    };
  },

  computed: {
    esNueva() {
      return _.isEqual(JURIDICA_POR_DEFECTO, this.personaJuridica);
    },

    fueModificada() {
      return !_.isEqual(this.personaJuridica, this.juridica);
    },

    digitosCuit() {
      if (this.juridica.cuit) {
        const CUIT = this.juridica.cuit;
        const DIGITOS = CUIT.toString().length;
        const NUMERO = DIGITOS === 1 ? 'digito' : 'digitos';
        return `${DIGITOS} ${NUMERO}`;
      }
      return null;
    }
  },

  watch: {
    personaJuridica: {
      immediate: true,
      handler: function(juridica) {
        this.juridica = { ...juridica };
      }
    }
  },

  created() {
    this.tarjeta = this.esNueva ? TARJETA_NUEVO : TARJETA_EDITAR;
    this.resetearValidacion();
  },

  methods: {
    ...mapActions(MODULO_JURIDICAS, {
      crearJuridica: CREAR_JURIDICA,
      actualizarJuridica: ACTUALIZAR_JURIDICA
    }),

    buscarTiposOrganizacion(valorBuscado) {
      axios
        .get('/tipos-organizacion', {
          params: {
            busqueda: valorBuscado,
            limite: 10,
            pagina: 1,
            ordenarPor: 'descripcion',
            ascendente: 1,
            soloEliminados: 0
          }
        })
        .then((respuesta) => {
          const STATUS = respuesta.status;

          if (STATUS === 200) {
            this.tiposOrganizacion = respuesta.data.data;
          }
        })
        .catch((error) => {
          if (error.response) {
            const { status: STATUS } = error.response;

            switch (STATUS) {
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
        });
    },

    inputTiposOrganizacion(juridica) {
      let id = null;

      if (_.isObject(juridica) && _.has(juridica, 'id')) {
        this.juridica.tipo_organizacion = juridica;
        id = juridica.id;
      }

      this.juridica.tipo_organizacion_id = id;
    },

    mostrarFormTipoOrg() {
      this.tipoOrganizacionForm.visible = true;
    },

    cerrarFormTipoOrg() {
      this.tipoOrganizacionForm.visible = false;
    },

    guardadoFormTipoOrg(tipoOrganizacion) {
      this.juridica.tipo_organizacion_id = tipoOrganizacion.id;
      this.juridica.tipo_organizacion = tipoOrganizacion;
      this.cerrarFormTipoOrg();
    },

    enviar() {
      if (this.fueModificada) {
        this.estaCargando = true;

        let accion;

        if (this.esNueva) {
          accion = this.crearJuridica(this.juridica);
        } else {
          accion = this.actualizarJuridica({
            id: this.juridica.id,
            juridica: this.juridica
          });
        }

        accion
          .then(() => {
            if (this.esNueva) {
              this.restaurar();
            } else {
              this.cerrar();
            }
          })
          .catch((validacion) => {
            if (validacion) {
              this.validacion = validacion;
            }
          })
          .finally(() => {
            this.estaCargando = false;
          });
      }
    },

    restaurar() {
      this.resetearJuridica();
      this.resetearValidacion();
    },

    resetearJuridica() {
      this.juridica = { ...this.personaJuridica };
    },

    resetearValidacion() {
      this.validacion = { ...VALIDACION_POR_DEFECTO };
    },

    cerrar() {
      this.restaurar();
      this.$emit(EVENTO_CERRAR);
    }
  }
};
</script>

<style lang="css" scoped>
#iconoNuevo {
  margin-bottom: 5px;
}
</style>
