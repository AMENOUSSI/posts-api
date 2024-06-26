<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LogUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'succes' => false,
            'error' =>true,
            'message' => 'Erreur de validaation',
            'errorsList' => $validator->errors()
        ]));
    }

    public function messages()
    {
        return [
            'email.required' =>'Email non fourni',
            'email.eamil' => 'Adresse non valide',
            'email.exists' =>'Cette adresse n\'existe pas',
            'password.required' => 'Mot de passe non fourni',
            //'description.required' => 'La description est obligatoire'
        ];
    }
}
