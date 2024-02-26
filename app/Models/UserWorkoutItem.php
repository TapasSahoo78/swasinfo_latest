<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWorkoutItem extends Model
{
    protected $table = 'user_workoutitem';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id','trainer_id','workout_type','workout_id'];
    public $timestamps = true;

    // Add any additional configuration or relationships here

    

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
        return asset('assets/admin/images/default_workout.jpeg');
    }


    public function workoutDetails()
    {
        return $this->hasOne(WorkoutDetails::class, 'workout_id');
    }

    public function workout()
    {
        return $this->belongsTo(Workout::class, 'workout_id');
    }

  
}
