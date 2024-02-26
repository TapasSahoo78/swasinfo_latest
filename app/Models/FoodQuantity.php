<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FoodQuantity extends Model
{
    use SoftDeletes;

    protected $table = 'food_quantity';

    protected $fillable = [
        'name',
        // Add other fillable fields here
    ];
}
