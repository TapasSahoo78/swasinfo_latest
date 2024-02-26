<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Media extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'medias';

    protected $fillable = [
        'uuid',
        'user_id',
        'mediaable_type',
        'reference_type',
        'mediaable_id',
        'media_type',
        'file',
        'alt_text',
        'is_profile_picture',
        'is_logo',
        'is_prescription',
        'is_aadhaar',
        'is_location',
        'meta_details',
        'is_low_blood_pressure_prescription',
        'is_high_cholesterol_prescription',
        'is_diabities_prescription',
        'is_uric_acid_prescription',
        'is_asthma_prescription',
        'is_medication_prescription'
    ];

    protected $casts = [
        'meta_details' => array()
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function mediaable()
    {
        return $this->morphTo();
    }
}
