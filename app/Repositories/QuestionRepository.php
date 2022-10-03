<?php

namespace App\Repositories;

use File;
use App\Models\User;
use App\Models\Post;
use App\Models\Answer;
use App\Models\UpVote;
use App\Models\Company;
use App\Models\Emotion;
use App\Models\Category;
use App\Models\Question;
use App\Models\RankingList;
use App\Models\TopKeywords;
use App\Models\UserProfile;
use App\Traits\ResponseAPI;
use App\Models\UserReaction;
use App\Models\Tagmentor;
//video report module
use App\Models\Videoreport;
use App\Models\Videoreportcontent;
//video report module
//post report module
use App\Models\Postreport;
//post report module
//save question module
use App\Models\Savedanswer;
//save question module
//shared media module
use App\Models\Sharedmedia;
//shared media module
use Illuminate\Support\Facades\DB;
use App\Models\QuestionAssociation;
use App\Http\Requests\UpvoteRequest;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\QuestionInterface;
use App\Http\Requests\QuestionRequest;
use App\Http\Requests\ReactionRequest;

use App\Traits\FirebaseAPI;

use Storage;

class QuestionRepository implements QuestionInterface
{
    use ResponseAPI;
    use FirebaseAPI;

    public function getQuestionAnswer(QuestionRequest $request)
    {
      DB::beginTransaction();

      $badge = null;
      $question_count = 0;
      $points         = 15;

      $tag_mentors = $request->mentor_list;

      if($tag_mentors){
        $tag_mentor_cnt = count($tag_mentors);

        if($tag_mentor_cnt > 4){
          return response()->json(['status' => false, 'message' => "Permission denied ! Maxmimum 4 members are allowed." ], 500);
        }
      }
      
      $question = Question::create([
        'question' => $request->question,
        'created_by'=> Auth::user()->id,
        'category_id' => $request->category_id,
        'emotion_id' => $request->emotion_id,
        'question_association_id'=> $request->question_association_id
      ]);

      if($question->id)
      {
          
          if($tag_mentors){
            foreach($tag_mentors as $mentor_id){
              Tagmentor::create([
                "mentor_id" => $mentor_id,
                "question_id" => $question->id,
                "tagged_by" => Auth::user()->id
              ]);
            }

            $points = $points + 1;
            self::TagMentorNotification($question->id);
          }

          $points = RankingList::create([
              'user_id' => Auth::user()->id,
              'points' => $points,
              'reasons' => "Question",
          ]);

          $question_count = Question::where('created_by','=',Auth::user()->id)->count();
          if($question_count >= 25 && $question_count < 50){
            $badge = "Silver";
          }elseif($question_count >= 50 && $question_count < 100  ){
            $badge = "gold";
          }elseif($question_count >= 100){
            $badge = "Platinum";
          }

          self::QuestionCreateNotification($question->id);

          DB::commit();
          $data['question'] = $request->question;
          $data['user_id'] = Auth::user()->id;
          $data['category_id'] = $request->category_id;
          $data['emotion_id'] = $request->emotion_id;
          $data['question_association'] = $request->question_association_id;

          $message = "Question Stored Successfully";
          return response()->json(['status' => true, 'message' =>  $message,'badge' => $badge,'question_count' => $question_count ], 200);
      }else{
          $message = "Question Stored Failed";
          return response()->json(['status' => true, 'message' =>  $message,'badge' => $badge ], 200);
      }
      
      
    }

