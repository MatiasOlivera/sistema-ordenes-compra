import Vue from 'vue';
import Router from 'vue-router';

import {
  RUTA_INDEX,
  RUTA_DASHBOARD,
  RUTA_JURIDICAS,
  RUTA_TIPOS_DE_ORG,
  RUTA_EMPRESAS,
  RUTA_ACTIVIDADES_ECONOMICAS
} from './rutas';

import ViewLogin from '../views/ViewLogin.vue';
import ViewDashboard from '../views/ViewDashboard.vue';
import ViewJuridicas from '../views/ViewJuridicas.vue';
import ViewTiposOrganizacion from '../views/ViewTiposOrganizacion.vue';
import ViewEmpresas from '../views/ViewEmpresas.vue';
import ViewActividades from '../views/ViewActividades.vue';

Vue.use(Router);

export default new Router({
  routes: [
    {
      name: RUTA_INDEX,
      path: '/',
      component: ViewLogin
    },
    {
      name: RUTA_DASHBOARD,
      path: '/inicio',
      component: ViewDashboard
    },
    {
      name: RUTA_JURIDICAS,
      path: '/personas-juridicas',
      component: ViewJuridicas
    },
    {
      name: RUTA_TIPOS_DE_ORG,
      path: '/tipos-organizaciones',
      component: ViewTiposOrganizacion
    },
    {
      name: RUTA_EMPRESAS,
      path: '/companias',
      component: ViewEmpresas
    },
    {
      name: RUTA_ACTIVIDADES_ECONOMICAS,
      path: '/rubros',
      component: ViewActividades
    }
  ]
});
