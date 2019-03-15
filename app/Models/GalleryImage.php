<?php

namespace App\Models;

use App\Base as Model;

class GalleryImage extends Model
{
    protected $table = 'gallery_images';

    protected $fillable = ['gallery_id', 'src'];

    public function translations() {
        return $this->hasMany(GalleryImageTranslation::class);
    }

    public function translation()
    {
        return $this->hasMany(GalleryImageTranslation::class)->where('lang_id', self::$lang);
    }

    public function translationByLanguage($lang = 1)
    {
        return $this->hasOne(GalleryImageTranslation::class)->where('lang_id', $lang)->first();
    }
}
