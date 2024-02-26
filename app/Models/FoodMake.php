<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FoodMake extends Model
{
    use SoftDeletes;

    protected $table = 'food_make';

    protected $fillable = [
        'name',
        // Add other fillable fields here
    ];
}
