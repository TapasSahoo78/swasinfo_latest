<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;
class Content extends Model
{
    use HasFactory,Sluggable;

    public static function boot()    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }
    public function sluggable(): array

    {

        return [

            'slug' => [

                'source' => 'name'

            ]

        ];
    }
    public function mediaable()
    {
        return $this->morphTo();
    }
}
