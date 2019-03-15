<?php

namespace App\Models;

use App\Base as Model;

class Post extends Model
{
    public function translations()
    {
        return $this->hasMany(PostTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(PostTranslation::class)->where('lang_id', self::$lang);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
