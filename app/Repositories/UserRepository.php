<?php

namespace App\Repositories;

use Mail;
use DateTime;
use DatePeriod;
use DateInterval;
use App\Models\Post;
use App\Models\User;
use App\Models\Answer;
use App\Models\Follow;
use App\Models\Company;
use App\Models\Question;
//video report module
use App\Models\Postreport;
//video report module
//post report module
use Illuminate\Support\Js;
use App\Models\RankingList;
use App\Models\UserProfile;

//post report module
//save question module
use App\Models\UserSession;
//save question module 
use App\Models\Videoreport;
use App\Traits\FirebaseAPI;
use Illuminate\Support\Str;
// Admin Profile request
use App\Models\Notification;
use App\Models\Savedanswer; 
use App\Models\CompanyVerify;
use Illuminate\Support\Carbon;
use App\Mail\SendResetPassword;

use App\Interfaces\UserInterface;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AdminRequest;
use App\Http\Requests\FollowRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class UserRepository implements UserInterface
{

    use FirebaseAPI;

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
        'title' => 'nullable',
        'about' => 'nullable',
        'photo' => 'nullable',
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

       $temp_user_details = UserProfile::where("user_id",auth()->user()->id)->first();

        if($input['photo'] == null){
        $input['photo'] = $temp_user_details->photo;
        }

        if(!$request->title){
            $request->title = $temp_user_details->title;
        }

        if(!$request->about){
            $request->about = $temp_user_details->about;
        }

        if(!$request->location){
            $request->location = $temp_user_details->location;
        }

        if(!$request->experience){
            $request->experience = $temp_user_details->experience;
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

        if($input['photo'] != null){
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
        // dd($UserProfileCollection);
        return response()->json($responseData);
    }

    public function show($id)
    {
       $userCollection= UserProfile::where('user_id',$id)->select('title','photo','about','location','experience')->first();

            $company_id = null;
            $badge_name = null;
       
			$userName = User::where('id', '=', $id)->select('firstname','lastname','userrole_id','email','id')->first();
            $fname= $userName->firstname;
            // dd($fname);
            $lname= $userName->lastname;
            $full_name=$fname . ' ' . $lname;
            $mentor_id = $userName->id;
			

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
                  $company_id = $verifyCompanyID->id;
                  $verify = 3;
               }
            }
        } else {
            $verify = null;
        }

        //follow un follow status
        
            $follow_unfollow_status = 0;
            if($userName->userrole_id == '1'){
                $follow = Follow::where([['mentor_id',$id],['mentee_id',Auth::user()->id]])->first();
                $follow_status = @$follow->status;

                if($follow_status == "1"){
                    $follow_unfollow_status = 1;
                }
            }
        
        //follow un follow status

       $profileDetails['id']=$id;
       if(@$userCollection->photo){
        $photo=url('/api/user/profile/images/' . $id);
       }else{
        $photo = "";
       }
       $profileDetails['role']=$userName->userrole_id;
       $profileDetails['email']=$userName->email;
       $profileDetails['photo']=isset($userCollection->photo)?$photo:null;
       $profileDetails['user_name']=$full_name;
       $profileDetails['title']=isset($userCollection->title)?$userCollection->title:null;
       $profileDetails['location']=isset($userCollection->location)?$userCollection->location:null;
       $profileDetails['experience']=isset($userCollection->experience)?$userCollection->experience:null;
       $profileDetails['about']=isset($userCollection->about)?$userCollection->about:null;
       $profileDetails['follow_status'] = $follow_unfollow_status;
       $profileDetails["company_id"] = $company_id; 

       if($userName->userrole_id == 2)
       {
        $answerDetails=[];
        $question_count = 0;

        $questions = Question::where('created_by', '=', $id)->select('id','question')->orderBy("created_at","DESC")->get();
        foreach($questions as $questionsAsked)
        {
            $answerdetail['question_id'] =  $questionsAsked->id;
            $answerdetail['question'] =  $questionsAsked->question;

            $question_count++;
       
            array_push($answerDetails,$answerdetail);
        }
            //$question_count = 100;
            if($question_count >= 25 && $question_count < 50){
                $badge_name[0] = "Silver";
            }elseif($question_count >= 50 && $question_count < 100){
                $badge_name[0] = "Silver";
                $badge_name[1] = "Gold";
            }elseif($question_count >= 100){
                $badge_name[0] = "Silver";
                $badge_name[1] = "Gold";
                $badge_name[2] = "Platinum";
            }

            //save question module
            $saved_question   = Savedanswer::where([["saved_by",Auth::user()->id],["status","Save"]])->
                                leftjoin("question","question.id","savedanswers.question_id")->
                                select('savedanswers.question_id','question.question')->orderBy('savedanswers.created_at','DESC')->get();

            $profileDetails['saved_questions_list']=$saved_question;
            //save question module
            $profileDetails['questions_asked']=$answerDetails;
            $profileDetails["badge"] = $badge_name;
       } else if($userName->userrole_id == 1)
       {
        $answerDetails=[];
        $answers = Answer::where('answer_by', '=', $id)->select('question_id')->orderBy("created_at","DESC")->get();
        foreach($answers as $answeredQuestions)
        {
          $questions = Question::where('id', '=', $answeredQuestions->question_id)->select('id','question')->orderBy("created_at","DESC")->get();
          foreach($questions as $questionsAnswered)
          {
            $answerdetail['question_id'] =  $questionsAnswered->id;
            $answerdetail['question'] =  $questionsAnswered->question;
       
            array_push($answerDetails,$answerdetail);
          }
        }
            $profileDetails['company_verify']=$verify;
            $profileDetails['questions_answered']=$answerDetails;

            //save question module
            $saved_question   = Savedanswer::where([["saved_by",Auth::user()->id],["status","Save"]])->
                                leftjoin("question","question.id","savedanswers.question_id")->
                                select('savedanswers.question_id','question.question')->orderBy("savedanswers.created_at","DESC")->get();

            $profileDetails['saved_questions_list']=$saved_question;
            //save question module
        }

        $notification_list = Notification::where([["seen","0"],["user_id",Auth::user()->id]])->orderBy("created_at","DESC")->get();

        $notification_cnt = count($notification_list);

        $responseData['status']=true;
        $responseData['message']='Successful';
        $responseData["unseen_cnt"] = $notification_cnt;
        $responseData['data']=$profileDetails;
        return response()->json($responseData);
        
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
        $fcm = User::where('id', '=',Auth::user()->id)->update([
            'fcm' => ""
           ]);

       auth()->user()->token()->revoke();
       return response()->json(['status' => 'true', 'message' => 'Successfully logged out'], 200);
    }

    public function dashboard()
    {
        $date_filter = Session::get('date_filter');
         
        $dashboard =User::get();
        $total_mentor = DB::table('users')->where('userrole_id', "1")->count();
        $total_mentee = DB::table('users')->where('userrole_id', "2")->count();
        $total_post = DB::table('posts')->count();
        $total_question = DB::table('question')->count();
        $total_answer = DB::table('answer')->count();
        $total_job = Post::where('post_type_id',"2")->count();
        $total_company = DB::table('companies')->count();

// prevoius month of 07 
// for ($i = 1; $i <= 31; $i++) 
// {
//          $newdate[] = date("Y-m-d D", strtotime("-1 months", strtotime(date("Y-m")."$i days ago")));
// sort($newdate);
//         }
// dd($newdate);

//current week of filter 7 days
if($date_filter =="thisweek" || !$date_filter){
    for ($i=0; $i<7; $i++)
    {
            $gettimes[] = date("Y-m-d", strtotime($i." days ago"));
            sort($gettimes);
            $getdays[] = date("Y-m-d D", strtotime($i." days ago"));
            sort($getdays);
    }
}
//previous week of filter 7 days
elseif($date_filter =="lastweek")  {
    
    for ($i=0; $i<7; $i++)
    {
            $j = $i+7;
            $gettimes[] = date("Y-m-d", strtotime($j." days ago"));
            sort($gettimes);
            $getdays[] = date("Y-m-d D", strtotime($j." days ago"));
            sort($getdays);
    }
// current month of filter 30 days
}elseif($date_filter =="thismonth"  ){
    for($d=1; $d<=31; $d++)
{
    $time=mktime(12, 0, 0, date('m'), $d, date('Y'));
    if (date('m', $time)==date('m'))
    $gettimes[]=date('Y-m-d', $time);

    $time=mktime(12, 0, 0, date('m'), $d, date('Y'));
    if (date('m', $time)==date('m'))
    $getdays[]=date('d', $time);
}
// previous month of filter 30 days
}
elseif($date_filter =="lastmonth" )  
{
    for ($i = 1; $i <= 31; $i++) {
    $gettimes[] = date("Y-m-d", strtotime( date( 'Y-m-01' )." $i days ago"));
    sort($gettimes);

    $getdays[] = date("d", strtotime( date( 'Y-m-01' )." $i days ago"));
    sort($getdays);
    }
}
else{
        $picker = (explode('/' ,$date_filter));
        $startdate = $picker[0];
         $enddate = $picker[1];

        function getBetweenDates($startDate, $endDate) {
            $array = array();
            $interval = new DateInterval('P1D');
         
            $realEnd = new DateTime($endDate);
            $realEnd->add($interval);
         
            $period = new DatePeriod(new DateTime($startDate), $interval, $realEnd);
         
            foreach($period as $date) {
                $array1[] = $date->format('Y-m-d');
                $array2[] = $date->format('d');
            }

            $array["times"] = $array1;
            $array["days"]  = $array2;
            return $array;
        }
        $date_times_array = getBetweenDates($startdate, $enddate);
        
        $gettimes = $date_times_array["times"] ;
        $getdays = $date_times_array["days"];

    }
    
for($i=0; $i<count($gettimes); $i++){

            $total_hours_mentor =0;
            $total_hours_mentee =0;

                $mentors = DB::table('users')->where( [['userrole_id','=',"1"],['login_time', 'LIKE', '%'.$gettimes[$i].'%']])
                ->leftjoin('user_sessions','user_sessions.user_id','users.id')
                ->select('users.userrole_id','user_sessions.login_time','user_sessions.logout_time',)
                ->get();

         foreach($mentors as $mentorhours){
            $login_time = $mentorhours->login_time;
            $logout_time = $mentorhours->logout_time;
            $mentorhours = round((strtotime($logout_time) - strtotime($login_time))/3600, 1);
            $total_hours_mentor = $total_hours_mentor + $mentorhours;
         }

          $mentees = DB::table('users')->where( [['userrole_id','=',"2"],['login_time', 'LIKE', '%'.$gettimes[$i].'%']])
          ->leftjoin('user_sessions','user_sessions.user_id','users.id')
          ->select('users.userrole_id','user_sessions.login_time','user_sessions.logout_time',)
          ->get();

         foreach($mentees as $menteehours){
            $login_time = $menteehours->login_time;
            $logout_time = $menteehours->logout_time;
            $menteehours = round((strtotime($logout_time) - strtotime($login_time))/3600, 1);
            $total_hours_mentee = $total_hours_mentee + $menteehours;
         }

            $total_mentor_array[$i] = $total_hours_mentor;
            $total_mentee_array[$i] = $total_hours_mentee;
       }

       if($date_filter == "thismonth" || $date_filter == "lastmonth"){
                if($date_filter == "thismonth"){
                    $month_num = date('n');
                }else{
                    $month_num = date('n');
                    $month_num = $month_num - 1;

                    if($month_num == 0){
                       $month_num  =  12; 
                    }
                }
                
                $dateObj   = DateTime::createFromFormat('!m', $month_num);
                $monthName = $dateObj->format('F'); // March
                $result[] = [$monthName,'Mentor','Mentee',];
            }else{
                $result[] = ['Weeks','Mentor','Mentee',];
            }

        $cnt =1;
        for($i=0; $i<count($gettimes); $i++){
            $result[$cnt++]   = [$getdays[$i],$total_mentor_array[$i],$total_mentee_array[$i]];
        }

            
        return view('pages.dashboard',compact('dashboard', 'total_mentor', 'total_mentee','total_post','total_question','total_answer','total_job','total_company','result','date_filter'));
    }


    public function create($request)
    {
        $type = $request->user_role;
        return view('pages.create_user',compact('type'));
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
        $userlist = User::where('userrole_id','=',"1")->leftjoin('userprofile','userprofile.user_id','users.id')
          ->select('users.*','userprofile.photo','userprofile.title','userprofile.about',
          'userprofile.experience','userprofile.location')
         ->get();
        return view('pages.mentor_report', compact('userlist'));
    }

    public function getMentee()
    {
        $userlist = User::where('userrole_id','=', "2")->leftjoin('userprofile','userprofile.user_id','users.id')
          ->select('users.*','userprofile.photo','userprofile.title','userprofile.about',
          'userprofile.experience','userprofile.location')
         ->get();
        return view('pages.mentee_report', compact('userlist'));
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
        
        $user=User::where('id',$id);
        $user->delete(); 
       
        $userprofile=UserProfile::where('user_id',$id);
        $userprofile->delete();
        return back()->with('danger', 'User has been deleted');
    }

    public function forgotpassword($token)
    {
        $user = User::where('token','=',$token)->select('is_verified', 'email')->first();

        if(@$user->email && (!@$user->is_verified || @$user->is_verified == 0)){
            return view('emails.change_password', compact('user'));
        }else{
            return redirect('invalid-try');
        }
    }

    public function resetpassword($request)
    {
        $validator = validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['status' => false, 'message' =>  "Failed! email is not registered."], 400);
        }

        $token = Str::random(60);

        $user['token'] = $token;
        $user['is_verified'] = 0;
        $user->save();

        $mail_details = [
            'email' => $request->email,
            'token' => $token,
            'name' => $user->firstname. " " . $user->lastname,
            'is_verified' => $user['is_verified'],
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

        if ($validator->fails()) {
        return response()->json(['code' => false, 'msg' => implode(",",$validator->errors()->all())], 200);
        }

        $data =array();

        $user = User::where('email',$request->email)->first();

        if ($user && (!@$user->is_verified || @$user->is_verified == 0))
        {
            $user['is_verified'] = 1;
            $user['token'] = '';
            $user['password'] = Hash::make($request->password);
            $user->save();

           // dd($user->email);
            $data["code"] = "success";
            $data["msg"]  = 'Success! password has been changed';
            return json_encode($data);
        }elseif(@$user->is_verified == 1){
            $data["code"] = "verified";
            $data["msg"]  = 'Already! password has been changed';
            return json_encode($data);
        }
        $data["code"] = $request->email;
        $data["msg"]  = 'Failed! something went wrong';
        return json_encode($data);
    }

    public function follow(FollowRequest $request)
    {
        $follow = Follow::where([['mentor_id',$request->mentor_id],['mentee_id',Auth::user()->id],['status',1]])->pluck('id')->first();
        $followReq = Follow::where([['mentor_id',$request->mentor_id],['mentee_id',Auth::user()->id],['status',2]])->first();

        if($follow){
            $unFollow = Follow::where('id',$follow)->Update([
                
                'status' => '2'
              ]);

            $responseData['status']=false;
            $responseData['message'] = "Unfollowed Successfully";
            return response()->json($responseData);
        }else if($followReq)
        {
            $followBy = Follow::where([['mentor_id',$request->mentor_id], ['mentee_id',Auth::user()->id]])->Update([
                
                'status' => '1'
            ]);

            self::followNotification($request->mentor_id,Auth::user()->id);

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

            self::followNotification($request->mentor_id,Auth::user()->id);

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
        $followCollection=Follow::where([['mentee_id',Auth::user()->id],['mentee_id',Auth::user()->id],['status','1']])->select('mentor_id', 'mentee_id')->get();
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

            $followDetails_array = array();
            $followDetails_array["followDetails"] = $menteeFollowDetails;

            $responseData['status']=true;
            $responseData['message']='Successful';
            $responseData['data']=$followDetails_array;
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

    //video report module
    public function videoReport(){
        $videoreports = Videoreport::leftjoin('answer','answer.id','videoreports.answer_id')
                        ->leftjoin('users','users.id','answer.answer_by')
                        ->select('users.firstname','users.lastname','users.email','videoreports.report_by','videoreports.report_content',
                        'videoreports.id','videoreports.comments')
                        ->get();


        $video_object = array();
        $cnt = 0;
        foreach( $videoreports as $details){
            $user = User::where('id','=',$details->report_by)->select('firstname','lastname','email')
                        ->first();

            $video_object[$cnt]['id'] = $details->id;
            $video_object[$cnt]['report_by'] = $user->firstname." ".$user->lastname;
            $video_object[$cnt]['email'] = $user->email;
            $video_object[$cnt]['answer_by'] = $details->firstname." ".$details->lastname;
            $video_object[$cnt]['mentor_email'] = $details->email;
            $video_object[$cnt]['report_content'] = $details->comments;
            $video_object[$cnt]['comments'] = $details->comments;
            $cnt++;
        }

        return view('pages.video_report' ,compact('video_object'));
    }

    public function videoDelete($id){
        $Videoreport=Videoreport::where('id',$id);
        $Videoreport->delete();

        return back()->with('danger', 'User has been deleted');
    }
    //video report module

    //post report module
    public function postReport(){
        $postreports = Postreport::leftjoin('posts','posts.id','postreports.post_id')
                            ->leftjoin('users','users.id','posts.posted_by_id')
                            ->select('users.firstname','users.lastname','users.email','postreports.report_by',
                            'postreports.report_content','postreports.comments','postreports.id')
                            ->get();

        $post_object = array();
        $cnt = 0;

        foreach( $postreports as $details){
            $user = User::where('id','=',$details->report_by)->select('firstname','lastname','email')
                        ->first();

            $post_object[$cnt]['id'] = $details->id;
            $post_object[$cnt]['report_by'] = $user->firstname." ".$user->lastname;
            $post_object[$cnt]['email'] = $user->email;
            $post_object[$cnt]['answer_by'] = $details->firstname." ".$details->lastname;
            $post_object[$cnt]['mentor_email'] = $details->email;
            $post_object[$cnt]['report_content'] = $details->comments;
            $post_object[$cnt]['comments'] = $details->comments;
            $cnt++;
        }
                            
        return view('pages.post_report',compact('post_object'));
    }

    public function postDelete($id){
        $Postreport=Postreport::where('id',$id);
        $Postreport->delete();

        return back()->with('danger', 'User has been deleted');
    }
    //post report module

    //invalid email
    public function invalidEmail(){
        
        return view('pages.invalid_email');
    }
    //invalid email

    //video url
    public function videoURL($id){
        
        $answer = Answer::where("answer.id",$id)->leftjoin("question","question.id","answer.question_id")
                  ->select("answer.media","question.question")->first();

        $media_type_array = explode(".",$answer->media) ;  
        $media_type       = $media_type_array[1];       

        return view('pages.video_url',compact('answer','media_type'));
    }

    public function getMedia($id){
                $path = storage_path('public/media/' . $id);

                if (!File::exists($path)) {
            
                    abort(404);
            
                }
            
                $file = File::get($path);
            
                $type = File::mimeType($path);
            
            
            
                $response = Response::make($file, 200);
            
                $response->header("Content-Type", $type);

                return $response;
    }
    //video url

    // Admin Profile Edit and Update
   
     public function userprofileedit($id)
     {
        $user_details = User::find($id); 
        $userlist = User::leftjoin('userprofile','userprofile.user_id','users.id')
        ->select('users.*','userprofile.photo','userprofile.title','userprofile.about',
        'userprofile.experience','userprofile.location')
        ->where('users.id',$id)
       ->get();

        return view('pages.profileedit', compact('user_details','userlist'));
         
     }
     public function requestUserprofile(AdminRequest $request, $id)
    {
        User::where('id', $id)->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request['password']),
        ]);
        return redirect()->route('profileedit',$id)->with('message', 'AdminProfile has been updated Successfully.');
    }

    public function chartFilter($request)
    {  

        $req = Session::put('date_filter',$request->barchart);
        // $reqt = Session::put('date_filter',[$request->startdate,$request->enddate]);

        $chart = Session::get('date_filter',);
        
        return 1;
    }
    // public function rangeFilter($request)
    // {  
    //     // [ 'first_name' => $request->get('first_name'), 'last_name' => $request->get('last_name');
    //     $reqt = Session::put('range_filter',[$request->startdate,$request->enddate]);
    //     $charts = Session::get('range_filter',);

    //     return 1;
    // }

    public function mentorTagList($request){

        $filter = $request->filter;
        if($filter){
            $mentor_details = User::where([[DB::raw("CONCAT(users.firstname, ' ', users.lastname)"),'like',"%$filter%"],["userrole_id","1"]])->select(DB::raw("CONCAT(users.firstname, ' ', users.lastname) as fullname"),'id')->get();
        }else{
            $mentor_details = User::where("userrole_id","1")->select(DB::raw("CONCAT(users.firstname, ' ', users.lastname) as fullname"),'id')->get();
        }

        $responseData["status"]          = true;
        $responseData["data"]["mentors"] = $mentor_details;

        return response()->json($responseData);

    }
    
}