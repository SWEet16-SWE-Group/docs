<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DettagliOrdinazioneRequest extends FormRequest
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
            'ordinazione' => 'required|integer|exists:ordinazioni,id',
            'ingrediente' => 'required|integer|exists:ingredienti,id',
            'dettaglio' => 'required|in:-,+',
        ];
    }
}
