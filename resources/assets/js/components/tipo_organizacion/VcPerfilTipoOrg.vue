<template lang="html">

  <div>
    <!-- Detalle del tipo de organización -->
    <vc-detalle-tipo-org
      v-show="ui.detalle.visible"
      :tipo-organizacion="tipo"
      @editar="editar"
      @dado-de-baja="obtener"
      @dado-de-alta="obtener"
      @cerrar="cerrar"
    />

    <vc-form-tipo-org
      v-show="!ui.detalle.visible"
      :tipo-organizacion="tipo"
      @actualizado="actualizado"
      @cerrar="verDetalle"
    />
  </div>

</template>

<script>
import apiTipoOrganizacion from '../../api/tipo_organizacion';

/**
 * Eventos
 */
import { EVENTO_CERRAR } from '../../common/components/eventos_tarjeta';

/**
 * Componentes
 */
import VcDetalleTipoOrg from './VcDetalleTipoOrg.vue';
import VcFormTipoOrg from './VcFormTipoOrg.vue';

export default {
  name: 'VcPerfilTipoOrg',

  components: {
    VcDetalleTipoOrg,
    VcFormTipoOrg
  },

  data() {
    return {
      id: null,
      tipo: {
        descripcion: '',
        created_at: new Date(),
        updated_at: new Date(),
        deleted_at: new Date()
      },
      ui: {
        detalle: {
          visible: true
        }
      }
    };
  },

  watch: {
    id: function(id) {
      if (id !== null) this.obtener();
    }
  },

  created() {
    BusEventos.$on('VcTablaTipoOrg:verPerfil', (id) => {
      this.setID(id);
      this.verDetalle();
    });

    BusEventos.$on('VcTablaTipoOrg:editar', (id) => {
      this.setID(id);
      this.editar();
    });

    BusEventos.$on('VcTablaTipoOrg:eliminado', (id) => {
      this.actualizar(id);
    });

    BusEventos.$on('VcTablaTipoOrg:restaurado', (id) => {
      this.actualizar(id);
    });
  },

  methods: {
    setID(id) {
      this.id = id;
    },

    actualizar(id) {
      if (id !== null && this.id === id) {
        this.obtener();
      }
    },

    obtener() {
      apiTipoOrganizacion
        .obtener(this.id)
        .then((respuesta) => {
          const STATUS = respuesta.status;

          if (STATUS === 200) {
            this.tipo = respuesta.data;
          }
        })
        .catch(({ notificacion }) => {
          if (notificacion) {
            this.error(notificacion);
          }
        });
    },

    actualizado() {
      this.obtener();
      this.verDetalle();
    },

    verDetalle() {
      this.ui.detalle.visible = true;
    },

    editar() {
      this.ui.detalle.visible = false;
    },

    cerrar() {
      this.$emit(EVENTO_CERRAR);
    }
  },

  notifications: {
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
