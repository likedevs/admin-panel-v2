<?php

namespace App\Models;

use App\Base as Model;

class City extends Model
{
    protected $table = 'location_cities';

    public function regions()
    {
        return $this->hasMany(Region::class, 'id', 'location_region_id');
    }
}
