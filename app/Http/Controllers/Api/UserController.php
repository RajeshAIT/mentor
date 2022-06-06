<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = validator::make($request->all(), [
            'firstname' => 'required|min:3',
            'lastname' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'phonenumber' => 'required|min:10|numeric',
            'fcm' => '',
            'userrole_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()], 400);
        }

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phonenumber' => $request->phonenumber,
            'userrole_id' => $request->userrole_id
        ]);

        $return['firstname'] = $request->firstname;
        $return['lastname'] = $request->lastname;
        $return['email'] = $request->email;
        $return['password'] = $request->password;
        $return['phonenumber'] = $request->phonenumber;
        $return['fcm'] = $request->fcm;
        $return['userrole_id'] = $request->userrole_id;


        return response()->json(['status' => true, 'data' => $return], 200);
    }

    /**
     * Login Req
     */
    public function login(Request $request)
    {
        $validator = validator::make($request->all(), [

            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()], 400);
        }


        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('mentor')->accessToken;
            return response()->json(['status' => true, 'data' => $token], 200);
        } else {
            return response()->json(['status' => false, 'error' => 'Unauthorised'], 401);
        }
    }

    // public function userInfo()
    // {

    //     $user = auth()->user();

    //     return response()->json(['user' => $user], 200);
    // }
    public function createpassword(Request $request)
    {
        $validator = validator::make($request->all(), [
            'password' => 'required|min8',
            'confirmpassword' => 'required|samepassword'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()], 400);
        }
    }
}
