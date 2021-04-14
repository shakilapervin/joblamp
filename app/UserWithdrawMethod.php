<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserWithdrawMethod extends Model
{
    protected  $fillable = array('user_id','type','account_holder_name','account_holder_type','routing_number','account_number','currency','country','bank_id','status','account_id');
}
