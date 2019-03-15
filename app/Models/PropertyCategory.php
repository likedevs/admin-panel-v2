<?php

namespace App\Models;

use App\Base as Model;

class PropertyCategory extends Model
{
    protected $table = 'property_categories';

    protected $fillable = ['property_id', 'category_id'];

    public function property()
    {
        return $this->hasOne(Property::class);
    }

    public function category()
    {
        return $this->hasOne(ProductCategory::class);
    }
}
