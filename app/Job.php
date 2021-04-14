<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'title',
        'user_id',
        'description',
        'start_date',
        'end_date',
        'category',
        'fee_range_min',
        'fee_range_max',
        'service_provider_rating',
        'address',
        'city',
        'state',
        'country',
        'pincode',
        'status',
        'time',
    ];

    /*
    |--------------------------------------------------------------------------
    | Job Creator Details
    |--------------------------------------------------------------------------
    */
    public function creatorDetails()
    {
        return $this->hasOne(User::class, 'id','user_id')->with('userCountry');
    }

    /*
    |--------------------------------------------------------------------------
    | Job Category
    |--------------------------------------------------------------------------
    */
    public function categoryInfo()
    {
        return $this->hasOne(JobCategory::class, 'id','category');
    }

    /*
    |--------------------------------------------------------------------------
    | Job Country
    |--------------------------------------------------------------------------
    */
    public function jobCountry()
    {
        return $this->hasOne(Country::class, 'id','country');
    }

    /*
    |--------------------------------------------------------------------------
    | Job User Job
    |--------------------------------------------------------------------------
    */
    public function userJob()
    {
        return $this->hasOne(UserJob::class, 'job_id','id')->with('workerDetails');
    }
}