    public function questionFeed()
    {
      $responseData=[];
      $responseData['questions_feeds']=[];
      

      if(request()->filter == 1)
      {

          $upvotedQuestion = Upvote::select('question_id')
          ->groupBy('question_id')
          ->orderByRaw('COUNT(*) DESC')
          ->limit(1)
          ->first();


          $questionCollection = Question::where('id',@$upvotedQuestion->question_id)->orderBy('created_at',"DESC")->get();

          if($questionCollection){
            foreach($questionCollection as $question)
            {
              $profile_logo = UserProfile::where('user_id',$question->created_by)->pluck('photo')->first();
              $profile_picture = url('api/user/profile/images').'/'.$question->created_by;

              if(!$profile_logo){
                $profile_picture = null;
              }
      
              $Answer_link = Answer::where('id',$question->id)->pluck('media')->first();
              $Answer_url = url('/api/question').'/'.$question->id.'/answer';
      
              $questionDetails['id']=$question->id;
              $questionDetails['question']=$question->question;
              $userDetails=User::where('id',$question->created_by)->first();
              $questionDetails['user_id']= @$userDetails->id;
              $questionDetails['user_name']= @$userDetails->firstname.' '.@$userDetails->lastname;
              $questionDetails['category']=Category::where('id',$question->category_id)->select("id","job_title")->first();
              $questionDetails['emotion']=Emotion::where('id',$question->emotion_id)->select("id","emotion")->first();
              $questionDetails['questionAssociation']=QuestionAssociation::where('id',$question->question_association_id)
              ->select("id","question_association")->first();
              $questionDetails['profile_picture']= $profile_picture;
              //$questionDetails['answers']=isset($Answer_link)?$Answer_url:null;
              array_push($responseData['questions_feeds'],$questionDetails);
            }
          }

          
      } else if(request()->filter== 2)
      {

          $questionCollection = Question::orderBy('id', 'DESC')->first();
          
          if($questionCollection){
            
              $profile_logo = UserProfile::where('user_id',$questionCollection->created_by)->pluck('photo')->first();
              $profile_picture = url('api/user/profile/images').'/'.$questionCollection->created_by;
      
              if(!$profile_logo){
                $profile_picture = null;
              }

              $Answer_link = Answer::where('id',$questionCollection->id)->pluck('media')->first();
              $Answer_url = url('/api/question').'/'.$questionCollection->id.'/answer';
      
              $questionDetails['id']=$questionCollection->id;
              $questionDetails['question']=$questionCollection->question;
              $userDetails=User::where('id',$questionCollection->created_by)->first();
              $questionDetails['user_id']= @$userDetails->id;
              $questionDetails['user_name']= @$userDetails->firstname.' '.@$userDetails->lastname;
              $questionDetails['category']=Category::where('id',$questionCollection->category_id)->select("id","job_title")->first();
              $questionDetails['emotion']=Emotion::where('id',$questionCollection->emotion_id)->select("id","emotion")->first();
              $questionDetails['questionAssociation']=QuestionAssociation::where('id',$questionCollection->question_association_id)
              ->select("id","question_association")->first();
              $questionDetails['profile_picture']= $profile_picture;
              //$questionDetails['answers']=isset($Answer_link)?$Answer_url:null;
             $responseData['questions_feeds'] = array($questionDetails);
            
          }

      } else if(request()->filter == 3)
      {

          $recentAnswer = Answer::select('question_id')
          ->groupBy('question_id')
          ->orderByRaw('COUNT(*) DESC')
          ->limit(1)
          ->first();

          $questionCollection = Question::where('id',$recentAnswer->question_id)->first();

          if($questionCollection){
            
              $profile_logo = UserProfile::where('user_id',$questionCollection->created_by)->pluck('photo')->first();
              $profile_picture = url('api/user/profile/images').'/'.$questionCollection->created_by;
      
              if(!$profile_logo){
                $profile_picture = null;
              }

              $Answer_link = Answer::where('id',$questionCollection->id)->pluck('media')->first();
              $Answer_url = url('/api/question').'/'.$questionCollection->id.'/answer';
      
              $questionDetails['id']=$questionCollection->id;
              $questionDetails['question']=$questionCollection->question;
              $userDetails=User::where('id',$questionCollection->created_by)->first();
              $questionDetails['user_id']= @$userDetails->id;
              $questionDetails['user_name']= @$userDetails->firstname.' '.@$userDetails->lastname;
              $questionDetails['category']=Category::where('id',$questionCollection->category_id)->select("id","job_title")->first();
              $questionDetails['emotion']=Emotion::where('id',$questionCollection->emotion_id)->select("id","emotion")->first();
              $questionDetails['questionAssociation']=QuestionAssociation::where('id',$questionCollection->question_association_id)
              ->select("id","question_association")->first();
              $questionDetails['profile_picture']= $profile_picture;
              //$questionDetails['answers']=isset($Answer_link)?$Answer_url:null;
              $responseData['questions_feeds'] = array($questionDetails);
            
          }

      
          
      }else{
        $questionCollection=Question::orderBy('created_at',"DESC")->get();
        foreach($questionCollection as $question)
        {
          $profile_logo = UserProfile::where('user_id',$question->created_by)->pluck('photo')->first();
          $profile_picture = url('api/user/profile/images').'/'.$question->created_by;

          if(!$profile_logo){
            $profile_picture = null;
          }
  
          $Answer_link = Answer::where('id',$question->id)->pluck('media')->first();
          $Answer_url = url('/api/question').'/'.$question->id.'/answer';
  
          $questionDetails['id']=$question->id;
          $questionDetails['question']=$question->question;
          $userDetails=User::where('id',$question->created_by)->first();
          $questionDetails['user_id']= @$userDetails->id;
          $questionDetails['user_name']= @$userDetails->firstname.' '.@$userDetails->lastname;
          $questionDetails['category']=Category::where('id',$question->category_id)->select("id","job_title")->first();
          $questionDetails['emotion']=Emotion::where('id',$question->emotion_id)->select("id","emotion")->first();
          $questionDetails['questionAssociation']=QuestionAssociation::where('id',$question->question_association_id)
          ->select("id","question_association")->first();
          $questionDetails['profile_picture']=$profile_picture;
          //$questionDetails['answers']=isset($Answer_link)?$Answer_url:null;
          array_push($responseData['questions_feeds'],$questionDetails);
        }

      }

      $message = "Question feed listed successfully";
      return response()->json(['status' => true,'message' =>$message, 'data' =>  $responseData ], 200);
    }

