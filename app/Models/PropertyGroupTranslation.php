<?php

namespace App\Models;

use App\Base as Model;

class PropertyGroupTranslation extends Model
{
    protected $table = 'property_groups_translation';

    protected $fillable = [
        'property_group_id',
        'lang_id',
        'name',
    ];

    public function propertyGroup()
    {
        return $this->belongsTo(PropertyGroup::class, 'property_group_id');
    }
}
