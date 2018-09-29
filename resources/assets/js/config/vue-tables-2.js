export const TABLA_OPCIONES = {
  pagination: {
    chunk: 5
  },
  perPage: 10,
  perPageValues: [10, 15, 20],
  requestKeys: {
    query: 'busqueda',
    limit: 'limite',
    page: 'pagina',
    orderBy: 'ordenarPor',
    ascending: 'ascendente',
    byColumn: 'porColumna'
  },
  responseAdapter(response) {
    return {
      data: response.data.data,
      count: response.data.total
    };
  },
  skin: 'table table-bordered table-hover',
  sortIcon: {
    base: '',
    up: '',
    down: '',
    is: ''
  },
  saveState: true,
  storage: 'local',
  texts: {
    count:
      'Mostrando del {from} al {to} de {count} registros|{count} registros|Un registro',
    first: 'Primer',
    last: 'Último',
    filter: 'Filtro:',
    filterPlaceholder: '¿Qué estás buscando?',
    limit: 'Registros:',
    page: 'Página:',
    noResults:
      'No existen registros que coincidan con la búsqueda o no hay ningún registro guardado',
    filterBy: 'Filtrar por {column}',
    loading: 'Cargando...',
    defaultOption: 'Seleccionar {column}',
    columns: 'Columnas'
  }
};

export const TABLA_USAR_VUEX = false;
export const TABLA_TEMA = 'bootstrap4';
export const TABLA_PLANTILLA = 'footerPagination';

export default {
  TABLA_OPCIONES,
  TABLA_USAR_VUEX,
  TABLA_TEMA,
  TABLA_PLANTILLA
};
