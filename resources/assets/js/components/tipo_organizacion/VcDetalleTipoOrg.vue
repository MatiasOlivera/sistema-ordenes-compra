<template lang="html">

  <base-perfil
    :titulo="titulo"
    :nombre-instancia="tipoOrganizacion.descripcion"
    :eliminado="eliminado"
    @editar="editar"
    @dar-de-baja="darDeBaja"
    @dar-de-alta="darDeAlta"
    @cerrar="cerrar"
  >
    <dl>
      <dt>Descripcion:</dt>
      <dd>{{ tipoOrganizacion.descripcion }}</dd>

      <dt>Creado:</dt>
      <dd>
        {{ tipoOrganizacion.created_at | moment('from') }},
        {{ tipoOrganizacion.created_at | moment('L LT a') }}
      </dd>

      <dt>Actualizado:</dt>
      <dd>
        {{ tipoOrganizacion.updated_at | moment('from') }},
        {{ tipoOrganizacion.updated_at | moment('L LT a') }}
      </dd>

      <template v-if="eliminado">
        <dt>Eliminado:</dt>
        <dd>
          {{ tipoOrganizacion.deleted_at | moment('from') }},
          {{ tipoOrganizacion.deleted_at | moment('L LT a') }}
        </dd>
      </template>
    </dl>
  </base-perfil>

</template>

<script>
import apiTipoOrganizacion from '../../common/api/tipo_organizacion';
import { objetoTienePropiedades } from '../../common/components/validadores';
import { TIPO_CLAVES } from '../../common/components/tipo_organizacion';

/**
 * Componentes
 */
import BasePerfil from '../BasePerfil.vue';

export default {
  name: 'VcDetalleTipoOrg',

  components: { BasePerfil },

  props: {
    tipoOrganizacion: {
      type: Object,
      validator: function(tipo) {
        return objetoTienePropiedades(tipo, TIPO_CLAVES);
      },
      required: true
    }
  },

  computed: {
    titulo() {
      return `Detalle de ${this.tipoOrganizacion.descripcion}`;
    },

    eliminado() {
      return !_.isNull(this.tipoOrganizacion.deleted_at);
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
      apiTipoOrganizacion
        .darDeBaja(this.tipoOrganizacion.id)
        .then((respuesta) => {
          const STATUS = respuesta.status;

          if (STATUS === 200) {
            this.exito(respuesta.notificacion);

            this.$emit('dado-de-baja');
            BusEventos.$emit('VcPerfilTipoOrg:eliminado');
          }
        })
        .catch(({ notificacion }) => {
          if (notificacion) {
            this.error(notificacion);
          }
        });
    },

    darDeAlta() {
      apiTipoOrganizacion
        .darDeAlta(this.tipoOrganizacion.id)
        .then((respuesta) => {
          const STATUS = respuesta.status;

          if (STATUS === 200) {
            this.exito(respuesta.notificacion);

            this.$emit('dado-de-alta');
            BusEventos.$emit('VcPerfilTipoOrg:restaurado');
          }
        })
        .catch(({ notificacion }) => {
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
};
</script>

<style lang="css">
</style>
