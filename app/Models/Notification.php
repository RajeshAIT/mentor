<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [ "title",
                            "body",
                            "notification_type",
                            "seen",
                            "user_id",
                            "question_id",
                            "answer_id",
                            "follow_id",
                            "add_people_id",
                            "reaction_id"];
}
