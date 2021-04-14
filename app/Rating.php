<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'job_id',
        'feedback',
        'rating',
        'user_id',
    ];
}
