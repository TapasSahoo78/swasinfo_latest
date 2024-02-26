<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;


class OrderDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'user_id',
        'product_id',
        'order_no',
        'vendor_id',
        'quantity',
        'additional_details',
        'delivery_status',
        'shipping_cost',
        'created_by',
        'updated_by',
    ];

    protected $casts= [
        'additional_details' => 'array'
    ];


    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }
    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function vendor(){
        return $this->belongsTo(User::class,'vendor_id');
    }
}
