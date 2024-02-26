<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory,Sluggable,SoftDeletes;

    protected $fillable = [
        'name',
        'uuid',
        'slug',
        'description',
        'is_active',
        'is_popular',
        'created_by',
        'updated_by',
    ];
    public static function boot()    {
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
    public function media(){
        return $this->morphOne(Media::class,'mediaable');
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function image($type){
        $file = $this->media?->file;
        if($file){
            $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');
            if($fileDisk == 'public'){
                if(file_exists(public_path('storage/images/' . $type . '/brand/' . $file))){
                    return asset('storage/images/' . $type . '/brand/' . $file);
                }
            }
        }
        return asset('assets/admin/images/logo.png');
    }

    public function getDisplayImageAttribute(){
        return $this->image('original');
    }
}
