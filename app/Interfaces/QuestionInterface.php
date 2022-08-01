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

}