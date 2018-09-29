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

        <a
          class="navbar-brand"
          href="#"
        >
          Gestión de ordenes
        </a>

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
            <a
              class="nav-link"
              href="#"
            >
              Jurídicas
            </a>
          </li>

          <li class="nav-item">
            <a
              class="nav-link"
              href="#"
            >
              Empresas
            </a>
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
              <a
                href="#"
                class="dropdown-item"
              >
                Rubros
              </a>

              <div class="dropdown-divider"/>

              <h6 class="dropdown-header">Persona jurídica</h6>
              <a
                href="#"
                class="dropdown-item"
              >
                Tipos de organización
              </a>

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
export default {
  name: 'LaCabecera'
};
</script>

<style scoped>
</style>
