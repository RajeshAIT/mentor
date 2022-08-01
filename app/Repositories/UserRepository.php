<?php

namespace App\Repositories;

use Mail;
use App\Models\User;
use App\Models\Answer;
use App\Models\Follow;
use App\Models\Company;
use App\Models\Question;
use App\Models\RankingList;
use App\Models\UserProfile;
use Illuminate\Support\Str;
use App\Models\CompanyVerify;
use App\Mail\SendResetPassword;
use App\Interfaces\UserInterface;
use App\Http\Requests\UserRequest;
use App\Http\Requests\FollowRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserRepository implements UserInterface
{
    public function register($request)
    {
        $validator = validator::make($request->all(), [
            'firstname' => 'required|min:3',
            'lastname' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'phonenumber' => 'nullable|min:10|numeric',
            'userrole_id' => 'required',
            'disclaimer' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => implode(",",$validator->errors()->all())], 400);
        }

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phonenumber' => $request->phonenumber,
            'userrole_id' => $request->userrole_id,
            'disclaimer' => $request->disclaimer
        ]);

        if($user)
        {
            $points = RankingList::create([
                'user_id' => $user->id,
                'points' => 10,
                'reasons' => "Registered",
            ]);
        }

        return response()->json(['status' => true, 'message' => 'Registered Successfully'], 200);
    }

    public function login($request)
    {
        $validator = validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
            'fcm' => 'required',
        ]);
        if ($validator->fails())
        {
            return response()->json(['status' => false, 'message' => implode(",",$validator->errors()->all())], 400);
        }

        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('mentor')->accessToken;
            $user_id = auth()->user()->id;
            $user_firstname = auth()->user()->firstname;
            $user_lastname = auth()->user()->lastname;
            $user_name = $user_firstname . ' ' . $user_lastname;
            $userrole_id = auth()->user()->userrole_id;
            $user_profile=url('/api/user/profile/images/'.$user_id);

           $fcm = User::where('id', '=',$user_id)->update([
            'fcm' => $request->fcm
           ]);

            $responseData['status']=true;
            $responseData['message']='Logged in Successfully';
            $userCollection = array("id" => $user_id, "name" => $user_name, "user_profile" => $user_profile, "userrole_id" => $userrole_id, "token" => $token, "fcm" => $request->fcm );
            $responseData['data']=$userCollection;
            return response()->json($responseData, 200);
        } else {
            return response()->json(['status' => false, 'message' => 'User does not exist please sign up'], 401);
        }
    }

    public function createpassword($request)
    {
        $validator = validator::make($request->all(), [
            'password' => 'required|min8',
            'confirmpassword' => 'required|samepassword'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()], 400);
        }
    }

    public function ProfileResponse($request)
    {
     if(auth()->user()->id)
     {
       $validator = Validator::make($request->all(), [
        'id' => 'nullable',
        'photo' => 'nullable',
        'title' => 'nullable',
        'about' => 'nullable',
        'experience' => 'nullable',
        'location' => 'nullable',
       ]);
     } else {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'photo' => 'required',
            'title' => 'required',
            'about' => 'required',
            'experience' => 'required',
            'location' => 'required',
           ]);
     }

     if ($validator->fails()) {
        return response()->json(['status' => false, 'message' => implode(",",$validator->errors()->all())], 400);
      }

       if($request->photo)
       {
        $file = $request->file('photo');
        $input['photo'] = time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = storage_path('public/images/');
        $file->move($destinationPath, $input['photo']);
       } else
       {
          $input['photo']=null;
       }

        $post = UserProfile::updateOrCreate([
            'user_id' => auth()->user()->id
        ], [
            'photo' => $input['photo'],
            'title' => $request->title,
            'about' => $request->about,
            'experience' => $request->experience,
            'location' => $request->location,
        ]);

        if($request->photo){
            $photo = url('/api/user/profile/images/' . auth()->user()->id);
        } else {
            $photo = null;
        }

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

    public function show($id)
    {
       $userCollection=UserProfile::where('user_id',$id)->select('title','photo','about','location','experience')->first();
       if($userCollection)
       {
        $userName = User::where('id', '=', $id)->select('firstname','lastname','userrole_id','email')->first();
            $fname= $userName->firstname;
            $lname= $userName->lastname;
            $UserName=$fname . ' ' . $lname;

        $verifyCompany = CompanyVerify::where('user_id',$id)->select('verify')->first();
        if($verifyCompany)
        {
            if($verifyCompany->verify == '0')
            {
                $verify = 0;
            } elseif($verifyCompany->verify == '1')
            {
                $verify = 1;
            } elseif($verifyCompany->verify == '2')
            {
                $verify = 2;
                $verifyCompanyID = Company::where('user_id',$id)->first();
                if($verifyCompanyID)
               {
                  $verify = 3;
               }
            }
        } else {
            $verify = null;
        }

       $profileDetails['id']=$id;
       $photo=url('/api/user/profile/images/' . $id);
       $profileDetails['role']=$userName->userrole_id;
       $profileDetails['email']=$userName->email;
       $profileDetails['photo']=isset($userCollection)?$photo:null;
       $profileDetails['user_name']=$UserName;
       $profileDetails['title']=isset($userCollection->title)?$userCollection->title:null;
       $profileDetails['location']=isset($userCollection->location)?$userCollection->location:null;
       $profileDetails['experience']=isset($userCollection->experience)?$userCollection->experience:null;
       $profileDetails['about']=isset($userCollection->about)?$userCollection->about:null;

       if($userName->userrole_id == 2)
       {
        $answerDetails=[];
        $questions = Question::where('created_by', '=', $id)->select('id','question')->get();
        foreach($questions as $questionsAsked)
        {
            $answerdetail['question_id'] =  $questionsAsked->id;
            $answerdetail['question'] =  $questionsAsked->question;
       
            array_push($answerDetails,$answerdetail);
        }
            $profileDetails['questions_asked']=$answerDetails;
       } else if($userName->userrole_id == 1)
       {
        $answerDetails=[];
        $answers = Answer::where('answer_by', '=', $id)->select('question_id')->get();
        foreach($answers as $answeredQuestions)
        {
          $questions = Question::where('id', '=', $answeredQuestions->question_id)->select('id','question')->get();
          foreach($questions as $questionsAnswered)
          {
            $answerdetail['question_id'] =  $questionsAnswered->id;
            $answerdetail['question'] =  $questionsAnswered->question;
       
            array_push($answerDetails,$answerdetail);
          }
        }
            $profileDetails['company_verify']=$verify;
            $profileDetails['questions_answered']=$answerDetails;
       }

        $responseData['status']=true;
        $responseData['message']='Successful';
        $responseData['data']=$profileDetails;
        return response()->json($responseData);
       } else {
    
        $userName = User::where('id', '=', $id)->select('id','firstname','lastname','userrole_id','email')->first();
        if($userName)
        {
            $fname= $userName->firstname;
            $lname= $userName->lastname;
            $UserName=$fname . ' ' . $lname;

            $verifyCompany = CompanyVerify::where('user_id',$id)->select('verify')->first();
            if($verifyCompany)
            {
            if($verifyCompany->verify == '0')
            {
                $verify = 0;
            } elseif($verifyCompany->verify == '1')
            {
                $verify = 1;
            } elseif($verifyCompany->verify == '2')
            {
                $verify = 2;
                $verifyCompanyID = Company::where('user_id',$id)->first();
                if($verifyCompanyID)
               {
                  $verify = 3;
               }
            }
        } else {
            $verify = null;
        }
    
       $profileDetails['id']=$id;
       $photo=url('/api/user/profile/images/' . $id);
       $profileDetails['role']=$userName->userrole_id;
       $profileDetails['email']=$userName->email;
       $profileDetails['photo']=isset($userCollection)?$photo:null;
       $profileDetails['user_name']=$UserName;
       $profileDetails['title']=isset($userCollection->title)?$userCollection->title:null;
       $profileDetails['location']=isset($userCollection->location)?$userCollection->location:null;
       $profileDetails['experience']=isset($userCollection->experience)?$userCollection->experience:null;
       $profileDetails['about']=isset($userCollection->about)?$userCollection->about:null;

       if($userName->userrole_id == 2)
       {
        $answerDetails=[];
        $questions = Question::where('created_by', '=', $id)->select('id','question')->get();
        foreach($questions as $questionsAsked)
        {
            $answerdetail['question_id'] =  $questionsAsked->id;
            $answerdetail['question'] =  $questionsAsked->question;
        
            array_push($answerDetails,$answerdetail);
        }
            $profileDetails['questions_asked']=$answerDetails;
       } else if($userName->userrole_id == 1)
       {
        $answerDetails=[];
        $answers = Answer::where('answer_by', '=', $id)->select('question_id')->get();
        foreach($answers as $answeredQuestions)
        {
          $questions = Question::where('id', '=', $answeredQuestions->question_id)->select('id','question')->get();
          foreach($questions as $questionsAnswered)
          {
            $answerdetail['question_id'] =  $questionsAnswered->id;
            $answerdetail['question'] =  $questionsAnswered->question;
        
            array_push($answerDetails,$answerdetail);
          }
        }
        $profileDetails['company_verify']=$verify;
        $profileDetails['questions_answered']=$answerDetails;
       }

        $responseData['status']=true;
        $responseData['message']='Success';
        $responseData['data']=$profileDetails;
        return response()->json($responseData);
     }else{
        $responseData['status']=false;
        $responseData['message']='Invalid ID';
        return response()->json($responseData);
       }
     }
    }

    public function changepassword($request)
   {
    $input = $request->all();
    $userid = Auth::user()->id;
    $rules = array(
        'old_password' => 'required',
        'new_password' => 'required|min:6',
        'confirm_password' => 'required|same:new_password',
    );
    $validator = Validator::make($input, $rules);
    if ($validator->fails()) {
        $arr = array("status" => false, "message" => $validator->errors()->first());
    } else {
        try {
            if ((Hash::check(request('old_password'), Auth::user()->password)) == false) {
                $arr = array("status" => false, "message" => "Check your old password.");
            } else if ((Hash::check(request('new_password'), Auth::user()->password)) == true) {
                $arr = array("status" => false, "message" => "Please enter a password which is not similar then current password.");
            } else {
                User::where('id', $userid)->update(['password' => Hash::make($input['new_password'])]);
                $arr = array("status" => true, "message" => "Password updated successfully.");
            }
        } catch (\Exception $ex) {
            if (isset($ex->errorInfo[2]))
            {
                $msg = $ex->errorInfo[2];
            } else {
                $msg = $ex->getMessage();
            }
            $arr = array("status" => false, "message" => $msg);
        }
    }
    return \Response::json($arr);
   }

    public function logout()
    {
       auth()->user()->token()->revoke();
       return response()->json(['status' => 'true', 'message' => 'Successfully logged out'], 200);
    }

    public function dashboard()
    {
        return view('pages.dashboard');
    }

    public function create()
    {
        return view('pages.create_user');
    }

    public function storeUser(UserRequest $request)
    {
       $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request['password']),
            'phonenumber' => $request->phonenumber,
            'userrole_id' => $request->userrole_id,
        ]);

        $file = $request->file('photo');
        $input['photo'] = time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = storage_path('public/images/');
        $file->move($destinationPath, $input['photo']);

        UserProfile::create([
            'user_id' => $user->id,
            'photo' => $input['photo'],
            'title' => $request->title,
            'about' => $request->about,
            'experience' => $request->experience,
            'location' => $request->location,
        ]);
        return back()->with('message', 'User has been Created');
    }
    
    public function getMentor()
    {
        $user = User::where('userrole_id','=',"1")->leftjoin('userprofile','userprofile.user_id','users.id')
          ->select('users.*','userprofile.photo','userprofile.title','userprofile.about',
          'userprofile.experience','userprofile.location')
         ->get();
        return view('pages.mentor_report', compact('user'));
    }

    public function getMentee()
    {
        $user = User::where('userrole_id','=', "2")->leftjoin('userprofile','userprofile.user_id','users.id')
          ->select('users.*','userprofile.photo','userprofile.title','userprofile.about',
          'userprofile.experience','userprofile.location')
         ->get();
        return view('pages.mentee_report', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id); 
        $userprofile = User::leftjoin('userprofile','userprofile.user_id','users.id')
        ->select('users.*','userprofile.photo','userprofile.title','userprofile.about',
        'userprofile.experience','userprofile.location')
        ->where('users.id',$id)
       ->get();

        return view('pages.user_edit', compact('user','userprofile'));
    }

    public function requestUser(UserRequest $request, $id)
    {
        User::where('id', $id)->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request['password']),
            'phonenumber' => $request->phonenumber,
            'userrole_id' => $request->userrole_id,
        ]);

        $file = $request->file('photo');
        $input['photo'] = time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = storage_path('public/images/');
        $file->move($destinationPath, $input['photo']);

        UserProfile::where('user_id', $id)->update([
            'user_id' => $id,
            'photo' => $input['photo'],
            'title' => $request->title,
            'about' => $request->about,
            'experience' => $request->experience,
            'location' => $request->location,
        ]);

        return redirect()->route('mentor_report')->with('message', 'User has been updated');
    }

    public function deleteUser($id)
    {
        User::where('id',$id)->delete();
        UserProfile::where('user_id',$id)->delete();
        return back()->with('danger', 'User has been deleted');
    }

    public function forgotpassword($token)
    {
        $user = User::where('token','=',$token)->select('is_verified', 'email')->first();
        return view('emails.change_password', compact('user'));
    }

    public function resetpassword($request)
    {
        $validator = validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('failed', 'Failed! email is not registered.');
        }

        $token = Str::random(60);

        $user['token'] = $token;
        $user['is_verified'] = 0;
        $user->save();

        $mail_details = [
            'email' => $request->email,
            'token' => $token,
            'name' => $user->firstname. " " . $user->lastname
        ];

        Mail::to($request->email)->send(new SendResetPassword($mail_details));

        if(Mail::failures() != 0) {
            return response()->json(['status' => true, 'message' =>  "Mail sent Successfully"], 200);
        }
        return response()->json(['status' => false, 'message' =>  "Failed! Enter a valid Email"], 400);
    }
    
    public function updatepassword($request)
    {
        $validator = validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password'
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user)
        {
            $user['is_verified'] = 1;
            $user['token'] = '';
            $user['password'] = Hash::make($request->password);
            $user->save();

           // dd($user->email);
           
            return redirect()->route('login')->with('success', 'Success! password has been changed');
        }
        return redirect()->route('login')->with('failed', 'Failed! something went wrong');
    }

    public function follow(FollowRequest $request)
    {
        $follow = Follow::where([['mentor_id',$request->mentor_id],['mentee_id',Auth::user()->id],['status',1]])->pluck('id')->first();
        $followReq = Follow::where([['mentor_id',$request->mentor_id],['mentee_id',Auth::user()->id],['status',2]])->first();

        if($follow){
            $unFollow = Follow::where('id',$follow)->Update([
                'mentor_id' => $request->mentor_id,
                'mentee_id' => Auth::user()->id,
                'status' => '2'
              ]);

            $responseData['status']=false;
            $responseData['message'] = "Unfollowed Successfully";
            return response()->json($responseData);
        }else if($followReq)
        {
            $followBy = Follow::where([['mentor_id',$request->mentor_id], ['status','2']])->Update([
                'mentor_id' => $request->mentor_id,
                'mentee_id' => Auth::user()->id,
                'status' => '1'
            ]);

            $responseData['status']=true;
            $responseData['message'] = "Followed Successfully";
            $data = array(
              "mentor_id" => $followReq->mentor_id,
              "mentee_id" => $followReq->mentee_id,
              "status" => 1
            );
            $responseData['data']=$data;
        } else {
            $followedBy = Follow::create([
              'mentor_id' => $request->mentor_id,
              'mentee_id' => Auth::user()->id,
              'status' => '1'
            ]);

            $responseData['status']=true;
            $responseData['message'] = "Followed Successfully";

            $data = array(
              "mentor_id" => $followedBy['mentor_id'],
              "mentee_id" => $followedBy['mentee_id'],
              "status" => $followedBy['status']
            );
            $responseData['data']=$data;
        }
        return response()->json($responseData);
    }

    public function getfollow()
    {
        $followCollection=Follow::where([['mentee_id',Auth::user()->id],['status','1']])->select('mentor_id', 'mentee_id')->get();
        $menteeFollowDetails=[];
        if($followCollection)
        {
            foreach($followCollection as $follow)
            {
                $mentor_id = User::where('id', '=', $follow->mentor_id)->get();
                foreach($mentor_id as $mentor)
                {
                $mentorprofile = UserProfile::where('user_id', '=', $mentor->id)->first();
                $photo=url('/api/user/profile/images/' . $mentor->id);
                $profileDetails['id'] = $mentor->id;
                $profileDetails['name'] = $mentor->firstname . " " . $mentor->lastname;
                $profileDetails['photo']=isset($mentorprofile)?$photo:null;
                }
                array_push($menteeFollowDetails,$profileDetails);
            }
            $responseData['status']=true;
            $responseData['message']='Successful';
            $responseData['data']=$menteeFollowDetails;
            return response()->json($responseData);
        } else {
            $responseData['status']=false;
            $responseData['message']='Invalid ID';
            return response()->json($responseData);
        }
    }

    public function getunfollow()
    {
        $followCollection=Follow::where([['mentee_id',Auth::user()->id],['status','2']])->select('mentor_id', 'mentee_id')->get();
        $menteeFollowDetails=[];
        if($followCollection)
        {
            foreach($followCollection as $follow)
            {
                $mentor_id = User::where('id', '=', $follow->mentor_id)->get();
                foreach($mentor_id as $mentor)
                {
                $mentorprofile = UserProfile::where('user_id', '=', $mentor->id)->first();
                $photo=url('/api/user/profile/images/' . $mentor->id);
                $profileDetails['id'] = $mentor->id;
                $profileDetails['name'] = $mentor->firstname . " " . $mentor->lastname;
                $profileDetails['photo']=isset($mentorprofile)?$photo:null;
                }
                array_push($menteeFollowDetails,$profileDetails);
            }
            $responseData['status']=true;
            $responseData['message']='Successful';
            $responseData['data']=$menteeFollowDetails;
            return response()->json($responseData);
        } else {
            $responseData['status']=false;
            $responseData['message']='Invalid ID';
            return response()->json($responseData);
        }
    }
}