<template lang="html">

  <base-perfil
    :titulo="titulo"
    :nombre-instancia="juridica.denominacion"
    :eliminado="eliminado"
    @editar="editar"
    @dar-de-baja="darDeBaja(juridica.id)"
    @dar-de-alta="darDeAlta(juridica.id)"
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
import { mapActions } from 'vuex';
import {
  ELIMINAR_JURIDICA,
  RESTAURAR_JURIDICA
} from '../../store/tipos_acciones';
import { MODULO_JURIDICAS } from '../../store/tipos_modulos';

import { RUTA_JURIDICAS, RUTA_JURIDICA_EDITAR } from '../../router/rutas';

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
    ...mapActions(MODULO_JURIDICAS, {
      darDeBaja: ELIMINAR_JURIDICA,
      darDeAlta: RESTAURAR_JURIDICA
    }),

    editar() {
      this.$router.push({ name: RUTA_JURIDICA_EDITAR });
    },

    cerrar() {
      this.$router.push({ name: RUTA_JURIDICAS });
    }
  }
};
</script>

<style lang="css">
</style>
