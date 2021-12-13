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
                'address' => 'max:100',
                'phone1' => 'max:20',
                'phone2' => 'max:20',
                'email' => 'max:100',
                'web' => 'max:100',
            ];
        }
    }

    public function messages()
    {
        $messagesES = [
            'name.required' => '*Este campo es obligatorio.',
            'name.max' => '*Este campo no debe exceder los :max caracteres.',
            'description.max' => '*Este campo no debe exceder los :max caracteres.',
            'phone1.max' => '*Este campo no debe exceder los :max caracteres.',
            'phone2.max' => '*Este campo no debe exceder los :max caracteres.',
            'email.max' => '*Este campo no debe exceder los :max caracteres.',
            'web.max' => '*Este campo no debe exceder los :max caracteres.',
        ];

        return $messagesES;
    }
}
