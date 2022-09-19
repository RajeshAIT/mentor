<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table = "question";

    protected $fillable = [
        'question',
        'created_by',
        'category_id',
        'emotion_id',
        'question_association_id'     
    ];

   
}
