<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnswerRequest;


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
}