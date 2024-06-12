<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterUserRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required'
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'succes' => false,
            'status_code' => 422,
            'error' =>true,
            'message' => 'Erreur de validaation',
            'errorsList' => $validator->errors()
        ]));
    }

    public function messages()
    {
        return [
            'name.required' => 'Un nom doit etre fourni',
            'email.required' => 'Une adresse email doit etre fourni',
            'email.unique' => 'Cette adresse email existe deja',
            'password.required' => 'Le mot de passe est requis'
            //'description.required' => 'La description est obligatoire'
        ];
    }
}
