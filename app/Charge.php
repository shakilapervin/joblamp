<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    protected $fillable = array('withdraw_charge','customer_charge','worker_charge','promote');
}
