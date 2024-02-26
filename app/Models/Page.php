<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
class Page extends Model
{
    use HasFactory,Sluggable,SoftDeletes;

    protected $table= 'pages';

    protected $guarded = [];

    /**
     * Morph relation with DB seos table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
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

    /* public function seo()    {
        return $this->morphOne(Seo::class, 'seoable');
    } */

}
