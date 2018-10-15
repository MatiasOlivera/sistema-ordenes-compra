<template lang="html">

  <base-tabla
    :nombre="this.$options.static.nombre"
    :url="this.$options.static.url"
    :columnas="this.$options.static.columnas"
    :opciones="this.$options.static.opciones"
    :campo-nombre="this.$options.static.campoNombre"
    :obtener-tabla="obtenerTabla"
    @ver-perfil="verPerfil"
    @editar="editar"
    @dar-de-baja="darDeBaja"
    @dar-de-alta="darDeAlta"
  />

</template>

<script>
import { mapActions } from 'vuex';
import { MODULO_JURIDICAS } from '../../store/tipos_modulos';
import {
  ELIMINAR_JURIDICA,
  RESTAURAR_JURIDICA
} from '../../store/tipos_acciones';

import { RUTA_JURIDICA_PERFIL, RUTA_JURIDICA_EDITAR } from '../../router/rutas';

import BaseTabla from '../BaseTabla.vue';

export default {
  name: 'VcTablaJuridicas',

  components: { BaseTabla },

  data() {
    return {
      obtenerTabla: false
    };
  },

  static: {
    nombre: 'juridicas',
    url: '/juridicas',

    columnas: ['denominacion', 'cuit', 'tipo_organizacion.descripcion'],

    opciones: {
      headings: {
        denominacion: 'Denominación',
        cuit: 'CUIT',
        'tipo_organizacion.descripcion': 'Tipo de organización'
      },
      orderBy: {
        column: 'denominacion',
        ascending: true
      },
      sortable: ['denominacion', 'cuit']
    },

    campoNombre: 'denominacion'
  },

  methods: {
    ...mapActions(MODULO_JURIDICAS, [ELIMINAR_JURIDICA, RESTAURAR_JURIDICA]),

    verPerfil(id) {
      this.$router.push({ name: RUTA_JURIDICA_PERFIL, params: { id } });
    },

    editar(id) {
      this.$router.push({ name: RUTA_JURIDICA_EDITAR, params: { id } });
    },

    darDeBaja(id) {
      this.eliminarJuridica(id).then(() => {
        this.obtenerRegistros();
      });
    },

    darDeAlta(id) {
      this.restaurarJuridica(id).then(() => {
        this.obtenerRegistros();
      });
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
