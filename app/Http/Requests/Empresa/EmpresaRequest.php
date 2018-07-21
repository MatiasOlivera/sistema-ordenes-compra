<?php

namespace App\Http\Requests\Empresa;

use Illuminate\Foundation\Http\FormRequest;

abstract class EmpresaRequest extends FormRequest
{
    protected $reglas = [
        'nombre_fantasia' => [
            'bail',
            'required',
            'string',
            'min:3',
            'max:100',
            'unique:empresas,nombre_fantasia'
        ],
        'es_mayorista' => [
            'bail',
            'required',
            'boolean'
        ]
    ];
    
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
        return $this->reglas;
    }
}
