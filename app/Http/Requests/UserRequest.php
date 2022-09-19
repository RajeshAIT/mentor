<?php

namespace App\Http\Requests;
use App\Models\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules(Request $request)
    {
        
        return [
            'firstname' => 'required|min:3',
            'lastname' => 'required|min:3',
            'email' => 'required|unique:users,email,'.$request->id, 
            'password' => 'required|confirmed|min:6',
            
            'phonenumber' => 'nullable|min:10|numeric',
            'userrole_id' => 'required',

            'photo' => 'required',
            'title' => 'required',
            'about' => 'required',
            'experience' => 'required',
            'location' => 'required',
        ];
    }
}