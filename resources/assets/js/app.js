
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./libraries');

window.Vue = require('vue');

/**
 * Vue-tables-2
 */

import { ServerTable, Event } from 'vue-tables-2';

const OpcionesVueTables = {
    pagination: {
        chunk: 5
    },
    perPage: 10,
    perPageValues: [10, 15, 20],
    requestKeys: {
        query:     'busqueda',
        limit:     'limite',
        page:      'pagina',
        orderBy:   'ordenarPor',
        ascending: 'ascendente',
        byColumn:  'porColumna'
    },
    responseAdapter(response) {
        return {
            data:  response.data.data,
            count: response.data.total
        }
    },
    skin: 'table table-bordered table-hover',
    sortIcon: {
        base: '',
        up:   '',
        down: '',
        is:   ''
    },
    saveState: true,
    storage: 'local',
    texts: {
        count:             'Mostrando del {from} al {to} de {count} registros|{count} registros|Un registro',
        first:             'Primer',
        last:              'Último',
        filter:            'Filtro:',
        filterPlaceholder: '¿Qué estás buscando?',
        limit:             'Registros:',
        page:              'Página:',
        noResults:         'No existen registros que coincidan con la búsqueda o no hay ningún registro guardado',
        filterBy:          'Filtrar por {column}',
        loading:           'Cargando...',
        defaultOption:     'Seleccionar {column}',
        columns:           'Columnas'
    }
}

Vue.use(ServerTable, OpcionesVueTables, false, 'bootstrap4', 'footerPagination');

/**
 * Vue-notifications
 */

import VueNotifications from 'vue-notifications';
import iziToast from 'izitoast';

function notificacion ({title, message, type, timeout, cb, buttons = []}) {
    if (type === VueNotifications.types.warn) type = 'warning';
    return iziToast[type]({title, message, timeout, buttons});
};

const TiposDeNotificacion = {
    success:  notificacion,
    error:    notificacion,
    info:     notificacion,
    warn:     notificacion,
    question: notificacion
};

VueNotifications.config.timeout = 10000;

Vue.use(VueNotifications, TiposDeNotificacion);
