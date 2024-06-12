<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class CreatePostRequest extends FormRequest
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
            'titre' => ['required'],
            //'description' => ['required'],
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
            'titre.required' => 'Un titre doit etre fourni',
            //'description.required' => 'La description est obligatoire'
        ];
    }
}
