<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LottoUser extends Model
{
    protected $fillable = array('user_id','status');
    /*
    |--------------------------------------------------------------------------
    | User Details
    |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->hasOne(User::class, 'id','user_id');
    }
}
