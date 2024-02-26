<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Mfi extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'code',
        'registration_number',

        'status',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted_at'
    ];

    public function user(){
        return $this->hasOne(User::class,'mfi_id');
    }
    public function roles(){
        return $this->belongsToMany(Role::class,'mfi_roles');
    }

    public function mfiRoles(){
        return $this->hasMany(MfiRole::class,'mfi_id');
    }


    public function branches(){
        return $this->hasMany(Branch::class,'mfi_id');
    }
    // public function roles(){
    //     return $this->hasMany(User::class,'mfi_id');
    // }

    protected $appends= [
        'logo_picture'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function logo(){
        return $this->hasMany(Logo::class, 'mfi_id', 'id');
    }

    public function getLogoPictureAttribute() {
        return $this->logoPicture();
    }

     public function logoPicture($type = 'logo') {
        // return true;
        $logoPicture = $this->logo()->value('file');
        //return $logoPicture;
        if(!is_null($logoPicture)){

            $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');
            if($fileDisk == 'public'){
                if(file_exists(public_path('storage/images/original/'.$type.'/'. $logoPicture))){
                    return asset('storage/images/original/'.$type.'/'. $logoPicture);
                }
            }
        }
        return asset('assets/images/no-logo.jpg');
    }
}
