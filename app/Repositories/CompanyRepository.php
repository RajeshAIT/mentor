<?php

namespace App\Repositories;

use DB;
use Mail;
use App\Models\Post;
use App\Models\User;
use App\Mail\TestMail;
use App\Models\Company;
use App\Mail\InviteMail;
use App\Models\Postmedia;
use App\Models\RankingList;

use App\Models\UserProfile;
use Illuminate\Support\Str;
use App\Models\InvitePeople;
use App\Models\CompanyVerify;
use App\Interfaces\CompanyInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\CompanyRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class CompanyRepository implements CompanyInterface
{
    protected $url;

    public function getCompanyById($id)
    {
       $companyCollection=Company::where('id',$id)->select('user_id','company_name','logo','description')->first();
       if($companyCollection)
       {
          $companyDetails['user_id']=$companyCollection->user_id;
          $companyDetails['company_name']=$companyCollection->company_name;
          $companyDetails['description']=$companyCollection->description;
          $companyDetails['logo']=url('/api/image/'.$id);

          $userprofileCollection=InvitePeople::where([['company_id',$id],['status','=',1]])->select('email')->get();
           $inviteUserDetails=[];
           foreach($userprofileCollection as $userProfile)
           {
           if($userProfile)
           {
             $people = User::where('email', '=', $userProfile->email)->first();
             if($people)
             {
             $peopleprofile = UserProfile::where('user_id', '=', $people->id)->first();
             $photo=url('/api/user/profile/images/' . $people->id);
             $profileDetails['id'] = $people->id;
             $profileDetails['name'] = $people->firstname . " " . $people->lastname;
             $profileDetails['photo']=isset($peopleprofile)?$photo:null;
             
             array_push($inviteUserDetails,$profileDetails);
             }
           }
         }

          $posts = Post::where('company_id', '=', $id)->select('id','title','comment','post_type_id','qualification','experience','salary_min','salary_max')->get();
          $userpostDetails=[];
          $uservideoDetails=[];
          foreach($posts as $userPost)
          {
            $post_id = $userPost->id;

            if($userPost->post_type_id == '1')
            {
            $post_media_url = Postmedia::where('post_id', '=', $post_id)->select('media_type_id')->first();

            if($post_media_url)
            {
                $postDetails=$post_media_url;
            }
            $postDetails['post_type_id']=$userPost->post_type_id;
            $postDetails['id']=$post_id;
            $postDetails['title']=$userPost->title;
            $postDetails['comment']=$userPost->comment;
            $s3 = Storage::disk('s3')->getAdapter()->getClient();
            $postDetails['media'] = $s3->getObjectUrl( env('AWS_BUCKET'), 'post_media/'.$userPost->media_url );
            
            $postDetails['thumbnail'] = $s3->getObjectUrl( env('AWS_BUCKET'), 'post_media/'.$userPost->media_url );
            if($post_media_url->media_type_id!=1)
            {
                $postDetails['thumbnail']=$s3->getObjectUrl( env('AWS_BUCKET'), 'post_media/thumbnail/'.$userPost->media_thumbnail );
            }
                array_push($userpostDetails,$postDetails);
           }

           if ($userPost->post_type_id == '2')
            {
            $jobpostDetails['post_type_id']=$userPost->post_type_id;
            $jobpostDetails['id']=$post_id;
            $jobpostDetails['title']=$userPost->title;
            $jobpostDetails['comment']=$userPost->comment;
            $jobpostDetails['qualification']=$userPost->qualification;
            $jobpostDetails['experience']=$userPost->experience;
            $jobpostDetails['salary_min']=$userPost->salary_min;
            $jobpostDetails['salary_max']=$userPost->salary_max;

            array_push($userpostDetails,$jobpostDetails);
           }

            $post_media = Postmedia::where([['post_id',$userPost->id],['media_type_id','2']])->select('post_id', 'media_url', 'media_thumbnail', 'media_type_id')->get();
            foreach($post_media as $media)
            {
                $s3 = Storage::disk('s3')->getAdapter()->getClient();
                $videoDetails['video_url']= $s3->getObjectUrl( env('AWS_BUCKET'), 'post_media/'.$media->media_url );
                $videoDetails['thumbnail']=$s3->getObjectUrl( env('AWS_BUCKET'), 'post_media/thumbnail/'.$media->media_thumbnail );
                $videoDetails['media_type_id']=2;

                array_push($uservideoDetails,$videoDetails);
            }
          }
          $companyDetails['post']=$userpostDetails;
          $companyDetails['video']=$uservideoDetails;
          $companyDetails['people']=$inviteUserDetails;

          $responseData['status']=true;
          $responseData['message']='Successful';
          $responseData['data']=$companyDetails;
          return response()->json($responseData);
        } else {
           $responseData['status']=false;
           $responseData['message']='Invalid ID';
           return response()->json($responseData);
        }
    }

    public function requestCompany(CompanyRequest $request, $id = null)
    {
        DB::beginTransaction();

        if($request->logo)
        {
        $file = $request->file('logo');
        $input['logo'] = time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = storage_path('public/logo/');
        $file->move($destinationPath, $input['logo']);
        } else
        {
            $input['logo']=null;
        }

        $id = $request->id;
        if($request->id)
        {
        $companyUpdate = Company::where([['user_id',Auth::user()->id],['id',$id]])->first();
        if($companyUpdate)
        {
            if(!$request->company_name){
                $request->company_name = $companyUpdate->company_name;
            }

            if(!$request->description){
                $request->description = $companyUpdate->description;
            }

            if($input['logo'] == null){
                $input['logo'] = $companyUpdate->logo;
            }

            $company = Company::updateOrCreate([
                'id' => $id,
            ], [
                'company_name' => $request->company_name,
                'user_id' => Auth::user()->id,
                'logo' => $input['logo'],
                'description' => $request->description,
                'created_by' => Auth::user()->id,
            ]);

            if($input['logo'] != null)
            {
                $logo = url('/api/image/' . $company->id);
            } else {
                $logo = null;
            }

            DB::commit();
                $responseData['status']=true;
                $responseData['message']='Successful';
                $companyCollection = array("id" => $company['id'], "logo" => $logo, "name" => $company->company_name, "description" => $company->description);
                $responseData['data']=$companyCollection;
                return response()->json($responseData);
        }
        else{
            $responseData['status']=false;
            $responseData['message']='Invalid User ID';
            return response()->json($responseData);
        }
      } else {
        $companyVerify = Company::where('user_id',Auth::user()->id)->select('user_id')->first();
        if($companyVerify)
        {
           $responseData['status']=false;
           $responseData['message']='Company Already Created';
           return response()->json($responseData);
        } else 
        {
            $company = Company::updateOrCreate([
                'id' => $id,
            ], [
                'company_name' => $request->company_name,
                'user_id' => Auth::user()->id,
                'logo' => $input['logo'],
                'description' => $request->description,
                'created_by' => Auth::user()->id,
            ]);

            if($request->logo)
            {
                $logo = url('/api/image/' . $company->id);
            } else {
                $logo = null;
            }

            if($company)
            {
                $points = RankingList::create([
                    'user_id' => Auth::user()->id,
                    'points' => 25,
                    'reasons' => "Company",
                ]);
            }
    
            DB::commit();
                $responseData['status']=true;
                $responseData['message']='Successful';
                $companyCollection = array("id" => $company['id'], "logo" => $logo, "name" => $company->company_name, "description" => $company->description);
                $responseData['data']=$companyCollection;
                return response()->json($responseData);
        }
      }
    }

    public function verify($token)
    {
        $company = CompanyVerify::where('token','=',$token)->select('verify')->first();
        return view('emails.emailVerificationEmail', compact('company'));
    }

    public function requestWebsite($request)
    {
        $resend = $request->resend;

        $verifiesEmail = CompanyVerify::where([['email', '=', $request->input('email')], ['verify', '=', '2'], ['user_id', '=', Auth::user()->id]])->first();
        if($verifiesEmail)
        {
            return response()->json(['status' => false, 'email_verify' => false, 'message' => "Email already Verified"], 400);
        }

        $mailVerify = CompanyVerify::where('user_id', '=', Auth::user()->id)->select('email')->first();
        if($mailVerify && is_null($resend))
        {
            return response()->json(['status' => false, 'email_verify' => false, 'message' => "Mail already sent, to verify your Email click resend"], 400);
        }

        $verifies = CompanyVerify::where([['email', '=', $request->input('email')], ['verify', '=', '1'], ['user_id', '=', Auth::user()->id]])->first();

        if($resend == '1')
        {
            if($verifies)
            {
            $validator = validator::make($request->all(), [
                'email' => 'required',
            ]);
    
            if ($validator->fails())
            {
                return response()->json(['status' => false, 'message' => implode(",",$validator->errors()->all())], 400);
            }

            $token = Str::random(64);

            $companyVerify =  CompanyVerify::where('email','=',$request->email)->update([
                'token' => $token,
            ]);

            $mail_details = [
                'name' => "name",
                'token' => $token
            ];

             Mail::to($request->email)->send(new TestMail($mail_details));

            return response()->json(['status' => true, 'email_verify' => false, 'message' =>  "Mail sent Successfully"], 200);
        } else {
            return response()->json(['status' => false, 'email_verify' => false, 'message' => "Enter a valid Email"], 400);
        }
        } else if(is_null($resend) && $verifies === null)
        {
            $validator = validator::make($request->all(), [
                'name' => 'required',
                'website' => 'required',
                'email' => 'required',
            ]);
    
            if ($validator->fails())
            {
                return response()->json(['status' => false, 'message' => implode(",",$validator->errors()->all())], 400);
            }

            $requestName = $request->name;
            $requestUrl = $request->website;
            $get_http_response_code = self::get_http_response_code($requestUrl);

            $requestEmail = $request->email;
            $emailDomain = explode('@', $requestEmail);
            $mail = $emailDomain[1];

            $urlDomain = explode('.', $requestUrl);
            $url = $urlDomain[1].".".$urlDomain[2];

          if($get_http_response_code == 200 && $mail == $url)
          {
            $token = Str::random(64);
            
            $companyVerify =  CompanyVerify::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'website' => $request->website,
                'email' => $request->email,
                'token' => $token,
                'verify' => '1',
            ]);

            $mail_details = [
                'name' => $request->name,
                'token' => $token
            ];

             Mail::to($requestEmail)->send(new TestMail($mail_details));

            $responseData['status']=true;
            $responseData['email_verify']=false;
            $responseData['message']="Mail sent Successfully";
            $mailCollection = array("email" => $request->email);
            $responseData['data']=$mailCollection;
            return response()->json($responseData);
          } else {
            return response()->json(['status' => false, 'email_verify' => false, 'message' => "Invalid Email-ID"], 400);
          }
        } else {
            return response()->json(['status' => false, 'email_verify' => false, 'message' => "Email already sent"], 400);
        }
    }

    public function companyVerify($request, $token)
    {
        $verifyCompany = CompanyVerify::where(['token'=>$token, 'email'=>$request->email])->first();
       
        $message = 'Token expired, check recently sent Mail';

        if(!is_null($verifyCompany))
        {
            if($verifyCompany->verify== 1 && $request->email == $verifyCompany->email)
            {
                $verifyCompany->verify = 2;
                $verifyCompany->save();
                $message = "Your E-mail is verified";
            } else
            {
                $message = "Your E-mail is already verified";
            }
        }
        return back()->with('message', $message);
    }

    public function invitepeople($request)
    {
        $validator = validator::make($request->all(), [
            'email' => 'required',
        ]);

        $company_id = Company::where('user_id', Auth::user()->id)->first();

        $InviteUser =  InvitePeople::create([
            // 'user_id' => $user_id,
             'company_id' => $company_id->id,
             'email' => $request->email,
         ]);

        $inviteEmail = InvitePeople::where([['email', '=', $request->input('email')], ['status', '=', '1'], ['company_id', '=', $company_id->id]])->first();
        if($inviteEmail)
        {
            return response()->json(['status' => false, 'message' => "People already added"], 400);
        }

        // $mailVerify = InvitePeople::where('email', '=', $request->input('email'))->first();
        // if($mailVerify)
        // {
        //     return response()->json(['status' => false, 'message' => "Mail already sent to this Email-ID"], 400);
        // }

        $userEmail=User::where('email', $request->email)->select('id')->first();
        if($userEmail)
        {
            $user_id = $userEmail->id;
            $link = "https://mentorsocial.test-app.link/Y68OttTYctb?company_id=".$company_id->id."&email=".$request->email."&user_id=".$user_id;
        } else
        {
            $mailVerify = InvitePeople::where('email', '=', $request->email)->first();
            $user_id = null;
            $link = "https://mentorsocial.test-app.link/Y68OttTYctb?company_id=".$mailVerify->company_id."&email=".$mailVerify->email."&user_id=".$user_id;
        }

        $mail_details = [
            'company_id' => $company_id->id,
            'invite_link' => $link
        ];
        
        Mail::to($request->email)->send(new InviteMail($mail_details));

        return response()->json(['status' => true, 'message' =>  "Mail sent Successfully"], 200);
    } 

    public function getpeople($request)
    {
        $inviteEmail = User::where('email',$request->email)->select('email')->first();

        if($inviteEmail)
        {
            $inviteUser = InvitePeople::where([['email', $inviteEmail->email],['company_id',$request->company_id]])->first();
        if(!is_null($inviteUser))
        {
            if($inviteUser->status== 0)
            {
                $inviteUser->status = 1;
                $inviteUser->save();
                return response()->json(['status' => true, 'message' =>  "People added Successfully"], 200);
            } else
            {
                return response()->json(['status' => false, 'message' =>  "People already added"], 400);
            }
        }
      } else {
        return response()->json(['status' => false, 'message' =>  "Invalid User, need to Sign UP"], 400);
      }
    }

    function get_http_response_code($requestUrl)
    {
        try
        {
            $headers = get_headers($requestUrl);
            return substr($headers[0], 9, 3);
        }
        catch(\Exception $e)
        {
            return false;
        }
    }

    // company records

    public function companyindex($request)
    {

    $companyindex =1;   
    $company_details = DB::table('companies')
        ->join('users','companies.created_by', '=','users.id')
        ->select('companies.id','companies.company_name','users.firstname','users.lastname')
        ->groupBy('companies.id')
        ->get(); 
        // dd($user_posts);
       return view ('company.index',compact('company_details','companyindex'));
    }

    public function companydestroy($id)
    {
        $post = Company::where('id',$id);
        $post->delete();
        return redirect()->back()->with('danger','Company deleted successfully');
    }
    public function companyshow($id)
    {
        $user_posts = Company::find($id);
        $posts = Post::where([['company_id',$id],['post_type_id','1']])
        ->leftjoin('companies','companies.id', '=','posts.company_id')
        ->leftjoin('users','posts.posted_by_id', '=','users.id')
        ->leftjoin('postmedia','postmedia.post_id', '=','posts.id')
        ->select('users.firstname','users.lastname','companies.logo','posts.id','posts.title','posts.comment','posts.created_at','postmedia.media_url','postmedia.media_thumbnail','postmedia.post_id')
        ->get();
        // $CompanyLogo = Company::where('id',$id)->pluck('logo')->first();
        // $path = storage_path('public/logo/' . $CompanyLogo);
        $people = DB::table('company_verifies')
        ->leftjoin('users','users.id', '=','company_verifies.user_id')
        ->select('company_verifies.name','users.*',)
        ->get(); 
        
        $jobposts = Post::where([['company_id',$id],['post_type_id','2']])
        ->leftjoin('users','posts.posted_by_id', '=','users.id')
        ->leftjoin('postmedia','postmedia.post_id', '=','posts.id')
        ->select('users.*','posts.*','postmedia.*')
        ->get();

       return view ('company.show',compact('user_posts','posts','jobposts','people'));
    }




   
    
    public function companyLogo($id)
    {
        $CompanyLogo = Company::where('id',$id)->pluck('logo')->first();
        $path = storage_path('/public/logo/' . $CompanyLogo);
        if (!File::exists($path))
    {
        abort(404);
    }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
        return view ('company.show',compact('response'));
    }

    

    
}