<?php

namespace App\Http\Requests\ActividadEconomica;

class ActualizarActividadRequest extends ActividadRequest
{
    /**
     * Setter de descripción
     */
    private function setDescripcion()
    {
        // Regla unique: ignora la actividad económica
        // que actualmente posee esta descripción
        $this->reglas['descripcion'][5] .= ",{$this->actividadEconomica->id}";
    }
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setDescripcion();
        return $this->reglas;
    }
}
