<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\ActividadEconomica;
use Illuminate\Http\Request;

class EmpresaActividadController extends Controller
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
     * @param  \App\Empresa $empresa
     * @param  \App\ActividadEconomica $actividadEconomica
     * @return \Illuminate\Http\Response
     */
    public function store(Empresa $empresa, ActividadEconomica $actividadEconomica)
    {
        $nombreFantasia = $empresa->nombre_fantasia;
        $actividad = $actividadEconomica->descripcion;
        
        $existente = $empresa->actividades()
            ->where('actividad_economica_id', $actividadEconomica->id)
            ->first();
        
        if ($existente) {
            $respuesta = [
                'mensaje' => "{$nombreFantasia} ya se dedica al rubro {$actividad}"
            ];
            $codigoEstado = 400;
            return response()->json($respuesta, $codigoEstado);
        }
        
        $empresa->actividades()->attach($actividadEconomica->id);
        $asociada = $empresa->save();
        
        if ($asociada) {
            $respuesta = [
                'mensaje' => "{$nombreFantasia} ahora se dedica al rubro {$actividad}"
            ];
            $codigoEstado = 201;
        } else {
            $respuesta = [
                'mensaje' => "Hubo un problema al intentar asociar a 
                {$nombreFantasia} con el rubro {$actividad}"
            ];
            $codigoEstado = 400;
        }
        
        return response()->json($respuesta, $codigoEstado);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Empresa $empresa
     * @param  \App\ActividadEconomica $actividadEconomica
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empresa $empresa, ActividadEconomica $actividadEconomica)
    {
        $nombreFantasia = $empresa->nombre_fantasia;
        $actividad = $actividadEconomica->descripcion;
        
        $existente = $empresa->actividades()
            ->where('actividad_economica_id', $actividadEconomica->id)
            ->first();
        
        if (! $existente) {
            $respuesta = [
                'mensaje' => "{$nombreFantasia} ya no se dedica al rubro {$actividad}"
            ];
            $codigoEstado = 400;
            return response()->json($respuesta, $codigoEstado);
        }
        
        $empresa->actividades()->detach($actividadEconomica->id);
        $noAsociada = $empresa->save();
        
        if ($noAsociada) {
            $respuesta = [
                'mensaje' => "{$nombreFantasia} ha dejado de dedicarse al rubro {$actividad}"
            ];
            $codigoEstado = 200;
        } else {
            $respuesta = [
                'mensaje' => "Hubo un problema al intentar quitar la asociación 
                entre {$nombreFantasia} y el rubro {$actividad}"
            ];
            $codigoEstado = 400;
        }
        
        return response()->json($respuesta, $codigoEstado);
    }
}
