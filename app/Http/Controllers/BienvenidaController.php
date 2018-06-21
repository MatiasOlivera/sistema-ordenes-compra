<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BienvenidaController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mostrar la página de bienvenida
     *
     * @return \Illuminate\Http\Response
     */

    public function __invoke()
    {
        return view('bienvenida');
    }
}
