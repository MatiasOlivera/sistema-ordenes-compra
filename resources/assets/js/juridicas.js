import ViewJuridicas from './views/ViewJuridicas.vue';

window.BusEventos = new Vue();

const vue = new Vue({
  el: '#main',
  components: { ViewJuridicas }
});
