<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'answer_id',
        'reaction_id',
        'reaction_by'
    ];
}