    public function landingpage()
    {
      if(request()->searchkey)
      {
        $searchkey = request()->searchkey;
        $responseData=[];
      $responseData['questions']=[];
      $questionCollection = Question::where('question', 'LIKE', '%'. $searchkey. '%')->orderBy("created_at","DESC")->get();
      foreach($questionCollection as $question)
      {
        $questionDetails['id']=$question->id;
        $questionDetails['question']=$question->question;
        $questionDetails['link']=url('/api/question').'/'.$question->id.'/answer';
        array_push($responseData['questions'],$questionDetails);
      }

      //23-08-2022
      $emotion_keyword    = Question::where('emotions.emotion',$searchkey)->
                            leftjoin('emotions',"emotions.id","question.emotion_id")->
                            select("emotions.id","emotions.emotion")->first();

      $categories_keyword = Question::where('categories.job_title',$searchkey)->
                            leftjoin('categories',"categories.id","question.category_id")->
                            select("categories.id","categories.job_title")->first();

      $qus_assoc_keyword  = Question::where('question_associations.question_association',$searchkey)->
                            leftjoin('question_associations',"question_associations.id","question.question_association_id")->
                            select("question_associations.id","question_associations.question_association")->first();

      if($emotion_keyword){
        TopKeywords::create(["keywords" => $emotion_keyword->emotion,
                             "keyword_id" => $emotion_keyword->id,
                             "category" => "emotion"]);
      }

      if($categories_keyword){
        TopKeywords::create(["keywords" => $categories_keyword->job_title,
                             "keyword_id" => $categories_keyword->id,
                             "category" => "category"]);
      }

      if($qus_assoc_keyword){
        TopKeywords::create(["keywords" => $qus_assoc_keyword->question_association,
                             "keyword_id" => $qus_assoc_keyword->id,
                             "category" => "question_association"]);
      }
      //23-08-2022

      $responseData['keywords']=[];
      $keywordCollection=TopKeywords::where('keywords', 'LIKE', '%'. $searchkey. '%')->
                         select(array('keywords','keyword_id','category', DB::raw('COUNT(keywords) as user_count')))
                         ->groupBy('keywords')
                         ->orderBy('user_count','DESC')
                         ->limit(8)->get();
      foreach($keywordCollection as $keyword)
      {
        $keyworddetails['id']=$keyword->keyword_id;
        $keyworddetails['keyword']=$keyword->keywords;
        $keyworddetails['keyword_category']=$keyword->category;
        array_push($responseData['keywords'],$keyworddetails);
      }

      $responseData['company']=[];
      $mentorCompanyview=User::where('id',auth()->user()->id)->select('id','userrole_id')->first();
      if($mentorCompanyview->userrole_id == '1')
      {
      $companycollection=Company::where([['user_id',$mentorCompanyview->id],['company_name', 'LIKE', '%'. $searchkey. '%']])->orderBy("created_at","DESC")->get();
      foreach($companycollection as $company)
      {
        $company_logo = Company::where('user_id',$company->user_id)->pluck('logo')->first();
        $company_picture = url('api/company/logo').'/'.$company->id;

        $companyDetails['id']=$company->id;
        $companyDetails['name']=$company->company_name;
        $companyDetails['logo']=isset($company_logo)?$company_picture:null;
        array_push($responseData['company'],$companyDetails);
      }
      } else 
      {
        $menteecompanycollection=Company::where('company_name', 'LIKE', '%'. $searchkey. '%')->orderBy("created_at","DESC")->get();
          foreach($menteecompanycollection as $menteecompany)
          {
            $company_logo = Company::where('user_id',$menteecompany->user_id)->pluck('logo')->first();
            $company_picture = url('api/company/logo').'/'.$menteecompany->id;

            $companyDetails['id']=$menteecompany->id;
            $companyDetails['name']=$menteecompany->company_name;
            $companyDetails['logo']=isset($company_logo)?$company_picture:null;
            array_push($responseData['company'],$companyDetails);
          }
      }
      $message = "success";
      return response()->json(['status' => true ,'message' => $message,'data' => $responseData] ,200);
      } else if(request()->filter == 1)
      {
        $responseData=[];
        $responseData['questions']=[];

        $upvotedQuestion = Upvote::select('question_id')
        ->groupBy('question_id')
        ->orderByRaw('COUNT(*) DESC')
        ->limit(1)
        ->first();


        $recentQuestion = Question::where('id',@$upvotedQuestion->question_id)->first();

        if($recentQuestion){
          $filterQuestionDetails['id']=@$recentQuestion->id;
          $filterQuestionDetails['question']=@$recentQuestion->question;
          $filterQuestionDetails['link']=url('/api/question').'/'.$recentQuestion->id.'/answer';

          array_push($responseData['questions'],$filterQuestionDetails);
        }

        

        $keywordCollection=TopKeywords::select(array('keywords','keyword_id','category', DB::raw('COUNT(keywords) as user_count')))
                          ->groupBy('keywords')
                          ->orderBy('user_count','DESC')
                          ->limit(8)->get();

        $responseData['keywords']=[];
        foreach($keywordCollection as $keyword)
        {
          $keyworddetails['id']=$keyword->keyword_id;
          $keyworddetails['keyword']=$keyword->keywords;
          $keyworddetails['keyword_category']=$keyword->category;
          array_push($responseData['keywords'],$keyworddetails);
        }

      $responseData['company']=[];
      $mentorCompanyview=User::where('id',auth()->user()->id)->select('id','userrole_id')->first();
      if($mentorCompanyview->userrole_id == '1')
      {
        $companycollection=Company::where('user_id',$mentorCompanyview->id)->get();
      foreach($companycollection as $company)
      {
        $company_logo = Company::where('user_id',$company->user_id)->pluck('logo')->first();
        $company_picture = url('api/company/logo').'/'.$company->id;

        $companyDetails['id']=$company->id;
        $companyDetails['name']=$company->company_name;
        $companyDetails['logo']=isset($company_logo)?$company_picture:null;
        array_push($responseData['company'],$companyDetails);
      }
      } else 
      {
        $menteecompanycollection=Company::get();
          foreach($menteecompanycollection as $menteecompany)
          {
            $company_logo = Company::where('user_id',$menteecompany->user_id)->pluck('logo')->first();
            $company_picture = url('api/company/logo').'/'.$menteecompany->id;

            $companyDetails['id']=$menteecompany->id;
            $companyDetails['name']=$menteecompany->company_name;
            $companyDetails['logo']=isset($company_logo)?$company_picture:null;
            array_push($responseData['company'],$companyDetails);
          }
      }
      $message = "success";
      return response()->json(['status' => true ,'message' => $message,'data' => $responseData] ,200);


        

        return response()->json(['status' => true, 'message'=> "Data retrieved successfully", 'data'=>$filterQuestionDetails], 200);
      } else if(request()->filter== 2)
      {
        $responseData=[];
        $responseData['questions']=[];

        $recentAddedQuestion = Question::select('question','id')->orderBy('id', 'DESC')->first();
        $filterDetails['id']=$recentAddedQuestion->id;
        $filterDetails['question']=$recentAddedQuestion->question;
        $filterDetails['link']=url('/api/question').'/'.$recentAddedQuestion->id.'/answer';

        array_push($responseData['questions'],$filterDetails);

        $keywordCollection=TopKeywords::select(array('keywords','keyword_id','category', DB::raw('COUNT(keywords) as user_count')))
        ->groupBy('keywords')
        ->orderBy('user_count','DESC')
        ->limit(8)->get();

        $responseData['keywords']=[];
        
        foreach($keywordCollection as $keyword)
        {
        $keyworddetails['id']=$keyword->keyword_id;
        $keyworddetails['keyword']=$keyword->keywords;
        $keyworddetails['keyword_category']=$keyword->category;
        array_push($responseData['keywords'],$keyworddetails);
        }

      $responseData['company']=[];
      $mentorCompanyview=User::where('id',auth()->user()->id)->select('id','userrole_id')->first();
      if($mentorCompanyview->userrole_id == '1')
      {
        $companycollection=Company::where('user_id',$mentorCompanyview->id)->get();
      foreach($companycollection as $company)
      {
        $company_logo = Company::where('user_id',$company->user_id)->pluck('logo')->first();
        $company_picture = url('api/company/logo').'/'.$company->id;

        $companyDetails['id']=$company->id;
        $companyDetails['name']=$company->company_name;
        $companyDetails['logo']=isset($company_logo)?$company_picture:null;
        array_push($responseData['company'],$companyDetails);
      }
      } else 
      {
        $menteecompanycollection=Company::get();
          foreach($menteecompanycollection as $menteecompany)
          {
            $company_logo = Company::where('user_id',$menteecompany->user_id)->pluck('logo')->first();
            $company_picture = url('api/company/logo').'/'.$menteecompany->id;

            $companyDetails['id']=$menteecompany->id;
            $companyDetails['name']=$menteecompany->company_name;
            $companyDetails['logo']=isset($company_logo)?$company_picture:null;
            array_push($responseData['company'],$companyDetails);
          }
      }
      $message = "success";
      return response()->json(['status' => true ,'message' => $message,'data' => $responseData] ,200);
      } else if(request()->filter == 3)
      {
        $responseData=[];
        $responseData['questions']=[];

        $recentAnswer = Answer::select('question_id')
        ->groupBy('question_id')
        ->orderByRaw('COUNT(*) DESC')
        ->limit(1)
        ->first();

      $recentAnsweredQuestion = Question::where('id',$recentAnswer->question_id)->first();
        $filterAnswerDetails['id']=$recentAnsweredQuestion->id;
        $filterAnswerDetails['question']=$recentAnsweredQuestion->question;
        $filterAnswerDetails['link']=url('/api/question').'/'.$recentAnsweredQuestion->id.'/answer';
        array_push($responseData['questions'],$filterAnswerDetails);

      $keywordCollection=TopKeywords::select(array('keywords','keyword_id','category', DB::raw('COUNT(keywords) as user_count')))
                          ->groupBy('keywords')
                          ->orderBy('user_count','DESC')
                          ->limit(8)->get();

        $responseData['keywords']=[];
        
        foreach($keywordCollection as $keyword)
        {
          $keyworddetails['id']=$keyword->keyword_id;
          $keyworddetails['keyword']=$keyword->keywords;
          $keyworddetails['keyword_category']=$keyword->category;
          array_push($responseData['keywords'],$keyworddetails);
        }

      $responseData['company']=[];
      $mentorCompanyview=User::where('id',auth()->user()->id)->select('id','userrole_id')->first();
      if($mentorCompanyview->userrole_id == '1')
      {
        $companycollection=Company::where('user_id',$mentorCompanyview->id)->get();
      foreach($companycollection as $company)
      {
        $company_logo = Company::where('user_id',$company->user_id)->pluck('logo')->first();
        $company_picture = url('api/company/logo').'/'.$company->id;

        $companyDetails['id']=$company->id;
        $companyDetails['name']=$company->company_name;
        $companyDetails['logo']=isset($company_logo)?$company_picture:null;
        array_push($responseData['company'],$companyDetails);
      }
      } else 
      {
        $menteecompanycollection=Company::get();
          foreach($menteecompanycollection as $menteecompany)
          {
            $company_logo = Company::where('user_id',$menteecompany->user_id)->pluck('logo')->first();
            $company_picture = url('api/company/logo').'/'.$menteecompany->id;

            $companyDetails['id']=$menteecompany->id;
            $companyDetails['name']=$menteecompany->company_name;
            $companyDetails['logo']=isset($company_logo)?$company_picture:null;
            array_push($responseData['company'],$companyDetails);
          }
      }
      $message = "success";
      return response()->json(['status' => true ,'message' => $message,'data' => $responseData] ,200);
      } else
      {
      $responseData=[];
      $responseData['questions']=[];
      $questionCollection=Question::orderBy("created_at","DESC")->get();
      foreach($questionCollection as $question)
      {
        $questionDetails['id']=$question->id;
        $questionDetails['question']=$question->question;
        $questionDetails['link']=url('/api/question').'/'.$question->id.'/answer';
        array_push($responseData['questions'],$questionDetails);
      }

      $keywordCollection=TopKeywords::select(array('keywords','keyword_id','category', DB::raw('COUNT(keywords) as user_count')))
                          ->groupBy('keywords')
                          ->orderBy('user_count','DESC')
                          ->limit(8)->get();

        $responseData['keywords']=[];
        
        foreach($keywordCollection as $keyword)
        {
          $keyworddetails['id']=$keyword->keyword_id;
          $keyworddetails['keyword']=$keyword->keywords;
          $keyworddetails['keyword_category']=$keyword->category;
          array_push($responseData['keywords'],$keyworddetails);
        }

      $responseData['company']=[];
      $mentorCompanyview=User::where('id',auth()->user()->id)->select('id','userrole_id')->first();
      if($mentorCompanyview->userrole_id == '1')
      {
        $companycollection=Company::where('user_id',$mentorCompanyview->id)->get();
      foreach($companycollection as $company)
      {
        $company_logo = Company::where('user_id',$company->user_id)->pluck('logo')->first();
        $company_picture = url('api/company/logo').'/'.$company->id;

        $companyDetails['id']=$company->id;
        $companyDetails['name']=$company->company_name;
        $companyDetails['logo']=isset($company_logo)?$company_picture:null;
        array_push($responseData['company'],$companyDetails);
      }
      } else 
      {
        $menteecompanycollection=Company::get();
          foreach($menteecompanycollection as $menteecompany)
          {
            $company_logo = Company::where('user_id',$menteecompany->user_id)->pluck('logo')->first();
            $company_picture = url('api/company/logo').'/'.$menteecompany->id;

            $companyDetails['id']=$menteecompany->id;
            $companyDetails['name']=$menteecompany->company_name;
            $companyDetails['logo']=isset($company_logo)?$company_picture:null;
            array_push($responseData['company'],$companyDetails);
          }
      }
      $message = "success";
      return response()->json(['status' => true ,'message' => $message,'data' => $responseData] ,200);
    }
  }

