<?php

namespace App\Models;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Logo extends Model
{
    use HasFactory,SoftDeletes;
    protected $table= 'logos';

    protected $fillable=[
        'uuid',
        'mfi_id',
        'logoable_type',
        'logoable_id',
        'logo_type',
        'file'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function logoable(){
        return $this->morphTo();
    }
}
