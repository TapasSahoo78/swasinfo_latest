<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfileOtherInformation extends Model
{
    use HasFactory, SoftDeletes;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }
    protected $fillable = [
        'uuid',
        'user_id',
        'do_you_have_any_allergies',
        'do_you_have_any_medical_condition',
        'diet_type',
        'allergies_type',
        'medical_condition_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // protected $casts =[
    //     'address' => 'array'
    // ];
}
