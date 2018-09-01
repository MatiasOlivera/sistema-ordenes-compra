<template lang="html">

  <base-tabla
    :nombre="$options.static.nombre"
    :url="$options.static.url"
    :columnas="$options.static.columnas"
    :opciones="$options.static.opciones"
    :campo-nombre="$options.static.campoNombre"
    :obtener-tabla="obtenerTabla"
    @ver-perfil="verPerfil"
    @editar="editar"
    @dar-de-baja="darDeBaja"
    @dar-de-alta="darDeAlta"
  />

</template>

<script>
/**
 * Componentes
 */
import BaseTabla from '../BaseTabla.vue';
import DarBajaInstanciaMixin from '../../mixins/dar_baja_instancia_mixin';
import DarAltaInstanciaMixin from '../../mixins/dar_alta_instancia_mixin';

export default {
  name: 'VcTablaActividades',

  components: { BaseTabla },

  mixins: [DarBajaInstanciaMixin, DarAltaInstanciaMixin],

  data() {
    return {
      obtenerTabla: false
    };
  },

  created() {
    BusEventos.$on('VcFormActividad:guardado', () => {
      this.obtenerRegistros();
    });

    BusEventos.$on('VcPerfilActividad:eliminado', () => {
      this.obtenerRegistros();
    });

    BusEventos.$on('VcPerfilActividad:restaurado', () => {
      this.obtenerRegistros();
    });
  },

  static: {
    nombre: 'actividades',
    url: '/actividades-economicas',
    columnas: ['descripcion'],

    opciones: {
      headings: {
        descripcion: 'Descripción'
      },
      orderBy: {
        column: 'descripcion',
        ascending: true
      },
      sortable: ['descripcion']
    },

    campoNombre: 'descripcion',

    mensajes: {
      alta: {
        error: {
          noEncontrado: {
            titulo: 'No encontrado',
            mensaje: 'El rubro no existe o ha sido eliminado'
          },
          porDefecto: {
            titulo: 'Error',
            mensaje: 'No se pudo dar de alta al rubro'
          }
        }
      },
      baja: {
        error: {
          noEncontrado: {
            titulo: 'No encontrado',
            mensaje: 'El rubro no existe o ha sido eliminado'
          },
          porDefecto: {
            titulo: 'Error',
            mensaje: 'No se pudo dar de baja al rubro'
          }
        }
      }
    }
  },

  methods: {
    verPerfil(id) {
      BusEventos.$emit('VcTablaActividades:verPerfil', id);
      this.$emit('mostrar-perfil');
    },

    editar(id) {
      BusEventos.$emit('VcTablaActividades:editar', id);
      this.$emit('mostrar-perfil');
    },

    darDeBaja(id) {
      this.$_darBajaInstanciaMixin_eliminar(
        `${this.$options.static.url}/${id}`,
        () => {
          BusEventos.$emit('VcTablaActividades:eliminado', id);
          this.obtenerRegistros();
        },
        this.$options.static.mensajes.baja
      );
    },

    darDeAlta(id) {
      this.$_darAltaInstanciaMixin_restaurar(
        `${this.$options.static.url}/${id}/restore`,
        () => {
          this.obtenerRegistros();
          BusEventos.$emit('VcTablaActividades:restaurado', id);
        },
        this.$options.static.mensajes.alta
      );
    },

    obtenerRegistros() {
      this.obtenerTabla = true;
      this.$nextTick(() => {
        this.obtenerTabla = false;
      });
    }
  }
};
</script>

<style lang="css">
</style>
