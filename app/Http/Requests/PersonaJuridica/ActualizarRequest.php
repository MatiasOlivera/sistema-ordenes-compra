<?php

namespace App\Http\Requests\PersonaJuridica;

use App\PersonaJuridica;
use Illuminate\Http\Request;

class ActualizarRequest extends PersonaJuridicaRequest
{
    /**
     * Setter de CUIT
     */
    
    private function setCuit()
    {
        // Regla unique: ignora a la persona jurídica que
        // actualmente posee este CUIT
        $this->reglas['cuit'][4] .= ",{$this->personaJuridica->id}";
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
        $this->setCuit();
        return $this->reglas;
    }
}
