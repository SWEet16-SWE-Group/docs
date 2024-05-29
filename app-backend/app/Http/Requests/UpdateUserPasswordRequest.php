<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserPasswordRequest extends FormRequest
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
            'id' => 'required|exists:users,id',
            'password' => [
                'required',
                'confirmed',
                //Password::min(8)
                //    ->letters()
                //    ->numbers()

                // decommentare se si vuole applicare questi parametri alla password
            ]
        ];
    }
}
