<?php

namespace App\Models;

use App\Base as Model;

class ProductProperty extends Model
{
    protected $table = 'product_properties';

    protected $fillable = ['group_id', 'type', 'key', 'filter'];

    public function translations()
    {
        return $this->hasMany(ProductPropertyTranslation::class, 'property_id');
    }

    public function category($categoryId)
    {
        return $this->hasOne(ProductCategoryTranslation::class, 'product_category_id', 'category_id')->where('product_category_id', $categoryId);
    }

    public function group()
    {
        return $this->hasOne(PropertyGroup::class, 'id', 'group_id');
    }

    public function multidata()
    {
        return $this->hasMany(PropertyMultiData::class, 'property_id');
    }

    public function translation()
    {
        return $this->hasMany(ProductPropertyTranslation::class, 'property_id')->where('lang_id', self::$lang);
    }

    public function translationByLanguage($lang = 1)
    {
        return $this->hasOne(ProductPropertyTranslation::class, 'property_id')->where('lang_id', $lang)->first();
    }

}
