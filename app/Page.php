<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = array('page_name','content_en','content_es','content_fr','content_de','content_ro','content_pt');
}
