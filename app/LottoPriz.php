<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LottoPriz extends Model
{
    protected $fillable = array('title_en','title_es','status','title_fr','title_de','title_pt','title_ro','details_en','details_es','details_fr','details_de','details_pt','details_ro','status');
}
