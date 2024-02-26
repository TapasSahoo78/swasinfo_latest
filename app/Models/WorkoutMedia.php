<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkoutMedia extends Model
{
    use HasFactory,SoftDeletes;
    protected $table= 'workout_media';

    protected $fillable=[
        'uuid',
        'workout_id',
        'mediaable_type',
        'mediaable_id',
        'media_type',
        'file',
        'is_yoga',
        'is_meditation',
        'is_excercise',
        'meta_details',
        'status'

    ];



    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function mediaable(){
        return $this->morphTo();
    }
}
