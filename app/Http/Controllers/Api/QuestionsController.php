<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnswerRequest;

use Illuminate\Http\Request;
use App\Http\Requests\QuestionRequest;
use App\Http\Requests\ReactionRequest;
use App\Interfaces\AnswerInterface;
use App\Interfaces\QuestionInterface;
use App\Http\Requests\UpvoteRequest;

  class QuestionsController extends Controller
  {
    protected $QuestionInterface;
    protected $AnswerInterface;

    public function __construct(QuestionInterface $QuestionInterface,AnswerInterface $AnswerInterface)
    {
        $this->QuestionInterface = $QuestionInterface;
        $this->AnswerInterface = $AnswerInterface;
    }

    public function getQuestionAnswer(QuestionRequest $request)
    {
     return $this->QuestionInterface->getQuestionAnswer($request);
     }

    public function questionFeed()
    {
      return $this->QuestionInterface->questionFeed();
    }

    public function landingpage()
    {
      return $this->QuestionInterface->landingpage();
    }

    public function getAnswersForQuestions()
    {
      return $this->QuestionInterface->getAnswersForQuestions();
    }

  public function answerforquestions(AnswerRequest $request)
  {
    return $this->AnswerInterface->answerforquestions($request);
  }

  public function leaderBoard()
  {
    return $this->QuestionInterface->leaderBoard();
  }

  public function search($question)
  {
    return $this->QuestionInterface->search($question);
  }

  public function viewAnswer($id)
  {
    return $this->QuestionInterface->viewAnswer($id);
  }

  public function upVote(UpvoteRequest $request )
  {
    return $this->QuestionInterface->upVote($request);
  }

  public function reaction(ReactionRequest $request)
  {
    return $this->QuestionInterface->reaction($request);
  }

  public function audio()
  {
    return $this->QuestionInterface->audio();
  }

  public function answer_report(){
    return $this->QuestionInterface->answer_report();
  }

  public function answerReportSave(Request $request){
    return $this->QuestionInterface->answerReportSave($request);
  }

  //sharedmedia
  public function sharedMedia(Request $request){
    return $this->QuestionInterface->sharedMedia($request);
  }
  //sharedmedia

  //saved answer module
  public function savedQuestion(Request $request){
    return $this->QuestionInterface->savedQuestion($request);
  }
  public function savedQuestionList(){
    return $this->QuestionInterface->savedQuestionList();
  }
  //saved answer module

  //keyword search module
  public function keywordSearch(Request $request){
    return $this->QuestionInterface->keywordSearch($request);
  }
  //keyword search module

  //landing page question list module
  public function landingpageQuestionList(){
    return $this->QuestionInterface->landingpageQuestionList();
  }
  //landing page question list module

}