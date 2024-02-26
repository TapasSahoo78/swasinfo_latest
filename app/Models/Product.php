<?php

namespace App\Models;

use App\Models\ProductAttribute;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Product extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $fillable = [
        'name',
        'uuid',
        'title',
        'slug',
        'description',
        'category_id',
        'brand_id',
        'vendor_id',
        'price',
        'color',
        'stock',
        'discount',
        'product_image',
        'is_featured',
        'is_active',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted_at',
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

    public function getdiscountedPriceAttribute(){
        return $this->discountedPrice();
    }

    public function discountedPrice(){
        return $this->price - ($this->price*($this->discount/100));
    }

    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function media()
    {
        return $this->morphMany(Media::class, 'mediaable');
    }
    public function singleMedia()
    {
        return $this->morphOne(Media::class, 'mediaable');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function productAttribute()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id', 'id');
    }
    public function getLatestImageAttribute()
    {
        $file = $this->media->first()?->file;
        if ($file) {
            return asset('storage/images/original/product/' . $file);
        }
        return asset('assets/admin/images/applications-image-21.jpg');
    }
    public function getProductImagesAttribute($type = 'original')
    {
        $files = $this->media?->pluck('file');
        if($files->isNotEmpty()){
          foreach($files as $file){
            $pictures[] = asset('storage/images/original/product/'.$file);
          }
            return $pictures;
        }
        return array(asset('assets/admin/images/applications-image-21.jpg'));

    }

    public function getSpecificationsAttribute()
    {
        $specifications = $this->productAttribute;
        if ($specifications->isNotEmpty()) {
            foreach ($specifications as $key => $specification) {
                $data[$specification->attribute->name][$key]['value'] = $specification->value;
                $data[$specification->attribute->name][$key]['id'] =    $specification->id;
                $data[$specification->attribute->name][$key]['price'] = $specification->attribute_price;
            }
            return $data;
        }
        return array();
    }
     public function wishlists(){
        return $this->hasMany(Wishlist::class);
    }

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
