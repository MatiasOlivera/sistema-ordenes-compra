<?php

namespace App;

use Illuminate\Http\Request;
use Carbon\Carbon;

class VueTables
{
    public function obtener(Request $request, $modelo, array $modelos = [], array $campos = []) {

        $busqueda   = $request->query('query', null);
        $limite     = $request->query('limit', 10);
        $pagina     = $request->query('page', 1);
        $ordenarPor = $request->query('orderBy', null);
        $ascendente = $request->query('ascending', null);
        $porColumna = $request->query('byColumn', null);

        if (!isset($modelos) && $modelos) {
            $datos = $modelo;
        } else {
            $datos = $modelo::with($modelos);
        }

        if (isset($campos) && $campos) {
            $datos->select($campos);
        }

        if (isset($busqueda) && $busqueda) {
            $datos = $porColumna == 1
            ? $this->filtrarPorColumna($datos, $busqueda)
            : $this->filtrar($datos, $busqueda, $campos);
        }

        if (isset($ordenarPor) && $ordenarPor) {
            $direccion = $ascendente == 1 ? 'ASC' : 'DESC';
            $datos->orderBy($ordenarPor, $direccion);
        }

        $resultado = $datos->paginate($limite);

        return $resultado;
    }

    protected function filtrarPorColumna($datos, $busqueda)
    {
        if (is_array($busqueda) || is_object($busqueda)) {
            
            return $datos->where(function($consulta) use ($busqueda) {
                
                foreach ($busqueda as $campo => $valor) {
                    
                    if (is_string($valor)) {
                        $consulta->where($campo, 'LIKE', "%{$valor}%");
                    } else {
                        $fechaInicio = Carbon::createFromFormat('Y-m-d',
                            $valor['start'])->startOfDay();
                        $fechaFin = Carbon::createFromFormat('Y-m-d',
                            $valor['end'])->endOfDay();

                        $consulta->whereBetween($campo, [$fechaInicio, $fechaFin]);
                    }
                
                }
            
            });
        
        }
    }

    protected function filtrar($datos, $busqueda, $campos)
    {
        return $datos->where(function($consulta) use ($busqueda, $campos) {
            
            foreach ($campos as $indice => $campo) {
                $metodo = $indice ? 'orWhere' : 'where';
                $consulta->{$metodo}($campo, 'LIKE', "%{$busqueda}%");
            }
        
        });
    }
}
