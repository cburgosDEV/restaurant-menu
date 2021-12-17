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
                'name' => 'required|max:100',
                'description' => 'required|max:1000',
                'price' => 'required',
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
        ];

        return $messagesES;
    }
}
