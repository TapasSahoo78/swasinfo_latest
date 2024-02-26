<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Transaction extends Model
{
    protected $fillable = [
        'uuid',
        'order_id',
        'user_id',
        'ammount',
        'transactionable_type',
        'transactionable_id',
        'currency',
        'payment_gateway',
        'payment_gateway_id',
        'payment_gateway_uuid',
        'status',
        'created_by',
        'updated_by'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function transactionable(){
        return $this->morphTo();
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

}
