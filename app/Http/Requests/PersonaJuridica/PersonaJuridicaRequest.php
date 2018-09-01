<?php

namespace App\Http\Requests\PersonaJuridica;

use Illuminate\Foundation\Http\FormRequest;

abstract class PersonaJuridicaRequest extends FormRequest
{
    protected $reglas = [
        'cuit' => [
            'bail',
            'required',
            'integer',
            'digits:11',
            'unique:personas_juridicas,cuit'
        ],
        'denominacion' => [
            'bail',
            'required',
            'string',
            'min:3',
            'max:100'
        ],
        'tipo_organizacion_id' => [
            'bail',
            'required',
            'integer',
            'exists:tipos_organizacion,id'
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
