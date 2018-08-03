<?php

namespace App\Http\Requests\ActividadEconomica;

use Illuminate\Foundation\Http\FormRequest;

abstract class ActividadRequest extends FormRequest
{
    protected $reglas = [
        'descripcion' => [
            'bail',
            'required',
            'string',
            'min:3',
            'max:100',
            'unique:actividades_economicas,descripcion'
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
