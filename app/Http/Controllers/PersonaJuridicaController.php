<?php

namespace App\Http\Controllers;

use App\Persona;
use App\PersonaJuridica;
use App\Http\Requests\PersonaJuridica\GuardarRequest;
use App\Http\Requests\PersonaJuridica\ActualizarRequest;
use App\VueTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonaJuridicaController extends Controller
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

        $modelo   = new PersonaJuridica();
        $modelos  = ['tipoOrganizacion'];

        $respuesta = $vuetable->obtener(
            $request,
            $modelo,
            $modelos
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
        $denominacion = $request->input('denominacion');
        $input = $request->all();
        
        try {
            DB::beginTransaction();

            $persona = new Persona();
            $persona->save();
                        
            $personaJuridica = new PersonaJuridica();
            $personaJuridica->fill($input);
            $personaJuridica->persona()->associate($persona);
            $personaJuridica->save();

            DB::commit();
            $transaccion = true;
        } catch (\Exception $e) {
            DB::rollBack();
            $transaccion = false;
        }

        if ($transaccion) {
            $respuesta = ['mensaje' => "{$denominacion} ha sido creada"];
            $codigoEstado = 201;
        } else {
            $respuesta = ['mensaje' => "Hubo un problema al intentar guardar a {$denominacion}"];
            $codigoEstado = 400;
        }

        return response()->json($respuesta, $codigoEstado);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PersonaJuridica  $personaJuridica
     * @return \Illuminate\Http\Response
     */
    public function show(PersonaJuridica $personaJuridica)
    {
        return $personaJuridica;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PersonaJuridica  $personaJuridica
     * @return \Illuminate\Http\Response
     */
    public function update(ActualizarRequest $request, PersonaJuridica $personaJuridica)
    {
        $denominacion = $personaJuridica->denominacion;
        $input = $request->all();
        
        $personaJuridica->fill($input);
        $actualizada = $personaJuridica->save();

        if ($actualizada) {
            $respuesta = ['mensaje' => "{$denominacion} ha sido actualizada"];
            $codigoEstado = 200;
        } else {
            $respuesta = ['mensaje' => "Hubo un problema al intentar actualizar a {$denominacion}"];
            $codigoEstado = 400;
        }

        return response()->json($respuesta, $codigoEstado);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PersonaJuridica  $personaJuridica
     * @return \Illuminate\Http\Response
     */
    public function destroy(PersonaJuridica $personaJuridica)
    {
        $denominacion = $personaJuridica->denominacion;
        $eliminada = $personaJuridica->delete();
        
        if ($eliminada) {
            $respuesta = ['mensaje' => "{$denominacion} ha sido eliminada"];
            $codigoEstado = 200;
        } else {
            $respuesta = ['mensaje' => "Hubo un problema al intentar eliminar a {$denominacion}"];
            $codigoEstado = 400;
        }

        return response()->json($respuesta, $codigoEstado);
    }
}
