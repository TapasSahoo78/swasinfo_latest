<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use HasFactory,SoftDeletes;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }
    protected $fillable = [
        'uuid',
        'user_id',
        'gender',
        'age',
        'height',
        'height_type',
        'weight_type',
        'weight',
        'target_weight',
        'guidance',
        'bmi'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    // protected $casts =[
    //     'address' => 'array'
    // ];
}