    public function getAnswersForQuestions()
    {
     $responseData = [];
     $responseData['questions_with_answers']=[];
     $questionCollection=Question::get();
     foreach($questionCollection as $question)
     {
      $profile_logo = UserProfile::where('user_id',$question->created_by)->pluck('photo')->first();
      $profile_picture = url('api/user/profile/images').'/'.$question->created_by;

      $saved_question =  Savedanswer::where([["question_id",$question->id],["saved_by",Auth::user()->id]])->select('status')->first();

      if(@$saved_question->status){
        $question_status = $saved_question->status;
      }else{
        $question_status = "Unsave";
      }

      $userDetails=User::where('id',$question->created_by)->first();
      $questionDetails['user_name']= @$userDetails->firstname.' '.@$userDetails->lastname;
      $questionDetails['question_id']=$question->id;
      $questionDetails['question']=$question->question;
      $questionDetails['question_status']=$question_status;
      $questionDetails['created_by']=$question->created_by;
      $questionDetails['profile_logo']=isset($profile_logo)?$profile_picture:null;

      $categoryDetails = Category::where('id',$question->category_id)->pluck('job_title')->first();
      $questionDetails['category_id'] =$question->category_id;
      $questionDetails['job_title'] = $categoryDetails;

      $emotionDetails = Emotion::where('id',$question->emotion_id)->pluck('emotion')->first();
      $questionDetails['emotion_id'] =$question->emotion_id;
      $questionDetails['emotion'] = $emotionDetails;

      $associationDetails = QuestionAssociation::where('id',$question->question_association_id)->pluck('question_association')->first();
      $questionDetails['question_association_id'] =$question->question_association_id;
      $questionDetails['question_association'] = $associationDetails;

      $answerCollections = Answer::where('question_id',$question->id)->orderBy('created_at',"DESC")->get();
      $answerDetails=[];
      $questionDetails['answer']=[];

      //answer count
      $answer_cnt = 0;
      //answer count

      foreach($answerCollections as $answer)
      {

        $profile_logo = UserProfile::where('user_id',$answer->answer_by)->pluck('photo')->first();
        $profile_picture = url('api/user/profile/images').'/'.$answer->answer_by;

        $answerDetails['answer_id'] = $answer->id;
        $userDetails=User::where('id',$answer->answer_by)->first();
        $answerDetails['user_id']=$answer->answer_by;
        $answerDetails['answer_by']=@$userDetails->firstname.' '.@$userDetails->lastname;
        $answerDetails['profile_logo']=isset($profile_logo)?$profile_picture:null;
        //$answerDetails['answer']=url('api/answer/media').'/'.$answer->id;
        $s3 = Storage::disk('s3')->getAdapter()->getClient();
        $answerDetails['answer']=$s3->getObjectUrl( env('AWS_BUCKET'), 'media/'.$answer->media );
        $answerDetails['media_type']=$answer->media_type_id;
        $answerDetails['comments']=$answer->comments;
        $answerDetails['created_at']=$answer->created_at;
        $answerDetails['shared_video_url']= asset('video-url/'.$answer->id);
        

        $reactionDetails=[];
        $answerDetails['reaction']=[];

        $reaction_counts = UserReaction::where('answer_id',$answer->id)->get();

        $like = 0;
        $heart = 0;
        $smiley = 0;
        $clap = 0;
        $brilliant =0;
        $answer_cnt++;

        foreach($reaction_counts as $reaction)
        {
          if($reaction->reaction_id == 1){
            $like++;
          }
          elseif($reaction->reaction_id == 2){
            $heart++;
          }elseif($reaction->reaction_id == 3){
            $smiley++;
          }elseif($reaction->reaction_id == 4){
            $clap++;
          }elseif($reaction->reaction_id == 5){
            $brilliant++;
          }
        }
          $reactionDetails['like'] = $like;
          $reactionDetails['heart'] = $heart;
          $reactionDetails['smiley'] = $smiley;
          $reactionDetails['clap'] = $clap;
          $reactionDetails['brilliant'] = $brilliant;

          //reaction for particular user 
          $reaction_for_user = UserReaction::where([["reaction_by",Auth::user()->id],["answer_id",$answer->id]])->select("reaction_id")->first() ;

          $user_like = 0;
          $user_heart = 0;
          $user_smiley = 0;
          $user_clap = 0;
          $user_brilliant =0;

          if($reaction_for_user){

            if($reaction_for_user->reaction_id == 1){
              $user_like = 1;
            }elseif($reaction_for_user->reaction_id == 2){
              $user_heart = 1;
            }elseif($reaction_for_user->reaction_id == 3){
              $user_smiley = 1;
            }elseif($reaction_for_user->reaction_id == 4){
              $user_clap = 1;
            }elseif($reaction_for_user->reaction_id == 5){
              $user_brilliant = 1;
            }
          }

          $userReactionDetails = array();
          $userReactionDetails['user_like']      = $user_like; 
          $userReactionDetails['user_heart']     = $user_heart;
          $userReactionDetails['user_smiley']    = $user_smiley;
          $userReactionDetails['user_clap']      = $user_clap;
          $userReactionDetails['user_brilliant'] = $user_brilliant;

          
          $answerDetails['user_reaction'] = $userReactionDetails;
          
          //reaction for particular user

          
          $answerDetails['reaction'] = $reactionDetails;
          //array_push($answerDetails['reaction'],$reactionDetails);
          array_push($questionDetails['answer'],$answerDetails);
      }
          
          $questionDetails["answer_count"] = $answer_cnt;
          array_push($responseData['questions_with_answers'],$questionDetails);
    }

    $message = "Data retrieved successfully.";
    return response()->json(['status' => true ,'message' => $message,'data' => $responseData] ,200);
  }

