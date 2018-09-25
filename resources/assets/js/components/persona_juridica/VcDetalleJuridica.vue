<template lang="html">

  <base-perfil
    :titulo="titulo"
    :nombre-instancia="juridica.denominacion"
    :eliminado="eliminado"
    @editar="editar"
    @dar-de-baja="darDeBaja"
    @dar-de-alta="darDeAlta"
    @cerrar="cerrar"
  >

    <dl>
      <dt>Denominación:</dt>
      <dd>{{ juridica.denominacion }}</dd>

      <dt>CUIT:</dt>
      <dd>{{ juridica.cuit | formatoCuit }}</dd>

      <dt>Tipo de organización:</dt>
      <dd>{{ juridica.tipo_organizacion.descripcion }}</dd>

      <dt>Creado:</dt>
      <dd>
        {{ juridica.created_at | formatoRelativo }},
        {{ juridica.created_at | formatoFecha }}
      </dd>

      <dt>Actualizado:</dt>
      <dd>
        {{ juridica.updated_at | formatoRelativo }},
        {{ juridica.updated_at | formatoFecha }}
      </dd>

      <template v-if="eliminado">
        <dt>Eliminado:</dt>
        <dd>
          {{ juridica.deleted_at | formatoRelativo }},
          {{ juridica.deleted_at | formatoFecha }}
        </dd>
      </template>
    </dl>

  </base-perfil>

</template>

<script>
import apiPersonaJuridica from '../../common/api/persona_juridica';
import { objetoTienePropiedades } from '../../common/components/validadores';
import { JURIDICA_CLAVES } from '../../common/components/persona_juridica';

/**
 * Mixins
 */
import FiltroCuitMixin from '../../mixins/persona_juridica/filtro_cuit_mixin';
import formatoFecha from '../../mixins/formato_fecha_mixin';
import formatoRelativo from '../../mixins/formato_relativo_mixin';

/**
 * Componentes
 */
import BasePerfil from '../BasePerfil.vue';

export default {
  name: 'VcDetalleJuridica',

  components: { BasePerfil },

  mixins: [FiltroCuitMixin, formatoFecha, formatoRelativo],

  props: {
    juridica: {
      type: Object,
      validator: function(juridica) {
        return objetoTienePropiedades(juridica, JURIDICA_CLAVES);
      },
      required: true
    }
  },

  computed: {
    titulo() {
      return `Perfil de ${this.juridica.denominacion}`;
    },

    eliminado() {
      return !_.isNull(this.juridica.deleted_at);
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
      apiPersonaJuridica
        .darDeBaja(this.juridica.id)
        .then((respuesta) => {
          const STATUS = respuesta.status;

          if (STATUS === 200) {
            this.exito(respuesta.notificacion);

            this.$emit('dado-de-baja');
            BusEventos.$emit('VcPerfilJuridica:eliminada');
          }
        })
        .catch(({ notificacion }) => {
          if (notificacion) {
            this.error(notificacion);
          }
        });
    },

    darDeAlta() {
      apiPersonaJuridica
        .darDeAlta(this.juridica.id)
        .then((respuesta) => {
          const STATUS = respuesta.status;

          if (STATUS === 200) {
            this.exito(respuesta.notificacion);

            this.$emit('dado-de-alta');
            BusEventos.$emit('VcPerfilJuridica:restaurada');
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
