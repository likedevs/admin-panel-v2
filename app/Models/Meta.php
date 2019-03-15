<?php

namespace App\Models;

use App\Base as Model;

class Meta extends Model
{
    public function translations()
    {
        return $this->hasMany(MetaTranslation::class);
    }

    public function translation()
    {
        return $this->hasMany(MetaTranslation::class)->where('lang_id', self::$lang);
    }
}