  public function leaderBoard()
  {
    $responseData=[];

    $responseData['mentor']=[];
    $mentors=User::leftjoin('ranking_lists','ranking_lists.user_id','=','users.id')
      ->where('userrole_id','=','1')
      ->select('users.id')
      ->groupBy('users.id')
      ->orderByRaw('SUM(ranking_lists.points) DESC')
      ->limit(10)
      ->get();
    $rankcount = count($mentors);
    $rankcount = 1;
    foreach($mentors as $mentor)
    {
      $mentorname = User::where('id',$mentor->id)->first();
      $mentorprofile = UserProfile::where('user_id',$mentor->id)->pluck('photo')->first();
      $mentor_profile_logo = url('api/user/profile/images').'/'.$mentor->id;

      $mentorDetails['user_id']=$mentor->id;
      $mentorDetails['profile_logo']=isset($mentorprofile)?$mentor_profile_logo:null;
      $mentorDetails['name']=$mentorname->firstname.' '.$mentorname->lastname;

      $rankinglist=DB::table('ranking_lists')->where('user_id', '=', $mentor->id)->sum('points');
      if($rankinglist && $rankcount < 4)
      {
        $rank = $rankcount++;
      }
      else
      {
        $rank = 0;
      }

      $mentorDetails['points']=$rankinglist;
      $mentorDetails['ranking']=$rank;
      array_push($responseData['mentor'],$mentorDetails);
    }
    
    $responseData['mentee']=[];
    $mentees=User::leftjoin('ranking_lists','ranking_lists.user_id','=','users.id')
    ->where('userrole_id','=','2')
    ->select('users.id')
    ->groupBy('users.id')
    ->orderByRaw('SUM(ranking_lists.points) DESC')
    ->limit(10)
    ->get();
    $ranking = count($mentees);
    $ranking = 1;

    foreach($mentees as $mentee)
    {
      $menteename = User::where('id',$mentee->id)->first();
      $menteeprofile = UserProfile::where('user_id',$mentee->id)->pluck('photo')->first();
      $mentee_profile_logo = url('api/user/profile/images').'/'.$mentee->id;

      $menteeDetails['user_id']=$mentee->id;
      $menteeDetails['profile_logo']=isset($menteeprofile)?$mentee_profile_logo:null;
      $menteeDetails['name']=$menteename->firstname.' '.$menteename->lastname;

      $menteerankinglist=DB::table('ranking_lists')->where('user_id', '=', $mentee->id)->sum('points');
      if($menteerankinglist && $ranking < 4)
      {
        $menteeRank = $ranking++;
      }
      else{
        $menteeRank = 0;
      }

      $menteeDetails['points']=$menteerankinglist;
      $menteeDetails['ranking']=$menteeRank;
      array_push($responseData['mentee'],$menteeDetails);
    }

    $message = "success";
    return response()->json(['status' => true, 'message'=> $message, 'data'=>$responseData], 200);
  }

