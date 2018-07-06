<?php

namespace App\Http\Requests\TipoOrganizacion;

use App\TipoOrganizacion;

class ActualizarRequest extends TipoOrganizacionRequest
{
    /**
     * Setter de descripción
     */
    
    private function setDescripcion()
    {
        // Regla unique: ignora al tipo de organización que
        // actualmente posee esta descripción
        $this->reglas['descripcion'][5] .= ",{$this->tipoOrganizacion->id}";
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
