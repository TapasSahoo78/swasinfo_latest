<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Banner extends Model
{
    use HasFactory,Sluggable,SoftDeletes;

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

    protected $fillable = [
        'id',
        'title',
        'link',
        'type_id',
        'description',
        'is_active',
        'created_by',
        'updated_by'
    ];

    public function image(){
        return $this->morphOne(Media::class,'mediaable');
    }

    public function getDisplayImageAttribute(){
        return $this->bannerImage();
    }

    protected function bannerImage($type='original'){
        $file = $this->media?->file;
        if($file){
            $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');
            if($fileDisk == 'public'){
                if(file_exists(public_path('storage/images/' . $type . '/banner/' . $file))){
                    return asset('storage/images/' . $type . '/banner/' . $file);
                }
            }
        }
        return asset('assets/frontend/images/banner-img1.png');
    }
    // public function seo(){
    //     return $this->morphOne(Seo::class,'seoable');
    // }

}
