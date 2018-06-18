@extends('layouts.boilerplate')

@section('body')
    <!-- Menu -->
    <div class="container">
        <nav class="navbar navbar-expand-md navbar-light bg-light">

            <a class="navbar-brand" href="#">Sistema de ordenes</a>

            <button class="navbar-toggler navbar-toggler-right" type="button"
            data-toggle="collapse" data-target="#barraNavegacion"
            aria-controls="barraNavegacion" aria-expanded="false"
            aria-label="Ver o ocultar la navegación">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="barraNavegacion">

                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            Inicio <span class="sr-only">(seleccionado)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Ordenes</a>
                    </li>
                </ul>

                <div class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#"
                        id="navbarDropdown" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                            Nombre del usuario
                        </a>

                        <div class="dropdown-menu"
                        aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Mi perfil</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Cerrar sesión</a>
                        </div>
                    </li>
                </div>

            </div>
        </nav>
    </div>

    <!-- Contenido principal -->
    <main role="main" class="container">
        @yield('container')
    </main>
@endsection
