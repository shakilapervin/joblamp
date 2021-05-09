<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    protected $fillable = [
        'name_en',
        'name_es',
        'name_pt',
        'name_fr',
        'name_de',
        'name_ro',
        'icon',
        'description_en',
        'description_es',
        'description_pt',
        'description_fr',
        'description_de',
        'description_ro',
        'status',
    ];
}
