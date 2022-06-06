<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'comment',
        'posted_by_id',
        'company_id',
        'image',
        'video',
        'link'
    ];
}
