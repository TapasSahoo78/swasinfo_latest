<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;
use Cviebrock\EloquentSluggable\Sluggable;

class RestaurantsCategorie extends Model
{
    use HasFactory, SoftDeletes, sluggable;
    protected $guarded = [];

    // protected $fillable = [
    //     'name',
    //     'phone',
    //     'lat',
    //     'long',
    //     'is_featured',
    //     'address',
    //     'user_id',
    // ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function parent()
    {
        return $this->belongsTo(RestaurantsCategorie::class, 'parent_id');
    }
    public function subCategory()
    {
        return $this->hasMany(RestaurantsSubCategorie::class, 'category_id', 'id');
    }
}
