<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    protected $fillable = [
        'title',
        'description',
        'default_price',
        'number_of_jobs',
        'recommended',
        'status',
    ];
    /*
    |--------------------------------------------------------------------------
    | Plan Features
    |--------------------------------------------------------------------------
    */
    public function features()
    {
        return $this->hasMany(SubscriptionPlanFeature::class, 'plan_id','id');
    }
}
