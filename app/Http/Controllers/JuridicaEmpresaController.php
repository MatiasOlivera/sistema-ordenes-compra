<?php

namespace App\Http\Controllers;

use App\PersonaJuridica;
use App\Empresa;
use Illuminate\Http\Request;

class JuridicaEmpresaController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \App\PersonaJuridica  $personaJuridica
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function store(PersonaJuridica $personaJuridica, Empresa $empresa)
    {
        $denominacionJuridica = $personaJuridica->denominacion;
        $nombreEmpresa = $empresa->nombre_fantasia;
        
        $personaJuridica->empresas()->attach($empresa->id);
        $asociada = $personaJuridica->save();
        
        if ($asociada) {
            $respuesta = ['mensaje' => "{$denominacionJuridica} ha sido registrada como dueña de {$nombreEmpresa}"];
            $codigoEstado = 201;
        } else {
            $respuesta = [
                'mensaje' => "Hubo un problema al intentar registrar a {$denominacionJuridica} como dueña de {$nombreEmpresa}"
            ];
            $codigoEstado = 400;
        }
        
        return response()->json($respuesta, $codigoEstado);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PersonaJuridica  $personaJuridica
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function destroy(PersonaJuridica $personaJuridica, Empresa $empresa)
    {
        $denominacionJuridica = $personaJuridica->denominacion;
        $nombreEmpresa = $empresa->nombre_fantasia;
        
        $personaJuridica->empresas()->detach($empresa->id);
        $asociada = $personaJuridica->save();
        
        if ($asociada) {
            $respuesta = ['mensaje' => "{$denominacionJuridica} ha sido removida como dueña de {$nombreEmpresa}"];
            $codigoEstado = 200;
        } else {
            $respuesta = [
                'mensaje' => "Hubo un problema al intentar remover a {$denominacionJuridica} como dueña de {$nombreEmpresa}"
            ];
            $codigoEstado = 400;
        }
        
        return response()->json($respuesta, $codigoEstado);
    }
}
