<?php

namespace App\Http\Controllers;

use App\ActividadEconomica;
use Illuminate\Http\Request;

class ActividadEconomicaController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ActividadEconomica::all();
    }
}
