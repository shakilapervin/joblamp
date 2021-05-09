<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlanFeature extends Model
{
    protected $fillable = [
        'plan_id',
        'content_en',
        'content_es',
        'content_de',
        'content_fr',
        'content_ro',
        'content_pt',
    ];
}
