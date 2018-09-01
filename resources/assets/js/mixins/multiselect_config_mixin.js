import Multiselect from 'vue-multiselect';
import 'vue-multiselect/dist/vue-multiselect.min.css';

export default {
  components: {
    Multiselect
  },
  data() {
    return {
      searchable: true,
      placeholder: 'Selecciona una opción',
      internalSearch: true,
      selectLabel: 'Presiona enter para seleccionar',
      selectGroupLabel: 'Presiona enter para seleccionar el grupo',
      selectedLabel: 'Seleccionado',
      deselectLabel: 'Presiona enter para deseleccionar',
      deselectGroupLabel: 'Presiona enter para deseleccionar el grupo',
      openDirection: 'bottom'
    };
  },
  methods: {
    limitText(count) {
      return `y ${count} más`;
    }
  }
};
