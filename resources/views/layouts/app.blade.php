@extends('layouts.boilerplate')

@section('body')
    <!-- Menu -->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
        <div class="container">
            <button class="navbar-toggler navbar-toggler-right" type="button"
            data-toggle="collapse" data-target="#barraNavegacion"
            aria-controls="barraNavegacion" aria-expanded="false"
            aria-label="Ver o ocultar la navegación">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="barraNavegacion">

                <a class="navbar-brand" href="{{ route('bienvenida') }}">Gestión de ordenes</a>

                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Ordenes</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Personas</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('juridicas.view') }}">Jurídicas</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('empresas.view') }}">Empresas</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdownMenu"role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Administración
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenu">
                            <h6 class="dropdown-header">Empresa</h6>
                            <a href="{{ route('actividades-economicas.view') }}" class="dropdown-item">Rubros</a>
                            
                            <div class="dropdown-divider"></div>
                            
                            <h6 class="dropdown-header">Persona jurídica</h6>
                            <a href="{{ route('tipos-organizacion.view') }}" class="dropdown-item">Tipos de organización</a>
                            
                            <div class="dropdown-divider"></div>
                            
                            <h6 class="dropdown-header">Seguridad</h6>
                            <a class="dropdown-item" href="#">Usuarios</a>
                        </div>
                    </li>
                </ul>

                <div class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" href="#">
                            {{ Auth::user()->display_name }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}">
                            Cerrar sesión
                        </a>
                    </li>
                </div>

            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <main role="main" id="main" class="container">
        @yield('container')
    </main>
@endsection
