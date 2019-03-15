<?php

namespace App\Models;

use App\Base as Model;

class PromotionTranslation extends Model
{
    protected $table = 'promotions_translation';

    protected $fillable = [
        'brand_id', 'lang_id', 'banner', 'banner_mob', 'width', 'height', 'width_mob', 'height_mob', 'name', 'description', 'body', 'seo_text', 'seo_title', 'seo_description', 'seo_keywords'
    ];

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
}
