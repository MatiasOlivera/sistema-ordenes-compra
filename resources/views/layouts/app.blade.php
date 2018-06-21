@extends('layouts.boilerplate')

@section('body')
    <!-- Menu -->
    <div class="container">
        <nav class="navbar navbar-expand-md navbar-light bg-light">

            <button class="navbar-toggler navbar-toggler-right" type="button"
            data-toggle="collapse" data-target="#barraNavegacion"
            aria-controls="barraNavegacion" aria-expanded="false"
            aria-label="Ver o ocultar la navegación">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="barraNavegacion">

                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Ordenes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Personas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Empresas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Usuarios</a>
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
        </nav>
    </div>

    <!-- Contenido principal -->
    <main role="main" class="container">
        @yield('container')
    </main>
@endsection
