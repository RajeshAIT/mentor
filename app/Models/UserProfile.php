<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
    protected $table = "userprofile";
    protected $fillable = [
        'user_id',
        'photo',
        'title',
        'about',
        'experience',
        'location',
        'cause',
        'recommandations'
    ];
}
