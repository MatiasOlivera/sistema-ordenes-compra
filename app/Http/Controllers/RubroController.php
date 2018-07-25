<?php

namespace App\Http\Controllers;

use App\Rubro;
use App\Http\Requests\Rubro\GuardarRubroRequest;
use App\Http\Requests\Rubro\ActualizarRubroRequest;
use App\VueTables;
use Illuminate\Http\Request;

class RubroController extends Controller
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
        $vuetables = new Vuetables();
        
        $modelo = new Rubro();
        $campos = ["descripcion"];
        
        $respuesta = $vuetables->obtener(
            $request,
            $modelo,
            $campos
        );
        
        return $respuesta;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuardarRubroRequest $request)
    {
        $descripcion = $request->input('descripcion');
        $input = $request->all();
        
        $rubro = new Rubro();
        $rubro->fill($input);
        $guardado = $rubro->save();
        
        if ($guardado) {
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
     * @param  \App\Rubro  $rubro
     * @return \Illuminate\Http\Response
     */
    public function show(Rubro $rubro)
    {
        return $rubro;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rubro  $rubro
     * @return \Illuminate\Http\Response
     */
    public function update(ActualizarRubroRequest $request, Rubro $rubro)
    {
        $descripcion = $request->input('descripcion');
        $input = $request->all();
        
        $rubro->fill($input);
        $actualizado = $rubro->save();
        
        if ($actualizado) {
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
     * @param  \App\Rubro  $rubro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rubro $rubro)
    {
        $descripcion = $rubro->descripcion;
        $eliminado = $rubro->delete();
        
        if ($eliminado) {
            $respuesta = ['mensaje' => "El rubro {$descripcion} ha sido eliminado"];
            $codigoEstado = 200;
        } else {
            $respuesta = ['mensaje' => "Hubo un problema al intentar eliminar el rubro $descripcion"];
            $codigoEstado = 400;
        }

        return response()->json($respuesta, $codigoEstado);
    }
    
    /**
     * Restaurar el tipo de organización que ha sido eliminado
     *
     * @param  \App\Rubro  $rubro
     * @return \Illuminate\Http\Response
     */
    public function restore(Rubro $rubro) {
        $descripcion = $rubro->descripcion;
        $restaurado = $rubro->restore();
        
        if ($restaurado) {
            $respuesta = ['mensaje' => "El rubro {$descripcion} ha sido dado de alta"];
            $codigoEstado = 200;
        } else {
            $respuesta = ['mensaje' => "Hubo un problema al intentar dar de alta el rubro {$descripcion}"];
            $codigoEstado = 400;
        }

        return response()->json($respuesta, $codigoEstado);
    }
}
