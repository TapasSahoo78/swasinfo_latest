<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FoodMedia extends Model
{
    use HasFactory,SoftDeletes;
    protected $table= 'food_media';

    protected $fillable=[
        'uuid',
        'food_id',
        'mediaable_type',
        'mediaable_id',
        'media_type',
        'file',
        'is_breakfast',
        'is_lunch',
        'is_dinner',
        'is_snacks',
        'meta_details',
        'status'

    ];



    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function mediaable(){
        return $this->morphTo();
    }
}
