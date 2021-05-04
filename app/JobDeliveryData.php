<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobDeliveryData extends Model
{
    protected $fillable = array('job_id','delivery_text','delivery_file');
}
