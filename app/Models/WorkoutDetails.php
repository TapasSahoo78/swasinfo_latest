<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkoutDetails extends Model
{
    use HasFactory,SoftDeletes;
    protected $table= 'workout_details';

    protected $fillable=[
        'uuid',
        'workout_id',
        'workout_name',
        'sets',
        'reps',
        'calorie',
        'status'
    ];



    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function workouts(){
        return $this->belongsTo(Workout::class,'workout_id');
    }
}
