<?php

namespace App\Http\Requests\Rubro;

class ActualizarRubroRequest extends RubroRequest {
    /**
     * Setter de descripción
     */
    private function setDescripcion()
    {
        // Regla unique: ignora al rubro que
        // actualmente posee esta descripción
        $this->reglas['descripcion'][5] .= ",{$this->rubro->id}";
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