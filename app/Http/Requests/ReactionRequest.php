<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

class ReactionRequest extends FormRequest
{
    // Determine if the user is authorized to make this request.

    public function authorize()
    {
        return true;
    }

    // Get the validation rules that apply to the request.

    public function rules()
    {
        return [
            'answer_id' => 'required'
        ];
    }
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
            $response = new JsonResponse(['status' => 'false', 
                'message' => implode(",",$validator->errors()->all())], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
   }
}