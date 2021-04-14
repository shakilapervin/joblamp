<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $fillable = [
        'job_id',
        'candidate_id',
        'cover_letter',
        'bid_amount',
        'status',
    ];

    /*
    |--------------------------------------------------------------------------
    | Candidate Details
    |--------------------------------------------------------------------------
    */
    public function candidateDetails()
    {
        return $this->hasOne(User::class, 'id','candidate_id')->with('userCountry')->with('userRating');
    }

    /*
    |--------------------------------------------------------------------------
    | Job Details
    |--------------------------------------------------------------------------
    */
    public function jobDetails()
    {
        return $this->hasOne(Job::class, 'id','job_id');
    }
}
