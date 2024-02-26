<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FoodSuffix extends Model
{
    use SoftDeletes;

    protected $table = 'food_suffix';

    protected $fillable = [
        'name',
        // Add other fillable fields here
    ];
}
