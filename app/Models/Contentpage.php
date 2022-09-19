<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contentpage extends Model
{
    use HasFactory;

    protected $fillable = ["content","page_title","url_title"];
}
