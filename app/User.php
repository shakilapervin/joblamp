<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','first_name','last_name','mobile_number','user_type','address_line_1','address_line_2','city','state','country','pincode','status','plan_expiry_date','plan_id','remain_job','device_token','promoted','promotion_expire','skill'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | User Country
    |--------------------------------------------------------------------------
    */
    public function userCountry()
    {
        return $this->hasOne(Country::class, 'id','country');
    }

    /*
    |--------------------------------------------------------------------------
    | User Rating
    |--------------------------------------------------------------------------
    */
    public function userRating()
    {
        return $this->hasMany(Rating::class, 'user_id','id');
    }
}
