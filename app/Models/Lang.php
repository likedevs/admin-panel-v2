<?php

namespace App\Models;

use App\Base as Model;

class Lang extends Model
{
    protected $table = 'langs';

    protected $fillable = [ 'lang', 'descr', 'default_lang', 'position', 'active'];

}
