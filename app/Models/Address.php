<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Address extends Model
{
    use HasFactory, SoftDeletes;
    
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    protected $fillable = [
        'uuid',
        'table_id',
        'addressable_type',
        'addressable_id',
        'street_address',
        'full_address',
        'address_type',
        'zip_code',
        'country_name',
        'state_name',
        'city_name',
        'landmark',
        'zone_id'
        /* 'created_by',
        'updated_by' */
    ];

    // protected $casts = [
    //     'full_address' => 'array',
    // ];
    public function addressable(){
        return $this->morphTo();
    }

}
