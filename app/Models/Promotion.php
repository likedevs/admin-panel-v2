<?php

namespace App\Models;

use App\Base as Model;

class Promotion extends Model
{
    protected $table = 'promotions';

    protected $fillable = ['alias', 'img', 'discount'];

    public function translations()
    {
        return $this->hasMany(PromotionTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(PromotionTranslation::class, 'promotion_id')->where('lang_id', self::$lang);
    }

}
