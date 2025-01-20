<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tribute extends Model
{
    //
    protected $filled = [
        'id',
        'name',
        'code',
        'description'
    ];
}