  public function search($question)
  {
    $responseData=[];
    $results = Question::where('question', 'LIKE', '%'. $question. '%')->select('question','id')->orderBy("created_at","DESC")->get();
    foreach($results as $result)
    {
      $searchDetails['id'] = $result->id;
      $searchDetails['question'] = $result->question;
      $searchDetails['link'] = url('api/question').'/'.$result->id.'/answer';
      array_push($responseData,$searchDetails);
    }
    if(count($results))
    {
      $message = "success";
      return Response()->json(['status' => true, 'message' =>$message,'data'=> $responseData]);
    }
    else
    {
      return response()->json(['status' => false,'message' => 'No Data not found'], 404);
    }
  }

  public function viewAnswer($id)
  {
    $responseData = [];
    $responseData['question_answer']=[];
    $questionCollection=Question::where('id',$id)->pluck('question')->first();
    $userDetails=User::where('id',$id)->first();
    $questionDetails['question']=$questionCollection;
    $answerCollections = Answer::where('question_id',$id)->orderBy("created_at","DESC")->get();
    $answerDetails=[];
    $questionDetails['answer_list']=[];

    $answer_cnt = 0;

    foreach($answerCollections as $answer)
    {
      $profile_logo = UserProfile::where('user_id',$answer->answer_by)->pluck('photo')->first();
      $profile_picture = url('api/user/profile/images').'/'.$answer->answer_by;

      $userDetails=User::where('id',$answer->answer_by)->first();
      $answerDetails['user_id']=$answer->answer_by;
      $answerDetails['answer_by']= @$userDetails->firstname.' '.@$userDetails->lastname;
      //$answerDetails['media']=url('api/answer/media').'/'.$answer->id;
      $s3 = Storage::disk('s3')->getAdapter()->getClient();
      $answerDetails['media']=$s3->getObjectUrl( env('AWS_BUCKET'), 'media/'.$answer->media );
      $answerDetails['media_type']=$answer->media_type_id;
      $answerDetails['comments']=$answer->comments;
      $answerDetails['created_at']=$answer->created_at;
      $answerDetails['profile_logo']=isset($profile_logo)?$profile_picture:null;
      $answer_cnt++;

      array_push($questionDetails['answer_list'],$answerDetails);
    }
      $questionDetails["answer_count"] = $answer_cnt;
      $responseData['question_answer']=$questionDetails;

    $message = "Successfully Answer Listed";
    return response()->json(['message' => $message, 'data' =>  $responseData ], 200);
  }

