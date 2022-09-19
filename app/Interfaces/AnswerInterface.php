<?php 

namespace App\Interfaces;

use App\Http\Requests\AnswerRequest;

interface AnswerInterface
{
    public function answerforquestions(AnswerRequest $request);
    
}