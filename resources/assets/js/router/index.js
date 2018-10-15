import Vue from 'vue';
import Router from 'vue-router';

/**
 * Nombre de las rutas
 */
import {
  RUTA_INDEX,
  RUTA_DASHBOARD,
  RUTA_JURIDICAS,
  RUTA_JURIDICA_CREAR,
  RUTA_JURIDICA_PERFIL,
  RUTA_JURIDICA_EDITAR,
  RUTA_TIPOS_DE_ORG,
  RUTA_EMPRESAS,
  RUTA_ACTIVIDADES_ECONOMICAS
} from './rutas';

import ViewLogin from '../views/ViewLogin.vue';
import ViewDashboard from '../views/ViewDashboard.vue';

/**
 * Personas jurídicas
 */
import ViewJuridicas from '../views/persona_juridica/ViewJuridicas.vue';
import ViewJuridicasListado from '../views/persona_juridica/ViewJuridicasListado.vue';
import ViewJuridicasCrear from '../views/persona_juridica/ViewJuridicasCrear.vue';
import ViewJuridicasPerfil from '../views/persona_juridica/ViewJuridicasPerfil.vue';
import ViewJuridicasPerfilDetalle from '../views/persona_juridica/ViewJuridicasPerfilDetalle.vue';
import ViewJuridicasPerfilEditar from '../views/persona_juridica/ViewJuridicasPerfilEditar.vue';

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
      path: '/personas-juridicas',
      component: ViewJuridicas,
      children: [
        {
          name: RUTA_JURIDICAS,
          path: '',
          component: ViewJuridicasListado
        },
        {
          name: RUTA_JURIDICA_CREAR,
          path: 'nueva',
          component: ViewJuridicasCrear
        },
        {
          path: ':id',
          component: ViewJuridicasPerfil,
          children: [
            {
              name: RUTA_JURIDICA_PERFIL,
              path: '',
              component: ViewJuridicasPerfilDetalle
            },
            {
              name: RUTA_JURIDICA_EDITAR,
              path: 'editar',
              component: ViewJuridicasPerfilEditar
            }
          ]
        }
      ]
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