    public function upVote(UpvoteRequest $request)
    {
        $upvote = UpVote::where('question_id',$request->question_id)->where('upvote_by',Auth::user()->id)->pluck('id')
       ->first();

        if($upvote){
            $result = UpVote::where('id',$upvote)->delete();

            $data = UpVote::where('id',$upvote)->get();

            
            $responseData['status']=true;
            $responseData['message'] = "Downvote Successfully";
            
        }else {
            $upvote_by = Upvote::create([
              'question_id' => $request->question_id,
              'upvote_by' => Auth::user()->id,
              'status' => '1'
            ]);

            $responseData['status']=true;
            $responseData['message'] = "Upvote Successfully";

        }
        return response()->json($responseData);
    }

    public function Reaction(ReactionRequest $request)
    {

      $reaction_list = UserReaction::where([["reaction_by",Auth::user()->id],["answer_id",$request->answer_id]])->first() ;

      if($reaction_list){

        $reaction_exist = UserReaction::where([["reaction_by",Auth::user()->id],["answer_id",$request->answer_id],
                          ["reaction_id",$request->reaction_id]])->first() ;
        if($reaction_exist){
          $reaction_delete = UserReaction::where([["reaction_by",Auth::user()->id],["answer_id",$request->answer_id],
                            ["reaction_id",$request->reaction_id]]);

          $reaction_delete->delete();

          $responseData['message'] = "Reactions Removed Successfully";
        }else{
          $reaction = UserReaction::where([["reaction_by",Auth::user()->id],
                                        ["answer_id",$request->answer_id]])
                                        ->update(["reaction_id" => $request->reaction_id ]);

          self::reactionNotification($request->reaction_id,$request->answer_id);

          $responseData['message'] = "Reactions Updated Successfully";
        }
       
      }else{
        $reaction = UserReaction::create([
          'reaction_by' => Auth::user()->id,
          'answer_id' => $request->answer_id,
          'reaction_id' => $request->reaction_id
        ]); 

        self::reactionNotification($request->reaction_id,$request->answer_id);

        $responseData['message'] = "Reactions Created Successfully";

      }

      $responseData['status']=true;
      
      
      return response()->json($responseData);
    }

    public function audio()
    {

    }

    public function answer_report(){
        $responseData = array();

        $Videoreportcontent_details =Videoreportcontent::select('id', 'report_content')->get();

        if($Videoreportcontent_details){

          $responseData["status"] = true;
          $responseData["contents"] = $Videoreportcontent_details;
          $responseData["response"] = "Report Send Successfully";
        }else{
          $responseData["status"] = false;
          $responseData["response"] = "No Record Found";
        }

        return response()->json($responseData);
    }

