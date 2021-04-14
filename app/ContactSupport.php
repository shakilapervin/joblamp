<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactSupport extends Model
{
    protected $fillable = array('name','email','type','description','status');
}
