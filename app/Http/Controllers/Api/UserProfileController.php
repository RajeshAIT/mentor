<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends Controller
{
    public function ProfileResponse(Request $request)
   {
    $validator = Validator::make($request->all(), [
        'id' => 'required',
        'photo' => 'required',
        'title' => 'required',
        'about' => 'required',
        'experience' => 'required',
        'location' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['status' => false, 'message' => implode(",",$validator->errors()->all())], 400);
    }
        
        $file = $request->file('photo');
        $input['photo'] = time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = storage_path('public/images/');
        $file->move($destinationPath, $input['photo']);
        
        $post = UserProfile::updateOrCreate([
            'user_id' => auth()->user()->id
        ], [
            'title' => $request->title,
            'photo' => $input['photo'],
            'about' => $request->about,
            'location' => $request->location,
            'experience' => $request->experience,
        ]);

        $photo = url('/api/user/profile/images/' . auth()->user()->id);

        $userName = User::where('id', '=', auth()->user()->id)->select('firstname','lastname')->first();
            $fname= $userName->firstname;
            $lname= $userName->lastname;
            $UserName=$fname . ' ' . $lname;
        
        $responseData['status']=true;
        $responseData['message']='Updated Successfully';
        $UserProfileCollection = array(
            "photo" => $photo, 
            "user_name" => $UserName, 
            "title" => $post['title'], 
            "location" => $post['location'], 
            "experience" => $post['experience'], 
            "about" => $post['about']
        );
        $responseData['data']=$UserProfileCollection;
        return response()->json($responseData);
        
   }
}
