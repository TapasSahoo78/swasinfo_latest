<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\AttributeValue;

class Attribute extends Model
{
    use HasFactory, Sluggable, SoftDeletes;
    protected $guarded = [];

    protected $table = 'attributes';

    protected $fillable = [
        'uuid',
        'steps',
        'points',
        'discount',
        'is_active',
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
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    public function attributeValue()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_attributes');
    }
}
