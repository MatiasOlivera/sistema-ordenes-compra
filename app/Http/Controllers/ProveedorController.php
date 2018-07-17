<?php

namespace App\Http\Controllers;

use App\Proveedor;
use App\Empresa;
use App\VueTables;
use Illuminate\Http\Request;

class ProveedorController extends Controller
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
    public function index(Request $request)
    {
        $vuetable       = new VueTables();
        $modelo         = new Empresa();
        $campos         = ['nombre_fantasia'];
        $modelos        = [];
        $existeRelacion = 'proveedor';
        
        $respuesta = $vuetable->obtener(
            $request,
            $modelo,
            $campos,
            $modelos,
            $existeRelacion
        );
        
        return $respuesta;
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function store(Empresa $empresa)
    {
        $nombre = $empresa->nombre_fantasia;
        $guardado = false;
        
        $proveedorEliminado = Proveedor::onlyTrashed()->find($empresa->id);
        
        if ($proveedorEliminado) {
            $guardado = $proveedorEliminado->restore();
        } else {
            $proveedor = new Proveedor();
            $proveedor->empresa()->associate($empresa);
            $guardado = $proveedor->save();
        }
        
        if ($guardado) {
            $respuesta = ['mensaje' => "{$nombre} ha sido dada de alta como proveedor"];
            $codigoEstado = 201;
        } else {
            $respuesta = ['mensaje' => "Hubo un problema al intentar dar de alta como proveedor a ${$nombre}"];
            $codigoEstado = 400;
        }
        
        return response()->json($respuesta, $codigoEstado);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empresa $empresa)
    {
        $nombre =  $empresa->nombre_fantasia;
        
        $proveedor = Proveedor::findOrFail($empresa->id);
        $eliminado = $proveedor->delete();
        
        if ($eliminado) {
            $respuesta = ['mensaje' => "{$nombre} ha sido dada de baja como proveedor"];
            $codigoEstado = 200;
        } else {
            $respuesta = ['mensaje' => "Hubo un problema al intentar dar de baja como proveedor a $nombre"];
            $codigoEstado = 400;
        }

        return response()->json($respuesta, $codigoEstado);
    }
}
