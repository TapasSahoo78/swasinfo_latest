<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;


class FitnessGoal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'title',
        'sub_title',
        'status',
        'created_at',
        'updated_at',
        /* 'created_by',
        'updated_by', */
        'deleted_at',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function fitnessActivations()
    {
        return $this->belongsToMany(User::class, 'user_fitness_activations');
    }
}
