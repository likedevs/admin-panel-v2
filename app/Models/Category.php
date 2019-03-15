<?php
namespace App\Models;

use App\Base as Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = ['parent_id', 'alias', 'image', 'deleted', 'level', 'position'];

    public function translations()
    {
        return $this->hasMany(CategoryTranslation::class);
    }

    public function translation()
    {
        return $this->hasMany(CategoryTranslation::class)->where('lang_id', self::$lang);
    }

}
