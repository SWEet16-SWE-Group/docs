<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RistoratoreRequest extends FormRequest
{
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
        return [
            'user' => 'required|exists:users,id',
            'nome' => 'required|string|max:255|unique:ristoratori,nome,',
            'indirizzo' => 'required|string|max:255|unique:ristoratori,indirizzo,',
            'telefono' => 'required|string|max:10|unique:ristoratori,telefono,',
            'capienza' => 'required|integer|min:1',
            'orario' => 'required|string|max:255',
        ];
    }
}