    function answerReportSave($request){
      $report_content = $request->report_content;
      $comments       = $request->comments;
      $answer_id      = @$request->answer_id;
      $post_id        = @$request->post_id;

      $anwer_details =Answer::where([['id',$answer_id]])->select('answer_by', 'question_id')->first();
      $post_details  =Post::where([['id',$post_id]])->select('posted_by_id', 'post_type_id')->first();
      $Videoreportcontent_details =Videoreportcontent::where('id', $report_content)->first();

      if(@$Videoreportcontent_details->id && $comments && (@$anwer_details->answer_by || @$post_details->posted_by_id) ){ 

        if(@$anwer_details->answer_by){
          $question_id = @$anwer_details->question_id;
          $answer_by   = @$anwer_details->answer_by;

          $res = Videoreport::create([
              'report_content' => $report_content,
              'comments' => $comments,
              'answer_by' => $answer_by,
              'answer_id' => $answer_id,
              'question_id' => $question_id,
              'report_by' => Auth::user()->id,
          ]);
        }elseif(@$post_details->posted_by_id){
          $posted_by_id = @$post_details->posted_by_id;
          $post_type_id = @$post_details->post_type_id;

            $res = Postreport::create([
                'report_content' => $report_content,
                'comments' => $comments,
                'post_by' => $posted_by_id,
                'post_id' => $post_id,
                'post_type' => $post_type_id,
                'report_by' => Auth::user()->id,
            ]);
        }

        
        if(@$res->id){
          $responseData["status"] = true;
          $responseData["response"] = "Report Update Successfully";
        }else{
          $responseData["status"] = false;
          $responseData["response"] = "Report Update Failed";
        }
      }else{

        if($post_id || $answer_id ){
          $responseData["status"] = false;
          
          $responseData["response"] = "Please Choose Comments (or) Valid Report  Content";
        }else{
          $responseData["status"] = false;
          $responseData["response"] = "Post ID or Answer ID required";
        }
      }
      return response()->json($responseData);
    }

    //shared media
    public function sharedMedia($request){
        $responseData = array();

        $answer_id = $request->answer_id;
        $media_url = $request->media_url;
        $user_id   = Auth::user()->id; 

        if($answer_id && $media_url){

          $shared_media = Sharedmedia::create([
            "answer_id" => $answer_id,
            "shared_by" => $user_id,
            'media' => $media_url
          ]);

          $responseData["status"]   = true;
          $responseData["data"]     = $shared_media;
          $responseData["response"] = "Media Shared Successfully";

        }else{
          $responseData["status"] = false;
          $responseData["response"] = "Media URL and Answer ID are required";
        }

        return response()->json($responseData);
    }
    //shared media

    public function savedQuestion($request){
        
      $question_id = $request->question_id;
      Auth::user()->id;
      $status = 'Save';

      if($question_id){

        $saved_question   = Savedanswer::where([["question_id",$question_id],["saved_by",Auth::user()->id],["status",$status]])->first();

        $unsaved_question = Savedanswer::where([["question_id",$question_id],["saved_by",Auth::user()->id],["status","Unsave"]])->first();

        if($saved_question){
          $res = Savedanswer::where([["question_id",$question_id],["saved_by",Auth::user()->id]])->update(['status' => 'Unsave']);
          $result = Savedanswer::where([["question_id",$question_id],["saved_by",Auth::user()->id]])->first();

          $responsedData["status"] = true;
          $responsedData["saved_questions"] = $result;
          $responsedData["response"] = "Question Unsaved Successfully";
        }elseif($unsaved_question){
          $res = Savedanswer::where([["question_id",$question_id],["saved_by",Auth::user()->id]])->update(['status' => $status]);
          $result = Savedanswer::where([["question_id",$question_id],["saved_by",Auth::user()->id]])->first();

          $responsedData["status"] = true;
          $responsedData["saved_questions"] = $result;
          $responsedData["response"] = "Question Saved Successfully";
        }else{
          $res = Savedanswer::create([
                  "question_id" => $question_id,
                  "saved_by" => Auth::user()->id,
                  "status" => $status 
                ]);

          $result = $res;

          $responsedData["status"] = true;
          $responsedData["saved_questions"] = $result;
          $responsedData["response"] = "Question Saved Successfully";
        }

        
      }else{
        $responsedData["status"] = false;
        $responsedData["response"] = "Question ID is required";  
      }

      return response()->json($responsedData);

    }

    public function savedQuestionList(){
        
      $saved_question   = Savedanswer::where([["saved_by",Auth::user()->id],["status","Save"]])->
                          leftjoin("question","question.id","savedanswers.question_id")->
                          select('savedanswers.question_id','question.question')->orderBy('savedanswers.created_at',"DESC")->get();


      $responsedData["status"] = true;
      $responsedData["questionList"] = $saved_question;
      
      return response()->json($responsedData);

    }

    public function keywordSearch($request){
        
      $responsedData = array();

      if(@$request->category == "emotion" && @$request->keyword_id){

        $saved_question   = Question::where("emotion_id",$request->keyword_id)->get();

        $responsedData["status"] = true;
        $responsedData["keyword_questionList"] = $saved_question;
        $responsedData["message"] = "QuestionList Showed Successfully";
      }elseif(@$request->category == "question_association" && @$request->keyword_id){
        $saved_question   = Question::where("question_association_id",$request->keyword_id)->get();

        $responsedData["status"] = true;
        $responsedData["keyword_questionList"] = $saved_question;
        $responsedData["message"] = "QuestionList Showed Successfully";
      }elseif(@$request->category == "category" && @$request->keyword_id){
        $saved_question   = Question::where("category_id",$request->keyword_id)->get();

        $responsedData["status"] = true;
        $responsedData["keyword_questionList"] = $saved_question;
        $responsedData["message"] = "QuestionList Showed Successfully";
      }else{
        $responsedData["status"] = false;
        $responsedData["keyword_questionList"] = [];
        $responsedData["message"] = "Keyword ID required & Category Required"; 
      }
      
      return response()->json($responsedData);

    }

public function landingpageQuestionList()
{
      
}
}