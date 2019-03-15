<?php

namespace App\Models;

use App\Base as Model;

class SubproductCombination extends Model
{
    protected $table = 'subproduct_combinations';

    protected $fillable = ['category_id', 'case_1', 'case_2', 'case_3'];

}
