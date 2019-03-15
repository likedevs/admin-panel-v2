<?php

namespace App\Models;

use App\Base as Model;

class UserField extends Model
{
    protected $table = 'userfields';

    protected $fillable = ['in_register', 'in_cabinet', 'in_cart', 'in_auth', 'unique_field', 'required_field', 'return_field'];
}
