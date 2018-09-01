<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Http\Requests\Empresa\GuardarEmpresaRequest;
use App\Http\Requests\Empresa\ActualizarEmpresaRequest;
use App\VueTables;
use Illuminate\Http\Request;

class EmpresaController extends Controller
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
        return view('empresas');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $juridicaId = $request->query('juridicaId', null);
        
        $vuetable = new VueTables();

        $modelo  = new Empresa();
        $campos  = ['nombre_fantasia'];
        $excluir = [];
        
        if ($juridicaId) {
            $excluir = ['juridicas', 'persona_juridica_id', $juridicaId];
        }

        $respuesta = $vuetable->obtener(
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
    public function store(GuardarEmpresaRequest $request)
    {
        $nombre = $request->input('nombre_fantasia');
        $input = $request->all();
        
        $empresa = new Empresa();
        $empresa->fill($input);
        $guardado = $empresa->save();
        
        if ($guardado) {
            $respuesta = [
                'mensaje' => "{$nombre} ha sido creada",
                'data' => $empresa
            ];
            $codigoEstado = 201;
        } else {
            $respuesta = ['mensaje' => "Hubo un problema al intentar guardar a ${$nombre}"];
            $codigoEstado = 400;
        }
        
        return response()->json($respuesta, $codigoEstado);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function show(Empresa $empresa)
    {
        return Empresa::with(['juridicas', 'proveedor', 'actividades'])
            ->withTrashed()
            ->where('id', $empresa->id)
            ->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function update(ActualizarEmpresaRequest $request, Empresa $empresa)
    {
        $nombre = $empresa->nombre_fantasia;
        $input = $request->all();
        
        $empresa->fill($input);
        $actualizada = $empresa->save();
        
        if ($actualizada) {
            $respuesta = ['mensaje' => "{$nombre} ha sido actualizada"];
            $codigoEstado = 200;
        } else {
            $respuesta = ['mensaje' => "Hubo un problema al intentar actualizar a {$nombre}"];
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
        $eliminada = $empresa->delete();
        
        if ($eliminada) {
            $respuesta = ['mensaje' => "{$nombre} ha sido eliminada"];
            $codigoEstado = 200;
        } else {
            $respuesta = ['mensaje' => "Hubo un problema al intentar eliminar $nombre"];
            $codigoEstado = 400;
        }

        return response()->json($respuesta, $codigoEstado);
    }
    
    /**
     * Restaurar la empresa que ha sido eliminada
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function restore(Empresa $empresa)
    {
        $nombre =  $empresa->nombre_fantasia;
        $eliminada = $empresa->restore();
        
        if ($eliminada) {
            $respuesta = ['mensaje' => "{$nombre} ha sido dada de alta"];
            $codigoEstado = 200;
        } else {
            $respuesta = ['mensaje' => "Hubo un problema al intentar dar de alta $nombre"];
            $codigoEstado = 400;
        }

        return response()->json($respuesta, $codigoEstado);
    }
}
