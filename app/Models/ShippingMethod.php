<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingMethod extends Model
{
    use SoftDeletes;

    protected $table = 'shipping_method';
    protected $fillable = ['name', 'is_active']; // Specify the columns that are mass assignable

    // Define relationships, attributes, and other methods as needed
}
