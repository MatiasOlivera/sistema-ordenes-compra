import Vue from 'vue';
import Router from 'vue-router';

import {
  INDEX,
  DASHBOARD,
  PERSONAS_JURIDICAS,
  TIPOS_DE_ORGANIZACIONES,
  EMPRESAS,
  ACTIVIDADES_ECONOMICAS
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
      name: INDEX,
      path: '/',
      component: ViewLogin
    },
    {
      name: DASHBOARD,
      path: '/inicio',
      component: ViewDashboard
    },
    {
      name: PERSONAS_JURIDICAS,
      path: '/personas-juridicas',
      component: ViewJuridicas
    },
    {
      name: TIPOS_DE_ORGANIZACIONES,
      path: '/tipos-organizaciones',
      component: ViewTiposOrganizacion
    },
    {
      name: EMPRESAS,
      path: '/companias',
      component: ViewEmpresas
    },
    {
      name: ACTIVIDADES_ECONOMICAS,
      path: '/rubros',
      component: ViewActividades
    }
  ]
});
