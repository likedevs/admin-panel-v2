<?php

namespace App\Models;

use App\Base as Model;

class Tag extends Model
{
    protected $table = 'tags';

    protected $fillable = ['name'];
}
