<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FoodItems extends Model
{
    use HasFactory,SoftDeletes;
    protected $table= 'food_items';

    protected $fillable=[
        'uuid',
        'food_id',
        'food_name',
        'status'
    ];



    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function foods(){
        return $this->belongsTo(Food::class,'food_id');
    }

    public function getDetailsImageAttribute(){
        return $this->foodDetailsImage();
    }

    protected function foodDetailsImage($type='original'){
        
        return asset('assets/admin/images/default_food.jpg');
    }

    public function userFoodItems()
    {
        return $this->belongsToMany(UserFoodItems::class,'user_food_items');
    }

}
