<template>
  <div>
    <la-cabecera/>

    <router-view/>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import { MODULO_NOTIFICACIONES } from './store/tipos_modulos';

import LaCabecera from './components/LaCabecera.vue';

export default {
  name: 'App',

  components: { LaCabecera },

  computed: {
    ...mapGetters(MODULO_NOTIFICACIONES, ['ultima'])
  },

  watch: {
    ultima: {
      /* eslint-disable object-shorthand, func-names */
      handler: function(notificacion) {
        this.mostrarNotificacion(notificacion);
      },
      deep: true
    }
  },

  notifications: {
    mostrarNotificacion: {
      titulo: '',
      mensaje: '',
      tipo: ''
    }
  }
};
</script>

<style>
</style>
