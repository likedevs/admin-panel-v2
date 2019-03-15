<?php

namespace App\Models;

use App\Base as Model;

class PropertyMultiDataTranslation extends Model
{
    protected $table = 'property_multidatas_translation';

    protected $fillable = [
        'property_multidata_id',
        'lang_id',
        'name',
        'value'
    ];

    public function propertyMultidata()
    {
        return $this->belongsTo(PropertyMultiData::class, 'property_id');
    }
}
