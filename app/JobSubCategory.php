<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobSubCategory extends Model
{
    protected $fillable = [
        'name',
        'parent_id',
        'status',
    ];

    /*
    |--------------------------------------------------------------------------
    | Parent Category
    |--------------------------------------------------------------------------
    */
    public function category()
    {
        return $this->hasOne(JobCategory::class, 'id','parent_id');
    }
}
