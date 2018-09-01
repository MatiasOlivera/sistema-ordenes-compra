<template lang="html">

  <base-perfil
    :titulo="titulo"
    :nombre-instancia="empresa.nombre_fantasia"
    :eliminado="eliminado"
    @editar="editar"
    @dar-de-baja="darDeBaja"
    @dar-de-alta="darDeAlta"
    @cerrar="cerrar"
  >

    <template slot="acciones">

      <button
        v-if="esProveedor"
        type="button"
        name="bajaProveedor"
        class="btn btn-sm btn-outline-warning"
        @click="bajaProveedor"
      >
        <truck-icon class="icono"/> Baja proveedor
      </button>

      <button
        v-else
        type="button"
        name="altaProveedor"
        class="btn btn-sm btn-outline-primary"
        @click="altaProveedor"
      >
        <truck-icon class="icono"/> Alta proveedor
      </button>

    </template>

    <template>

      <dl>
        <dt>Nombre de fantasía:</dt>
        <dd>{{ empresa.nombre_fantasia }}</dd>

        <dt>Mayorista:</dt>
        <dd>
          <vc-icono-estado :estado="empresa.es_mayorista"/>
        </dd>

        <dt>Proveedor:</dt>
        <dd>
          <vc-icono-estado :estado="esProveedor"/>
        </dd>

        <dt>Creado:</dt>
        <dd>
          {{ empresa.created_at | moment('from') }},
          {{ empresa.created_at | moment('L LT a') }}
        </dd>

        <dt>Actualizado:</dt>
        <dd>
          {{ empresa.updated_at | moment('from') }},
          {{ empresa.updated_at | moment('L LT a') }}
        </dd>

        <template v-if="eliminado">
          <dt>Eliminado:</dt>
          <dd>
            {{ empresa.deleted_at | moment('from') }},
            {{ empresa.deleted_at | moment('L LT a') }}
          </dd>
        </template>
      </dl>

    </template>

  </base-perfil>

</template>

<script>
import { TruckIcon } from 'vue-feather-icons';

/**
 * Mixins
 */
import DarBajaInstanciaMixin from '../../mixins/dar_baja_instancia_mixin';
import DarAltaInstanciaMixin from '../../mixins/dar_alta_instancia_mixin';

/**
 * Componentes
 */
import BasePerfil from '../BasePerfil.vue';
import VcIconoEstado from '../VcIconoEstado.vue';

export default {
  name: 'VcDetalleEmpresa',

  components: {
    BasePerfil,
    VcIconoEstado,
    TruckIcon
  },

  mixins: [DarBajaInstanciaMixin, DarAltaInstanciaMixin],

  props: {
    empresa: {
      type: Object,
      required: true
    }
  },

  computed: {
    titulo() {
      return `Perfil de ${this.empresa.nombre_fantasia}`;
    },

    esProveedor() {
      return !_.isNull(this.empresa.proveedor);
    },

    eliminado() {
      return !_.isNull(this.empresa.deleted_at);
    },

    urlEspecifica() {
      return `${this.$options.static.url.empresas}/${this.empresa.id}`;
    }
  },

  static: {
    url: {
      empresas: '/empresas'
    }
  },

  methods: {
    editar() {
      this.$emit('editar');
    },

    altaProveedor() {
      axios
        .post(`${this.urlEspecifica}/proveedor`)
        .then((response) => {
          this.$emit('alta-proveedor');
          BusEventos.$emit('VcPerfilEmpresa:altaProveedor');

          this.exito({
            title: 'Éxito',
            message: response.data.mensaje
          });
        })
        .catch((error) => {
          this.error({
            title: 'Error',
            message: error.response.data.mensaje
          });
        });
    },

    bajaProveedor() {
      this.$_darBajaInstanciaMixin_eliminar(
        `${this.urlEspecifica}/proveedor`,
        () => {
          this.$emit('baja-proveedor');
          BusEventos.$emit('VcPerfilEmpresa:bajaProveedor');
        }
      );
    },

    darDeBaja() {
      this.$_darBajaInstanciaMixin_eliminar(this.urlEspecifica, () => {
        this.$emit('dar-de-baja');
        BusEventos.$emit('VcPerfilEmpresa:eliminada');
      });
    },

    darDeAlta() {
      this.$_darAltaInstanciaMixin_restaurar(
        `${this.urlEspecifica}/restore`,
        () => {
          this.$emit('dar-de-alta');
          BusEventos.$emit('VcPerfilEmpresa:restaurada');
        }
      );
    },

    cerrar() {
      this.$emit('cerrar');
    }
  }
};
</script>

<style lang="css">
</style>
