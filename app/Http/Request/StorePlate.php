<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class StorePlate extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if($this->method() == 'POST')
        {
            return [
                'name' => 'required|max:500',
                'description' => 'max:1000',
                'price' => 'required|gt:0',
            ];
        }
    }

    public function messages()
    {
        $messagesES = [
            'name.required' => '*Este campo es obligatorio.',
            'name.max' => '*Este campo no debe exceder los :max caracteres.',
            'description.required' => '*Este campo es obligatorio.',
            'description.max' => '*Este campo no debe exceder los :max caracteres.',
            'price.required' => '*Este campo es obligatorio.',
            'price.gt' => '*Ingresar un precio mayor a 0.',
        ];

        return $messagesES;
    }
}
