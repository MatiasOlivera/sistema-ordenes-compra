<?php

namespace App\Http\Controllers;

use App\ActividadEconomica;
use App\Http\Requests\ActividadEconomica\GuardarActividadRequest;
use App\Http\Requests\ActividadEconomica\ActualizarActividadRequest;
use App\VueTables;
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
     * Mostrar la vista
     *
     * @return \Illuminate\Http\Response
     */

    public function view()
    {
        return view('actividades');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $empresaId = $request->query('empresaId', null);

        $vuetables = new Vuetables();

        $modelo = new ActividadEconomica();
        $campos = ["descripcion"];
        $excluir = [];

        if ($empresaId) {
            $excluir = ['empresas', 'empresa_id', $empresaId];
        }

        $respuesta = $vuetables->obtener(
            $request,
            $modelo,
            $campos,
            [],
            null,
            $excluir
        );

        return $respuesta;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuardarActividadRequest $request)
    {
        $descripcion = $request->input('descripcion');
        $input = $request->all();

        $actividadEconomica = new ActividadEconomica();
        $actividadEconomica->fill($input);
        $guardada = $actividadEconomica->save();

        if ($guardada) {
            $respuesta = ['mensaje' => "El rubro {$descripcion} ha sido creado"];
            $codigoEstado = 201;
        } else {
            $respuesta = ['mensaje' => "Hubo un problema al intentar guardar el rubro ${$descripcion}"];
            $codigoEstado = 400;
        }

        return response()->json($respuesta, $codigoEstado);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ActividadEconomica  $actividadEconomica
     * @return \Illuminate\Http\Response
     */
    public function show(ActividadEconomica $actividadEconomica)
    {
        return $actividadEconomica;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ActividadEconomica  $actividadEconomica
     * @return \Illuminate\Http\Response
     */
    public function update(ActualizarActividadRequest $request, ActividadEconomica $actividadEconomica)
    {
        $descripcion = $request->input('descripcion');
        $input = $request->all();

        $actividadEconomica->fill($input);
        $actualizada = $actividadEconomica->save();

        if ($actualizada) {
            $respuesta = ['mensaje' => "El rubro {$descripcion} ha sido actualizado"];
            $codigoEstado = 200;
        } else {
            $respuesta = ['mensaje' => "Hubo un problema al intentar actualizar el rubro {$descripcion}"];
            $codigoEstado = 400;
        }

        return response()->json($respuesta, $codigoEstado);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ActividadEconomica  $actividadEconomica
     * @return \Illuminate\Http\Response
     */
    public function destroy(ActividadEconomica $actividadEconomica)
    {
        $descripcion = $actividadEconomica->descripcion;
        $eliminada = $actividadEconomica->delete();

        if ($eliminada) {
            $respuesta = ['mensaje' => "El rubro {$descripcion} ha sido eliminado"];
            $codigoEstado = 200;
        } else {
            $respuesta = ['mensaje' => "Hubo un problema al intentar eliminar el rubro $descripcion"];
            $codigoEstado = 400;
        }

        return response()->json($respuesta, $codigoEstado);
    }

    /**
     * Restaurar la actividad económica que ha sido eliminada
     *
     * @param  \App\ActividadEconomica  $actividadEconomica
     * @return \Illuminate\Http\Response
     */
    public function restore(ActividadEconomica $actividadEconomica)
    {
        $descripcion = $actividadEconomica->descripcion;
        $restaurada = $actividadEconomica->restore();

        if ($restaurada) {
            $respuesta = ['mensaje' => "El rubro {$descripcion} ha sido dado de alta"];
            $codigoEstado = 200;
        } else {
            $respuesta = ['mensaje' => "Hubo un problema al intentar dar de alta el rubro {$descripcion}"];
            $codigoEstado = 400;
        }

        return response()->json($respuesta, $codigoEstado);
    }
}
