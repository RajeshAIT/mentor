<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postreport extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_content',
        'comments',
        'post_by',
        'post_id',
        'post_type',
        'report_by'
    ];
}
