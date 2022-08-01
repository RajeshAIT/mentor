<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

class PostRequest extends FormRequest
{
    // Determine if the user is authorized to make this request.

    public function authorize()
    {
        return true;
    }

    // Get the validation rules that apply to the request.
     
    public function rules()
    {
        if(request()->post_type_id==1)
        {
            return [
               'title' => 'required|max:255',
               'comment' => 'required|max:255',
               'post_type_id' => 'required',
               'media_url' => 'required',
        ];
       }
       if(request()->post_type_id==2)
        {
            return [
               'title' => 'required|max:255',
               'comment' => 'required|max:255',
               'post_type_id' => 'required',
               'qualification' => 'required',
               'experience' => 'required',
               'salary_min' => 'required',
               'salary_max' => 'required',
           ];
       }
    }
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
            $response = new JsonResponse(['status' => 'false', 
                'message' => implode(",",$validator->errors()->all())], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
   }
}