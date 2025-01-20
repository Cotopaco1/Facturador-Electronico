<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'code_reference',
        'standard_code_id',
        'name',
        'price',
        'tribute_id',
        'tax_rate',
        'unit_measure_id',
        'is_excluded'
    ];
}
