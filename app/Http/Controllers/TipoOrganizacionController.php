<?php

namespace App\Http\Controllers;

use App\TipoOrganizacion;
use App\Http\Requests\TipoOrganizacion\ActualizarRequest;
use App\Http\Requests\TipoOrganizacion\GuardarRequest;
use App\VueTables;
use Illuminate\Http\Request;

class TipoOrganizacionController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $vuetable = new VueTables();
        $modelo   = new TipoOrganizacion();

        $respuesta = $vuetable->obtener(
            $request,
            $modelo
        );

        return $respuesta;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuardarRequest $request)
    {
        $descripcion = $request->input('descripcion');
        $input = $request->all();
        
        $tipo = new TipoOrganizacion();
        $tipo->fill($input);
        $guardado = $tipo->save();
        
        if ($guardado) {
            $respuesta = ['mensaje' => "{$descripcion} ha sido creado"];
            $codigoEstado = 201;
        } else {
            $respuesta = ['mensaje' => "Hubo un problema al intentar guardar a ${$descripcion}"];
            $codigoEstado = 400;
        }
        
        return response()->json($respuesta, $codigoEstado);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TipoOrganizacion  $tipoOrganizacion
     * @return \Illuminate\Http\Response
     */
    public function show(TipoOrganizacion $tipoOrganizacion)
    {
        return $tipoOrganizacion;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TipoOrganizacion  $tipoOrganizacion
     * @return \Illuminate\Http\Response
     */
    public function update(ActualizarRequest $request, TipoOrganizacion $tipoOrganizacion)
    {
        $descripcion = $tipoOrganizacion->descripcion;
        $input = $request->all();
        
        $tipoOrganizacion->fill($input);
        $actualizado = $tipoOrganizacion->save();
        
        if ($actualizado) {
            $respuesta = ['mensaje' => "{$descripcion} ha sido actualizado"];
            $codigoEstado = 200;
        } else {
            $respuesta = ['mensaje' => "Hubo un problema al intentar actualizar a {$descripcion}"];
            $codigoEstado = 400;
        }

        return response()->json($respuesta, $codigoEstado);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TipoOrganizacion  $tipoOrganizacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoOrganizacion $tipoOrganizacion)
    {
        $descripcion = $tipoOrganizacion->descripcion;
        $eliminado = $tipoOrganizacion->delete();
        
        if ($eliminado) {
            $respuesta = ['mensaje' => "{$descripcion} ha sido eliminado"];
            $codigoEstado = 200;
        } else {
            $respuesta = ['mensaje' => "Hubo un problema al intentar eliminar $descripcion"];
            $codigoEstado = 400;
        }

        return response()->json($respuesta, $codigoEstado);
    }
}