<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use App\Models\Attribute;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Category extends Model
{
    use HasFactory, Sluggable, SoftDeletes, HasRecursiveRelationships;

    protected $guarded = [];
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
    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_id', 'id');
    }
    public function children()
    {
        return $this->hasMany(static::class, 'parent_id', 'id');
    }
    public function media()
    {
        return $this->morphMany(Media::class, 'mediaable');
    }

    public function latestImage()
    {
        return $this->morphOne(Media::class, 'mediaable');
    }
    public function attribute()
    {
        return $this->belongsToMany(Attribute::class, 'category_attributes');
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupons_categories');
    }

    public function getDisplayImageAttribute()
    {
        return $this->categoryImage('original');
    }

    protected function categoryImage($type = 'original')
    {
        $file = $this->media()->first()?->file;
        if ($file) {
            $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');
            if ($fileDisk == 'public') {
                if (file_exists(public_path('storage/images/' . $type . '/category/' . $file))) {
                    return asset('storage/images/' . $type . '/category/' . $file);
                }
            }
        }
        return asset('assets/admin/images/logo.png');
    }
}
