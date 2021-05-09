<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    protected $fillable = [
        'title_en',
        'title_es',
        'title_fr',
        'title_de',
        'title_ro',
        'title_pt',
        'description_en',
        'description_es',
        'description_de',
        'description_fr',
        'description_ro',
        'description_pt',
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
