<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlanFeature extends Model
{
    protected $fillable = [
        'plan_id',
        'content',
    ];
}
