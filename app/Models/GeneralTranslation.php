<?php

namespace App\Models;

use App\Base as Model;

class GeneralTranslation extends Model
{
    protected $table = 'generals_translation';

    protected $fillable = ['name', 'body', 'description', 'lang_id'];
}
