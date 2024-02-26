<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkoutDetailsImages extends Model
{
    use HasFactory,SoftDeletes;
    protected $table= 'workout_details_images';

    protected $fillable=[
        'uuid',
        'workout_id',
        'workoutable_type',
        'workoutable_id',
        'workout_type',
        'file'

    ];



    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function workoutable(){
        return $this->morphTo();
    }
}
