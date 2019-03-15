<?php

namespace App\Models;

use App\Base as Model;

class Review extends Model
{
    protected $table = 'reviews';

    protected $fillable = ['alias', 'img'];

    public function translations()
    {
        return $this->hasMany(ReviewTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(ReviewTranslation::class)->where('lang_id', self::$lang);
    }

}
