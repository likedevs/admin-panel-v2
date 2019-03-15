<?php

namespace App\Models;

use App\Base as Model;

class PostTranslation extends Model
{
    protected $table = 'posts_translation';

    protected $fillable = [
        'lang_id',
        'post_id',
        'title',
        'body',
        'slug',
        'video',
        'image',
        'image_title',
        'image_alt',
        'meta_title',
        'meta_keywords',
        'meta_description',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
