<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class StoreRestaurant extends FormRequest
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
                'description' => 'max:1000',
            ];
        }
    }

    public function messages()
    {
        $messagesES = [
            'name.required' => '*Este campo es obligatorio.',
            'name.max' => '*Este campo no debe exceder los :max caracteres.',
            'description.max' => '*Este campo no debe exceder los :max caracteres.',
        ];

        return $messagesES;
    }
}
