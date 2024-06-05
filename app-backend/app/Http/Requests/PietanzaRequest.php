<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PietanzaRequest extends FormRequest
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
            'ristoratore' => 'required|exists:ristoratore,id',
            'nome' => 'required|string|max:255',
        ];
    }
}