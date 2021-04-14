<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlanPrice extends Model
{
    protected $fillable = [
        'plan_id',
        'country_id',
        'price',
        'status',
    ];
    /*
    |--------------------------------------------------------------------------
    | Country Details
    |--------------------------------------------------------------------------
    */
    public function country()
    {
        return $this->hasOne(Country::class, 'id','country_id');
    }
}
