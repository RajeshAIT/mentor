<?php 

namespace App\Interfaces;
use App\Http\Requests\QuestionRequest;
use App\Http\Requests\ReactionRequest;
use App\Http\Requests\UpvoteRequest;

interface QuestionInterface
{
    public function getQuestionAnswer(QuestionRequest $request);

    public function questionFeed();

    public function landingpage();

    public function getAnswersForQuestions();

    public function leaderBoard();

    public function search($question);
    
    public function viewAnswer($id);

    public function upVote(UpvoteRequest $request);

    public function reaction(ReactionRequest $request);

    public function audio();

    public function answer_report();

    public function answerReportSave($request);

    //shared media
    public function sharedMedia($request);
    //shared media

    //saved answer module
    public function savedQuestion($request);
    public function savedQuestionList();
    //saved answer module

    //keyword search module
    public function keywordSearch($request);
    //keyword search module

    //landing page question list
    public function landingpageQuestionList();
    //landing page question list

}