<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attribute;

class ProductAttribute extends Model
{
    use HasFactory;
    protected $fillable = [
        'attribute_id',
        'product_id',
        'value',
        'attribute_price',
        'is_active',
        'created_by',
        'updated_by',
    ];
    public function attribute(){
        return $this->belongsTo(Attribute::class);
    }
}
