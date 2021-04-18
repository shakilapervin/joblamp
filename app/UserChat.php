<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserChat extends Model
{
    protected $fillable = array('sender_id','receiver_id','url');
    /*
    |--------------------------------------------------------------------------
    | Receiver Details
    |--------------------------------------------------------------------------
    */
    public function receiver()
    {
        return $this->hasOne(User::class, 'id','receiver_id');
    }
}
