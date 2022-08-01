<?php

namespace App\Repositories;

use File;
use App\Models\User;
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
use Illuminate\Support\Facades\DB;
use App\Models\QuestionAssociation;
use App\Http\Requests\UpvoteRequest;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\QuestionInterface;
use App\Http\Requests\QuestionRequest;
use App\Http\Requests\ReactionRequest;

class QuestionRepository implements QuestionInterface
{
    use ResponseAPI;

    public function getQuestionAnswer(QuestionRequest $request)
    {
      DB::beginTransaction();
      
      $question = Question::create([
        'question' => $request->question,
        'created_by'=> Auth::user()->id,
        'category_id' => $request->category_id,
        'emotion_id' => $request->emotion_id,
        'question_association_id'=> $request->question_association_id
      ]);

      if($question)
      {
          $points = RankingList::create([
              'user_id' => Auth::user()->id,
              'points' => 15,
              'reasons' => "Question",
          ]);
      }
      
      DB::commit();
      $data['question'] = $request->question;
      $data['user_id'] = Auth::user()->id;
      $data['category_id'] = $request->category_id;
      $data['emotion_id'] = $request->emotion_id;
      $data['question_association'] = $request->question_association_id;

      $message = "Question Stored Successfully";
      return response()->json(['status' => true, 'message' =>  $message ], 200);
    }

