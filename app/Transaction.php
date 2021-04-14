<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = array('transaction_id','payment_method','user_id','narration');
}
