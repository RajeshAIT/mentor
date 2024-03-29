<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopKeywords extends Model
{
    use HasFactory;
    protected $fillable =[
        'keywords',
        'keyword_id',
        'category'
    ];
}
