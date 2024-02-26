<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory,SoftDeletes;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    protected $fillable=[
        'uuid',
        'user_id',
        'reviewable_id',
        'reviewable_type',
        'description',
        'overall_rating',
        'status',
        'created_by',
        'updated_by'
    ];

    public function attributes(){
        return $this->hasMany(ReviewAttribute::class);
    }
    public function reviewable(){
        return $this->morphTo();
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
