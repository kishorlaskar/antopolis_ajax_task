<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'category_name', 'category_description','publication_status'
    ];

    public function subcategories()
    {
        return $this->hasMany('App\Category', 'category_id');
    }
}
