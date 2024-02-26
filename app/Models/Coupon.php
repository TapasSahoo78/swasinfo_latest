<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class Coupon extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=[
        'uuid',
        'title',
        'coupon_code',
        'date_time',
        'category_id',
        'coupon_discount',
        'started_at',
        'ended_at',
        'is_expired',
        'is_active'

    ];
    public static function boot(){
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class,'coupons_categories');
    }
}
