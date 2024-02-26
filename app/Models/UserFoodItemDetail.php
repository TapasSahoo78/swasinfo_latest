<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class UserFoodItemDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'user_id',
        'food_id',
        'food_ids',
        'food_item_id',
        'type',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }
    public function Food()
    {
        return $this->hasMany(Food::class, 'id','food_id');
    }

}
