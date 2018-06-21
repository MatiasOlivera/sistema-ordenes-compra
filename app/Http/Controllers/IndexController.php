<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    /**
     * Mostrar la página inicial
     *
     * @return \Illuminate\Http\Response
     */

    public function __invoke()
    {
        if (Auth::check()) {
            return redirect()->route('bienvenida');
        }
        return view('index');
    }
}
