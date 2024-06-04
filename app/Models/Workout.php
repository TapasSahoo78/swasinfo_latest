<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;


class Workout extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'workout_type',
        'workout_sub_type',
        'status',
        'created_at',
        'updated_at',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function workout()
    {
        return $this->morphOne(WorkoutMedia::class, 'mediaable');
    }

    public function workoutDetailsImage()
    {
        return $this->morphOne(WorkoutDetailsImages::class, 'workoutable');
    }

    public function getWorkoutImageAttribute(){
        return $this->workoutImage();
    }


    protected function workoutImage($type='original'){
        $file =  $this->workout?->file;
        if($file){
            $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');
            if($fileDisk == 'public'){
                if(file_exists(public_path('storage/images/' . $type . '/workout/' . $file))){
                    return asset('storage/images/' . $type . '/workout/' . $file);
                }
            }
        }
        return asset('assets/admin/images/default_workout.jpg');
    }


    public function workoutDetails()
    {
        return $this->hasOne(WorkoutDetails::class, 'workout_id');
    }
}
