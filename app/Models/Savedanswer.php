<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Savedanswer extends Model
{
    use HasFactory;

    protected $fillable = ['question_id','saved_by','status'];
}
