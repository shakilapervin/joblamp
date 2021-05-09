<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = array('name_pt','name_ro','name_de','name_fr','name_es','name_en','status');
}
