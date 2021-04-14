<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = [
        'name',
        'country_id',
        'status',
    ];

    /*
    |--------------------------------------------------------------------------
    | Country name
    |--------------------------------------------------------------------------
    */
    public function countryName()
    {
        return $this->hasOne(Country::class, 'id','country_id');
    }
}
