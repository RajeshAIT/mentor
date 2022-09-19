<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Videoreport extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_content',
        'comments',
        'answer_by',
        'answer_id',
        'question_id',
        'report_by'
    ];
}
