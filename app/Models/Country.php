<?php

namespace App\Models;

use App\Base as Model;

class Country extends Model
{
    protected $table = 'location_countries';

    public function regions()
    {
        return $this->hasMany(Region::class, 'location_country_id', 'id');
    }
}
