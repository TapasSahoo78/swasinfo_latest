<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\AttributeValue;

class Plan extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    protected $table = 'plans';

    protected $fillable = [
        'uuid',
        'plan_category_id',
        'name',
        'price',
        'frequently_purchased_title',
        'expiry_date',
        'day_validity',
        'status',
        'created_by',
        'updated_by'

    ];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function attributeValue()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'plan_courses');
    }
}