    public function questionFeed()
    {
      $responseData=[];
      $responseData['questions_feeds']=[];
      $questionCollection=Question::get();
      foreach($questionCollection as $question)
      {
        $profile_logo = UserProfile::where('id',$question->id)->pluck('photo')->first();
        $profile_picture = url('api/user/profile/images').'/'.$question->created_by;

        $Answer_link = Answer::where('id',$question->id)->pluck('media')->first();
        $Answer_url = url('/api/question').'/'.$question->id.'/answer';

        $questionDetails['id']=$question->id;
        $questionDetails['question']=$question->question;
        $userDetails=User::where('id',$question->created_by)->first();
        $questionDetails['user_id']=$userDetails->id;
        $questionDetails['user_name']=$userDetails->firstname.' '.$userDetails->lastname;
        $questionDetails['category']=Category::where('id',$question->category_id)->pluck('job_title')->first();
        $questionDetails['emotion']=Emotion::where('id',$question->emotion_id)->pluck('emotion')->first();
        $questionDetails['questionAssociation']=QuestionAssociation::where('id',$question->question_association_id)
        ->pluck('question_association')->first();
        $questionDetails['profile_picture']=isset($profile_logo)?$profile_picture:null;
        //$questionDetails['answers']=isset($Answer_link)?$Answer_url:null;
        array_push($responseData['questions_feeds'],$questionDetails);
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
      $questionCollection = Question::where('question', 'LIKE', '%'. $searchkey. '%')->get();
      foreach($questionCollection as $question)
      {
        $questionDetails['id']=$question->id;
        $questionDetails['question']=$question->question;
        $questionDetails['link']=url('/api/question').'/'.$question->id.'/answer';
        array_push($responseData['questions'],$questionDetails);
      }

      $responseData['keywords']=[];
      $keywordCollection=TopKeywords::where('keywords', 'LIKE', '%'. $searchkey. '%')->get();
      foreach($keywordCollection as $keyword)
      {
        $keyworddetails['id']=$keyword->id;
        $keyworddetails['keyword']=$keyword->keywords;
        array_push($responseData['keywords'],$keyworddetails);
      }

      $responseData['company']=[];
      $mentorCompanyview=User::where('id',auth()->user()->id)->select('id','userrole_id')->first();
      if($mentorCompanyview->userrole_id == '1')
      {
      $companycollection=Company::where([['user_id',$mentorCompanyview->id],['company_name', 'LIKE', '%'. $searchkey. '%']])->get();
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
        $menteecompanycollection=Company::where('company_name', 'LIKE', '%'. $searchkey. '%')->get();
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

        $recentQuestion = Question::where('id',$upvotedQuestion->question_id)->first();
        $filterQuestionDetails['id']=$recentQuestion->id;
        $filterQuestionDetails['question']=$recentQuestion->question;
        $filterQuestionDetails['link']=url('/api/question').'/'.$recentQuestion->id.'/answer';

        array_push($responseData['questions'],$filterQuestionDetails);

      $responseData['keywords']=[];
      $keywordCollection=TopKeywords::get();
      foreach($keywordCollection as $keyword)
      {
        $keyworddetails['id']=$keyword->id;
        $keyworddetails['keyword']=$keyword->keywords;
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

      $responseData['keywords']=[];
      $keywordCollection=TopKeywords::get();
      foreach($keywordCollection as $keyword)
      {
        $keyworddetails['id']=$keyword->id;
        $keyworddetails['keyword']=$keyword->keywords;
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

      $responseData['keywords']=[];
      $keywordCollection=TopKeywords::get();
      foreach($keywordCollection as $keyword)
      {
        $keyworddetails['id']=$keyword->id;
        $keyworddetails['keyword']=$keyword->keywords;
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
      $questionCollection=Question::get();
      foreach($questionCollection as $question)
      {
        $questionDetails['id']=$question->id;
        $questionDetails['question']=$question->question;
        $questionDetails['link']=url('/api/question').'/'.$question->id.'/answer';
        array_push($responseData['questions'],$questionDetails);
      }

      $responseData['keywords']=[];
      $keywordCollection=TopKeywords::get();
      foreach($keywordCollection as $keyword)
      {
        $keyworddetails['id']=$keyword->id;
        $keyworddetails['keyword']=$keyword->keywords;
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

      $userDetails=User::where('id',$question->created_by)->first();
      $questionDetails['user_name']=$userDetails->firstname.' '.$userDetails->lastname;
      $questionDetails['question_id']=$question->id;
      $questionDetails['question']=$question->question;
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

      $answerCollections = Answer::where('question_id',$question->id)->get();
      $answerDetails=[];
      $questionDetails['answer']=[];
      foreach($answerCollections as $answer)
      {
        $profile_logo = UserProfile::where('user_id',$answer->answer_by)->pluck('photo')->first();
        $profile_picture = url('api/user/profile/images').'/'.$answer->answer_by;

        $answerDetails['answer_id'] = $answer->id;
        $userDetails=User::where('id',$answer->answer_by)->first();
        $answerDetails['user_id']=$answer->answer_by;
        $answerDetails['answer_by']=$userDetails->firstname.' '.$userDetails->lastname;
        $answerDetails['profile_logo']=isset($profile_logo)?$profile_picture:null;
        $answerDetails['answer']=url('api/answer/media').'/'.$answer->id;
        $answerDetails['media_type']=$answer->media_type_id;
        $answerDetails['comments']=$answer->comments;
        $answerDetails['created_at']=$answer->created_at;

        $reactionDetails=[];
        $answerDetails['reaction']=[];

        $reaction_counts = UserReaction::where('answer_id',$answer->id)->get();

        $like = 0;
        $heart = 0;
        $smiley = 0;
        $clap = 0;
        $brilliant =0;

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

          array_push($answerDetails['reaction'],$reactionDetails);
          array_push($questionDetails['answer'],$answerDetails);
      }
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
    $results = Question::where('question', 'LIKE', '%'. $question. '%')->select('question','id')->get();
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
    $answerCollections = Answer::where('question_id',$id)->get();
    $answerDetails=[];
    $questionDetails['answer_list']=[];
    foreach($answerCollections as $answer)
    {
      $profile_logo = UserProfile::where('user_id',$answer->answer_by)->pluck('photo')->first();
      $profile_picture = url('api/user/profile/images').'/'.$answer->answer_by;

      $userDetails=User::where('id',$answer->answer_by)->first();
      $answerDetails['user_id']=$answer->answer_by;
      $answerDetails['answer_by']=$userDetails->firstname.' '.$userDetails->lastname;
      $answerDetails['media']=url('api/answer/media').'/'.$answer->id;
      $answerDetails['media_type']=$answer->media_type_id;
      $answerDetails['comments']=$answer->comments;
      $answerDetails['created_at']=$answer->created_at;
      $answerDetails['profile_logo']=isset($profile_logo)?$profile_picture:null;
      array_push($questionDetails['answer_list'],$answerDetails);
    }

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
            $responseData['status']=true;
            $responseData['message'] = "Downvote Successfully";
            return response()->json($responseData);
        }else {
            $upvote_by = Upvote::create([
              'question_id' => $request->question_id,
              'upvote_by' => Auth::user()->id,
              'status' => '1'
            ]);

            $responseData['status']=true;
            $responseData['message'] = "Upvote Successfully";

            $data = array(
              "question_id" => $upvote_by['question_id'],
              "upvote_by" => $upvote_by['upvote_by'],
              "status" => $upvote_by['status']
            );
            $responseData['data']=$data;
        }
        return response()->json($responseData);
    }

    public function Reaction(ReactionRequest $request)
    {
      $reaction = UserReaction::updateorcreate([
        'reaction_by' => Auth::user()->id,'answer_id' => $request->answer_id
      ],
      [
        'reaction_id' => $request->reaction_id
      ]);

      $responseData['status']=true;
      $responseData['message'] = "Reactions Created Successfully";
      $data = array(
        "answer_id" => $reaction['answer_id'],
        "reaction_id" => $reaction['reaction_id'],
        "reaction_by" => $reaction['reaction_by']
      );

      $responseData['data']=$data;
      return response()->json($responseData);
    }

    public function audio()
    {

    }
}