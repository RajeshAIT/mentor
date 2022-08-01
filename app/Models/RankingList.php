<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RankingList extends Model
{
    use HasFactory;protected $fillable = [
        'user_id',
        'points',
        'reasons',
    ];

    public function users()
    {
        return $this->belongsTo('App\Models\User');
    }
}
