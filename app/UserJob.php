<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserJob extends Model
{
    protected $fillable = [
        'job_id',
        'customer_id',
        'service_provider_id',
        'status',
    ];
    /*
    |--------------------------------------------------------------------------
    | Job Details
    |--------------------------------------------------------------------------
    */
    public function jobDetails()
    {
        return $this->hasOne(Job::class, 'id','job_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Job Details
    |--------------------------------------------------------------------------
    */
    public function workerDetails()
    {
        return $this->hasOne(User::class, 'id','service_provider_id');
    }
}
