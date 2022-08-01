<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Postmedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'media_type_id',
        'media_url',
        'media_thumbnail'
    ];
}
