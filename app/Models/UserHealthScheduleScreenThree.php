<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class UserHealthScheduleScreenThree extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'user_id',
        'do_you_take_any_medication',
        'have_you_been_recently_hospitalized',
        'do_you_suffer_from_asthma',
        'do_you_have_high_uric_acid',
        'do_you_have_diabities',
        'do_you_have_high_cholesterol',
        'do_you_suffer_from_high_or_low_blood_pressure',
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
