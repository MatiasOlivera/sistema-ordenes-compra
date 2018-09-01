import ViewEmpresas from './views/ViewEmpresas.vue';

window.BusEventos = new Vue();

const vue = new Vue({
  el: '#main',
  components: { ViewEmpresas }
});
