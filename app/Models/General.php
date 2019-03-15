<?php

namespace App\Models;

use App\Base as Model;

class General extends Model
{
    protected $table = 'generals';

    protected $fillable = ['name'];

    public function translations()
    {
        return $this->hasMany(GeneralTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(GeneralTranslation::class)->where('lang_id', self::$lang);
    }

    public function translationByLanguage($lang = 1)
    {
        return $this->hasOne(GeneralTranslation::class)->where('lang_id', $lang)->first();
    }

}
