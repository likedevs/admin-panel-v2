<?php

namespace App\Models;

use App\Base as Model;

class ProductSimilar extends Model
{
    protected $table = 'similar_products';

    protected $fillable = ['category_id'];
}
