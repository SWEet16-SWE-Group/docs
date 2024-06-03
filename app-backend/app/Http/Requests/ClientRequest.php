<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'clientData' => 'required',
            'clientData.nome' => 'required|string|max:255|unique:clients,nome',
            'clientData.account_id' => 'required|exists:users,id',
        
        ];
    }

    public function messages()
{
    return [
        'clientData.nome.required' => 'Inserisci il nome!',
        'clientData.nome.unique' => 'Profilo con tale nome già esistente!',
        'clientData.account_id.exists' => 'Profilo non collegato ad un account esistente!',
    ];
}
}
