<?php

namespace App\Repositories;


use App\Models\Answer;
use App\Models\RankingList;
use App\Traits\ResponseAPI;
use Illuminate\Support\Facades\DB;
use App\Interfaces\AnswerInterface;
use App\Http\Requests\AnswerRequest;
use Illuminate\Support\Facades\Auth;


class AnswerRepository implements AnswerInterface    
{
    use ResponseAPI;

  public function answerforquestions(AnswerRequest $request)
  {

    DB::beginTransaction();

    $allowedMimeTypes = ['video/x-ms-asf','video/x-flv','video/mp4','application/x-mpegURL','video/MP2T','video/3gpp','video/quicktime','video/x-msvideo','video/x-ms-wmv','video/avi'];
    $contentType = $request->file('media');
    $input['media'] = $contentType->getClientMimeType();

    if(in_array($input['media'], $allowedMimeTypes) ){
        $media_type = "1";
    }else{
        $media_type = "2";
    }
    
    $file = $request->file('media');
    $input['media'] = time() . '.' . $file->getClientOriginalExtension();
    $destinationPath = storage_path('public/media/');
    $file->move($destinationPath, $input['media']);

    $answerCollections= Answer::create([
      'answer_by' => Auth::user()->id,
      'question_id' => $request->question_id,
      'media_type_id' => $media_type,
      'media' => $input['media'],
      'comments' => $request->comments
    ]);

    if($answerCollections)
    {
      $points = RankingList::create([
        'user_id' => Auth::user()->id,
        'points' => 15,
        'reasons' => "Answered",
      ]);
    }

    DB::commit();
    $media = url('api/answer/media').'/'.$answerCollections->id;
    $data['answer_by'] = Auth::user()->id;
    $data['question_id'] = $request->question_id;
    $data['media'] = $media;
    $data['comments'] = $request->comments;
    $message = "answer stored successfully";
    return response()->json(['status' => true, 'message'=> $message ],200);
  }
}