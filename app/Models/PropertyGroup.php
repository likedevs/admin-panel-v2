<?php

namespace App\Models;

use App\Base as Model;

class PropertyGroup extends Model
{
    protected $table = 'property_groups';

    public function translations()
    {
        return $this->hasMany(PropertyGroupTranslation::class, 'property_group_id');
    }

    public function properties()
    {
        return $this->hasMany(ProductProperty::class, 'group_id');
    }

    public function translation()
    {
        return $this->hasOne(PropertyGroupTranslation::class, 'property_group_id')->where('lang_id', self::$lang);
    }

    public function translationByLanguage($lang = 1)
    {
        return $this->hasOne(PropertyGroupTranslation::class, 'property_group_id')->where('lang_id', $lang)->first();
    }
}
