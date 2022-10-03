<?php

namespace App\Traits;

use App\Models\Question;
use App\Models\Answer;
use App\Models\User;
use App\Models\Follow;
use App\Models\Notification;
use App\Models\UserReaction;
use App\Models\Tagmentor;
use Illuminate\Support\Facades\Auth;

trait FirebaseAPI
{
    
    public function QuestionCreateNotification($question_id){

        $user_id = Auth::user()->id;

        $url = 'https://fcm.googleapis.com/fcm/send';
        
        $serverKey = env('FIREBASE_SEC_KEY');
        $FcmToken = User::where('userrole_id',1)->pluck('fcm')->all();

        $user_details = User::where("id",$user_id)->first();
        $firstname    = $user_details->firstname;
        $lastname     = $user_details->lastname;

        $org_name     = $firstname." ".$lastname;

        $unseen     = Notification::where([["user_id",Auth::user()->id],["seen","0"]])->get();
        $seen       = Notification::where([["user_id",Auth::user()->id],["seen","1"]])->get();
        $unseen_cnt = count($unseen);
        $seen_cnt   = count($seen);
        
        $title = 'Question Created';
        $body  = $org_name.' Mentee Posted a New Question';

        $data = [
            "registration_ids" => $FcmToken,
            "content_available" => true,  
            "notification" => [
                "title" => $title,
                "body" => $body,
                "icon" => asset("dist/img/AdminLTELogo.png"),
                "id" => "10",
                "sound" => "default" 
            ],
            "data" => [
                "unseen_cnt" => $unseen_cnt,
                "seen_cnt" => $seen_cnt
            ]
        ];
        $encodedData = json_encode($data);
        
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

        // Execute post
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }        
	
        // Close connection
        curl_close($ch);


        $user_ids = User::where('userrole_id',1)->pluck('id')->all();
        
