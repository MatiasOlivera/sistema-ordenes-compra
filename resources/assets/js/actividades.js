import ViewActividades from './views/ViewActividades.vue';

window.BusEventos = new Vue();

const vue = new Vue({
  el: '#main',
  components: { ViewActividades }
});
