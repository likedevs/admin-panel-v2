<?php

namespace App\Models;

use App\Base as Model;

class FrontUserUnlogged extends Model
{
    protected $table = 'front_users_unlogged';

    protected $fillable = ['name', 'email', 'phone', 'spam'];

    public function addresses() {
        return $this->hasMany(FrontUserAddress::class);
    }
}
