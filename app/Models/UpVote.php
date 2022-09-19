<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpVote extends Model
{
    use HasFactory;
    protected $fillable = [
        'question_id',
        'upvote_by',
        'status'
    ];
}
