<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'title',
        'comment',
        'posted_by_id',
        'company_id',
        'post_type_id',
        'qualification',
        'experience',
        'salary_min',
        'salary_max',
    ];
}
