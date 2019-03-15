<?php

namespace App\Models;

use App\Base as Model;

class PropertyMultiData extends Model
{
    protected $table = 'property_multidatas';

    protected $fillable = ['property_id'];

    public function translations()
    {
        return $this->hasMany(PropertyMultiDataTranslation::class, 'property_multidata_id');
    }

    public function translation()
    {
        return $this->hasMany(PropertyMultiDataTranslation::class, 'property_multidata_id')->where('lang_id', self::$lang);
    }

    public function translationByLanguage($lang = 1)
    {
        return $this->hasOne(PropertyMultiDataTranslation::class, 'property_multidata_id')->where('lang_id', $lang)->first();
    }

    public function subProduct($productId, $paramValue)
    {
        return SubProduct::where('product_id', $productId)->where('combination', 'like', '%:' . $paramValue . '%')->first();
    }
}
