<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sharedmedia extends Model
{
    use HasFactory;

    protected $fillable = ["answer_id","shared_by","media"];
}
