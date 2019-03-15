<?php

namespace App\Models;

use App\Base as Model;

class TraductionTranslation extends Model
{
    protected $table = 'traductions_translations';

    protected $fillable = ['traduction_id', 'lang_id', 'value'];

}
