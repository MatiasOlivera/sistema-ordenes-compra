<template lang="html">

  <div>
    <!-- Detalle de la actividad económica -->
    <vc-detalle-actividad
      v-show="ui.detalle.visible"
      :actividad="actividad"
      @editar="editar"
      @dado-de-baja="obtener"
      @dado-de-alta="obtener"
      @cerrar="cerrar"
    />

    <vc-form-actividad
      v-show="!ui.detalle.visible"
      :actividad-economica="actividad"
      @actualizado="actualizada"
      @cerrar="verDetalle"
    />
  </div>

</template>

<script>
import apiActividad from '../../common/api/actividad_economica';

/**
 * Eventos
 */
import { EVENTO_CERRAR } from '../../common/components/eventos_tarjeta';

/**
 * Componentes
 */
import VcDetalleActividad from './VcDetalleActividad.vue';
import VcFormActividad from './VcFormActividad.vue';

export default {
  name: 'VcPerfilActividad',

  components: {
    VcDetalleActividad,
    VcFormActividad
  },

  data() {
    return {
      id: null,
      actividad: {
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
    BusEventos.$on('VcTablaActividades:verPerfil', (id) => {
      this.setID(id);
      this.verDetalle();
    });

    BusEventos.$on('VcTablaActividades:editar', (id) => {
      this.setID(id);
      this.editar();
    });

    BusEventos.$on('VcTablaActividades:eliminado', (id) => {
      this.actualizar(id);
    });

    BusEventos.$on('VcTablaActividades:restaurado', (id) => {
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
      apiActividad
        .obtener(this.id)
        .then((respuesta) => {
          const STATUS = respuesta.status;

          if (STATUS === 200) {
            this.actividad = respuesta.data;
          }
        })
        .catch(({ notificacion }) => {
          if (notificacion) {
            this.error(notificacion);
          }
        });
    },

    actualizada() {
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
