<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class UserHealthschedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'user_id',
        'sleep_schedule',
        'total_sleep_hours',
        'is_followed_diet_plan',
        'diet_plan_last_time',
        'is_followed_exercise_plan',
        'exercise_plan_last_time',
        'any_physical_movement',
        'physical_movement_last_time',
        'water_intake_last_time',
        'prescription_name',
        'medication_name',
        'asthma_name',
        'uric_acid_name',
        'diabities_name',
        'high_cholesterol_name',
        'low_blood_pressure_name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }
}
