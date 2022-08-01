<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyVerify extends Model
{
    use HasFactory;
    protected $fillable = [
         'user_id',
         'name',
         'website',
         'email',
         'verify',
         'token'
     ];
}
