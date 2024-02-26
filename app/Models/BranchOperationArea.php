<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class BranchOperationArea extends Model
{
    use HasFactory;
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'branch_id',
        'zone_name',
        'country_name',
        'states_name',
        'cities_name',
        'zip_codes',
        'mfi_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }
}
