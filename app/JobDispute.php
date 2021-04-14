<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobDispute extends Model
{
    protected $fillable = [
        'job_id',
        'reason',
    ];
}
