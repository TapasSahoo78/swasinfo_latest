<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class TrainerCustomerRequest extends Model
{
    use HasFactory, SoftDeletes;



    protected $fillable = [
        'uuid',
        'user_id',
        'trainer_id',
        'details'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function customerRequest(){
        return $this->belongsTo(User::class,'user_id');
    }

    // public function customerCallList(){
    //     return $this->belongsTo(User::class,'user_id');
    // }
}
