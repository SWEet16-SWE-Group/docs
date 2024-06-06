<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrenotazioneRequest extends FormRequest
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
            'ristoratore' => 'required|exists:ristoratori,id',
            'orario' => 'required|date_format:Y-m-d',
            'numero_inviti'=> 'required|integer',
            'divisioni_conto'=> 'in:NULL,Equo,Proporzionale',
        ];
    }
}
