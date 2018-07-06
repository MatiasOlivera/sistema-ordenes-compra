<?php

namespace App\Http\Requests\TipoOrganizacion;

use Illuminate\Foundation\Http\FormRequest;

abstract class TipoOrganizacionRequest extends FormRequest
{
    protected $reglas = [
        'descripcion' => [
            'bail',
            'required',
            'string',
            'min:3',
            'max:50',
            'unique:tipos_organizacion,descripcion'
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
    
    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
    public function messages()
    {
        return [];
    }
}
