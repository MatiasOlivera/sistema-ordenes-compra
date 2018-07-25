<?php

namespace App\Http\Requests\Rubro;

use Illuminate\Foundation\Http\FormRequest;

abstract class RubroRequest extends FormRequest
{
    protected $reglas = [
        'descripcion' => [
            'bail',
            'required',
            'string',
            'min:3',
            'max:100',
            'unique:rubros,descripcion'
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
