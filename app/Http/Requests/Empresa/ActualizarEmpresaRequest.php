<?php

namespace App\Http\Requests\Empresa;

use App\Empresa;

class ActualizarEmpresaRequest extends EmpresaRequest
{
    /**
     * Setter de nombre de fantasía
     */
    private function setNombreFantasia()
    {
        // Regla unique: ignora a la empresa que
        // actualmente posee este nombre de fantasía
        $this->reglas['nombre_fantasia'][5] .= ",{$this->empresa->id}";
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
        $this->setNombreFantasia();
        return $this->reglas;
    }
}
