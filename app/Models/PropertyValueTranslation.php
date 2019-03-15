<?php


namespace App\Models;

use App\Base as Model;

class PropertyValueTranslation extends Model
{
    protected $fillable = ['property_values_id', 'lang_id', 'value'];

    protected $table = 'property_values_translation';

    public function propertyValue()
    {
        return $this->belongsTo(PropertyValue::class);
    }
}
