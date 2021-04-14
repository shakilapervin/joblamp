<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'name',
        'country_id',
        'state_id',
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

    /*
    |--------------------------------------------------------------------------
    | State name
    |--------------------------------------------------------------------------
    */
    public function stateName()
    {
        return $this->hasOne(State::class, 'id','state_id');
    }
}
