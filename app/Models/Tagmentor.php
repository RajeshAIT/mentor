<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagmentor extends Model
{
    use HasFactory;

    protected $fillable = ["mentor_id","question_id","tagged_by"];
}