        for($i=0; $i<count($user_ids); $i++){

            Notification::create([
                "user_id" => $user_ids[$i],
                "question_id" => $question_id,
                "notification_type" => "Create_question",
                "seen" => 0,
                "title" => $title,
                "body" => $body
            ]);

        }
    }

    public function QuestionAnswerNotification($answer_id){

        $user_id = Auth::user()->id;

        $url = 'https://fcm.googleapis.com/fcm/send';
        
        $serverKey = env('FIREBASE_SEC_KEY');
        
        $question_details = Question::where("answer.id",$answer_id)->select("question.created_by","question.id")
                            ->leftjoin("answer","answer.question_id","question.id")->first();


        $FcmToken = User::where('id',$question_details->created_by)->pluck('fcm')->all();

        $user_details = User::where("id",$user_id)->first();
        $firstname    = $user_details->firstname;
        $lastname     = $user_details->lastname;

        $org_name     = $firstname." ".$lastname;

        $unseen     = Notification::where([["user_id",Auth::user()->id],["seen","0"]])->get();
        $seen       = Notification::where([["user_id",Auth::user()->id],["seen","1"]])->get();
        $unseen_cnt = count($unseen);
        $seen_cnt   = count($seen);
        
        $title = 'Got the Answer';
        $body  = $org_name.' Mentor Answered your Question';

        $data = [
            "registration_ids" => $FcmToken,
            "content_available" => true,  
            "notification" => [
                "title" => $title,
                "body" => $body,
                "icon" => asset("dist/img/AdminLTELogo.png"),
                "id" => "10",
                "sound" => "default" 
            ],
            "data" => [
                "unseen_cnt" => $unseen_cnt,
                "seen_cnt" => $seen_cnt
            ]
        ];
        $encodedData = json_encode($data);
        
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

        // Execute post
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }        
	
        // Close connection
        curl_close($ch);

        $user_ids = User::where('id',$question_details->created_by)->pluck('id')->all();
        
        for($i=0;$i<count($user_ids); $i++){

            Notification::create([
                "user_id" => $user_ids[$i],
                "answer_id" => $answer_id,
                "question_id" => $question_details->id,
                "notification_type" => "answer",
                "seen" => 0,
                "title" => $title,
                "body" => $body
            ]);

        }
    }

    public function reactionNotification($reaction_id,$answer_id){

        $user_id = Auth::user()->id;

        $url = 'https://fcm.googleapis.com/fcm/send';
        
        $serverKey = env('FIREBASE_SEC_KEY');
        
        $answer_details = Answer::where("id",$answer_id)->select("answer_by","question_id")
                            ->first();


        $FcmToken = User::where('id',$answer_details->answer_by)->pluck('fcm')->all();

        $user_details = User::where("id",$user_id)->first();
        $firstname    = $user_details->firstname;
        $lastname     = $user_details->lastname;

        $org_name     = $firstname." ".$lastname;

        $unseen     = Notification::where([["user_id",Auth::user()->id],["seen","0"]])->get();
        $seen       = Notification::where([["user_id",Auth::user()->id],["seen","1"]])->get();
        $unseen_cnt = count($unseen);
        $seen_cnt   = count($seen);
        
        $title = 'Got the Reaction';
        $body  = $org_name.' Mentee Reacted your Answer';

        $data = [
            "registration_ids" => $FcmToken,
            "content_available" => true,  
            "notification" => [
                "title" => $title,
                "body" => $body,
                "icon" => asset("dist/img/AdminLTELogo.png"),
                "id" => "10",
                "sound" => "default" 
            ],
            "data" => [
                "unseen_cnt" => $unseen_cnt,
                "seen_cnt" => $seen_cnt
            ]
        ];
        $encodedData = json_encode($data);
        
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

        // Execute post
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }        
	
        // Close connection
        curl_close($ch);

        $user_ids = User::where('id',$answer_details->answer_by)->pluck('id')->all();
        
        for($i=0;$i<count($user_ids); $i++){

            Notification::create([
                "user_id" => $user_ids[$i],
                "reaction_id" => $reaction_id,
                "question_id" => $answer_details->question_id,
                "notification_type" => "reaction",
                "seen" => 0,
                "title" => $title,
                "body" => $body
            ]);

        }
    }

    public function followNotification($mentor_id,$mentee_id){

        $user_id = Auth::user()->id;

        $url = 'https://fcm.googleapis.com/fcm/send';
        
        $serverKey = env('FIREBASE_SEC_KEY');
        
        $follow_details = Follow::where([['mentor_id',$mentor_id],['mentee_id',$mentee_id],['status',1]])->select('id')->first();

        $unseen     = Notification::where([["user_id",Auth::user()->id],["seen","0"]])->get();
        $seen       = Notification::where([["user_id",Auth::user()->id],["seen","1"]])->get();
        $unseen_cnt = count($unseen);
        $seen_cnt   = count($seen);

        $FcmToken = User::where('id',$mentor_id)->pluck('fcm')->all();

        $user_details = User::where("id",$user_id)->first();
        $firstname    = $user_details->firstname;
        $lastname     = $user_details->lastname;

        $org_name     = $firstname." ".$lastname;

        
        $title = 'You have follow request';
        $body  = $org_name.' Mentee following you';

        $data = [
            "registration_ids" => $FcmToken,
            "content_available" => true,  
            "notification" => [
                "title" => $title,
                "body" => $body,
                "icon" => asset("dist/img/AdminLTELogo.png"),
                "id" => "10",
                "sound" => "default" 
            ],
            "data" => [
                "unseen_cnt" => $unseen_cnt,
                "seen_cnt" => $seen_cnt
            ]
        ];
        $encodedData = json_encode($data);
        
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

        // Execute post
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }        
	
        // Close connection
        curl_close($ch);

        $user_ids = User::where('id',$mentor_id)->pluck('id')->all();
        
        for($i=0;$i<count($user_ids); $i++){

            Notification::create([
                "user_id" => $user_ids[$i],
                "follow_id" => $follow_details->id,
                "notification_type" => "follow",
                "seen" => 0,
                "title" => $title,
                "body" => $body
            ]);

        }

        
    }

    public function TagMentorNotification($question_id){

        $user_id = Auth::user()->id;

        $url = 'https://fcm.googleapis.com/fcm/send';
        
        $serverKey = env('FIREBASE_SEC_KEY');
        
        $FcmToken = Tagmentor::where([["tagmentors.question_id",$question_id],["tagged_by",$user_id]])
                            ->leftjoin("users","tagmentors.mentor_id","users.id")
                            ->pluck("users.fcm")->all();

        
        //$FcmToken = User::where('id',$question_details->created_by)->pluck('fcm')->all();

        $user_details = User::where("id",$user_id)->first();
        $firstname    = $user_details->firstname;
        $lastname     = $user_details->lastname;

        $org_name     = $firstname." ".$lastname;

        $unseen     = Notification::where([["user_id",Auth::user()->id],["seen","0"]])->get();
        $seen       = Notification::where([["user_id",Auth::user()->id],["seen","1"]])->get();
        $unseen_cnt = count($unseen);
        $seen_cnt   = count($seen);
        
        $title = 'Tagged in the Question';
        $body  = $org_name.' Mentee Tagged in New Question';

        $data = [
            "registration_ids" => $FcmToken,
            "content_available" => true,  
            "notification" => [
                "title" => $title,
                "body" => $body,
                "icon" => asset("dist/img/AdminLTELogo.png"),
                "id" => "10",
                "sound" => "default" 
            ],
            "data" => [
                "unseen_cnt" => $unseen_cnt,
                "seen_cnt" => $seen_cnt
            ]
        ];
        $encodedData = json_encode($data);
        
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

        // Execute post
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }        
	
        // Close connection
        curl_close($ch);

        $user_ids = Tagmentor::where([["tagmentors.question_id",$question_id],["tagged_by",$user_id]])
                    ->leftjoin("users","tagmentors.mentor_id","users.id")
                    ->pluck("users.id")->all();
        
        for($i=0;$i<count($user_ids); $i++){

            Notification::create([
                "user_id" => $user_ids[$i],
                "question_id" => $question_id,
                "notification_type" => "Tag_mentor",
                "seen" => 0,
                "title" => $title,
                "body" => $body
            ]);

        }
    }
}