<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Order extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'uuid',
        'user_id',
        'order_id',
        'delivery_status',
        'product_details',
        'payment_type',
        'total_amount',
        'coupon',
        'item',
        'gst',
        'discount',
        'address_id',
        'cart_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
      
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function details(){
        return $this->hasMany(OrderDetail::class);
    }
    public function orderAddress(){
        return $this->hasOne(OrderAddress::class);
    }
    public function orderTransaction(){
        return $this->hasOne(Transaction::class);
    }

}
