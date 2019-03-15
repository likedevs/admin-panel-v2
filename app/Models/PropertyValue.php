<?php

namespace App\Models;

use App\Base as Model;

class PropertyValue extends Model
{
    protected $table = 'property_values';

    protected $fillable = ['property_id', 'product_id', 'value_id'];

    public function translations() {
        return $this->hasMany(PropertyValueTranslation::class, 'property_value_id');
    }

    public function translation()
    {
        return $this->hasOne(PropertyValueTranslation::class, 'property_values_id')->where('lang_id', self::$lang);
    }
    
}
