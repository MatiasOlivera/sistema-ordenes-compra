<?php

namespace App\Http\Controllers;

use App\PersonaFisica;
use App\Persona;
use Illuminate\Http\Request;
use App\Http\Requests\PersonaFisicaRequest;
use Illuminate\Support\Facades\DB;

class PersonaFisicaController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
    public function view()
    {
        return view('fisicas');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
              $listadoPersonasFisicas = PersonaFisica::all();

              if ($listadoPersonasFisicas->isNotEmpty()) {
                  $listado = $listadoPersonasFisicas;
                  $codigoEstado = 200; // Todo OK
              } else {
                  $listado = $listadoPersonasFisicas;
                  $codigoEstado = 204; //Arreglo vacio
              }
        } catch (\Exception $e) {
              $listado = [];
              $codigoEstado = 409;
        }

        return response()->json($listado, $codigoEstado);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PersonaFisicaRequest $request)
    {
          try {
              DB::beginTransaction();

                $Persona = new Persona;
                $Persona -> save();

                $personaFisica = new PersonaFisica;
                $personaFisica -> persona() -> associate($Persona);
                $personaFisica -> nombres = $request-> nombres;
                $personaFisica -> apellidos = $request-> apellidos;
                $personaFisica -> documento = $request-> documento;
                $personaFisica -> fecha_nacimiento = $request-> fecha_nacimiento;
                $personaFisica -> sexo = $request-> sexo;
                $personaFisica ->save();

              DB::commit();
                $transaccion = true;
          } catch (\Exception $e) {
              DB::rollBack();
                $transaccion = false;
          }

          if ($transaccion) {
                $respuesta['alerta'] = ['mensaje' => 'La Persona se ha guardado con exito',
                                         'titulo' => 'Exito',
                                          'clase' => 'alert-success'];
                $codigoEstado = 201;
          } else {
                $respuesta['alerta'] = ['mensaje' => 'Ha ocurrido un error mientras se intentaba guardar, vuelva a intentar mas tarde',
                                         'titulo' => 'Fallo',
                                          'clase' => 'alert-danger'];
                $codigoEstado = 400;
          }


      return response()->json($respuesta, $codigoEstado);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PersonaFisica  $personaFisica
     * @return \Illuminate\Http\Response
     */

    public function show(PersonaFisica $personaFisica)
    {
        return response()->json($personaFisica);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PersonaFisica  $personaFisica
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PersonaFisica  $personaFisica
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request,  PersonaFisica $personaFisica)
    {
        try {
            $personaFisica = PersonaFisica::find($request -> id);
            $personaFisica -> nombres = $request -> nombres;
            $personaFisica -> apellidos = $request -> apellidos;
            $personaFisica -> documento = $request -> documento;
            $personaFisica -> fecha_nacimiento = $request -> fecha_nacimiento;
            $personaFisica -> sexo = $request -> sexo;
            $personaFisica->save();

            $update = true;
        } catch (\Exception $e) {
            $update = false;
        }

        if ($update) {
              $respuesta['alerta'] = ['mensaje' => 'La Persona se ha modificado con exito',
                             'titulo' => 'Exito',
                              'clase' => 'alert-success'];
              $codigoEstado = 201;
        } else {
              $respuesta['alerta'] = ['mensaje' => 'Ha ocurrido un error mientras se intentaba guardar los cambios, vuelva a intentar mas tarde',
                             'titulo' => 'Fallo',
                              'clase' => 'alert-danger'];
              $codigoEstado = 400;
        }

        return response()->json($respuesta, $codigoEstado);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PersonaFisica  $personaFisica
     * @return \Illuminate\Http\Response
     */
    public function destroy(PersonaFisica $personaFisica)
    {
        $personaFisica = PersonaFisica::find($personaFisica -> id);
    }
}
