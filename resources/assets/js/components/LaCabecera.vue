<template>

  <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
    <div class="container">
      <button
        class="navbar-toggler navbar-toggler-right"
        type="button"
        data-toggle="collapse"
        data-target="#barraNavegacion"
        aria-controls="barraNavegacion"
        aria-expanded="false"
        aria-label="Ver o ocultar la navegación"
      >
        <span class="navbar-toggler-icon"/>
      </button>

      <div
        id="barraNavegacion"
        class="collapse navbar-collapse"
      >

        <router-link
          :to="{ name: rutas.dashboard }"
          class="navbar-brand"
        >
          Gestión de ordenes
        </router-link>

        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a
              class="nav-link"
              href="#"
            >
              Ordenes
            </a>
          </li>

          <li class="nav-item">
            <a
              class="nav-link"
              href="#"
            >
              Personas
            </a>
          </li>

          <li class="nav-item">
            <router-link
              :to="{ name: rutas.juridicas }"
              class="nav-link"
            >
              Jurídicas
            </router-link>
          </li>

          <li class="nav-item">
            <router-link
              :to="{ name: rutas.empresas }"
              class="nav-link"
            >
              Empresas
            </router-link>
          </li>

          <li class="nav-item dropdown">
            <a
              id="dropdownMenu"
              class="nav-link dropdown-toggle"
              href="#"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              Administración
            </a>

            <div
              class="dropdown-menu"
              aria-labelledby="dropdownMenu"
            >
              <h6 class="dropdown-header">Empresa</h6>
              <router-link
                :to="{ name: rutas.actividades }"
                class="dropdown-item"
              >
                Rubros
              </router-link>

              <div class="dropdown-divider"/>

              <h6 class="dropdown-header">Persona jurídica</h6>
              <router-link
                :to="{ name: rutas.tiposDeOrg }"
                class="dropdown-item"
              >
                Tipos de organización
              </router-link>

              <div class="dropdown-divider"/>

              <h6 class="dropdown-header">Seguridad</h6>
              <a
                class="dropdown-item"
                href="#"
              >
                Usuarios
              </a>
            </div>
          </li>
        </ul>

        <div class="navbar-nav">
          <li class="nav-item">
            <a
              class="nav-link font-weight-bold"
              href="#"
            >
              Nombre del usuario
            </a>
          </li>

          <li class="nav-item">
            <a
              class="nav-link"
              href="#"
            >
              Cerrar sesión
            </a>
          </li>
        </div>

      </div>
    </div>
  </nav>

</template>

<script>
import {
  RUTA_DASHBOARD,
  RUTA_JURIDICAS,
  RUTA_TIPOS_DE_ORG,
  RUTA_EMPRESAS,
  RUTA_ACTIVIDADES_ECONOMICAS
} from '../router/rutas';

export default {
  name: 'LaCabecera',
  data() {
    return {
      rutas: {
        dashboard: RUTA_DASHBOARD,
        juridicas: RUTA_JURIDICAS,
        tiposDeOrg: RUTA_TIPOS_DE_ORG,
        empresas: RUTA_EMPRESAS,
        actividades: RUTA_ACTIVIDADES_ECONOMICAS
      }
    };
  }
};
</script>

<style scoped>
</style>
