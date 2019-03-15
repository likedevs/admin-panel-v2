<?php

namespace App\Models;

use App\Base as Model;

class Traduction extends Model
{
    protected $table = 'traductions';

    protected $fillable = ['page_id', 'number'];

    public function translations()
    {
        return $this->hasMany(TraductionTranslation::class);
    }

    public function translation()
    {
        return $this->hasMany(TraductionTranslation::class, 'traduction_id')->where('lang_id', self::$lang);
    }


    public function translationByLanguage($lang = 1)
    {
        return $this->hasOne(TraductionTranslation::class)->where('lang_id', $lang)->first();
    }
}
