<?php

namespace App\Models;

use App\Models\ProductAttribute;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class PlanCategory extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $fillable = [
        'category_name',
        'uuid',
        'status',
        'created_at',
        'updated_at',
       /*  'created_by',
        'updated_by', */
        'deleted_at'
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
                'source' => 'name',
            ],
        ];
    }
    protected $appends = [
        'discounted_price',
        // 'latest_image'
    ];




}
