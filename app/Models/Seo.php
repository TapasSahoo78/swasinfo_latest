<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Seo extends Model
{
    use SoftDeletes,HasFactory;

    protected $guarded = [];
    protected $table= 'seos';
    protected $casts = [
        'body' => 'array'
    ];

    /**
     * Get all of the models that own seos.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function seoable()
    {
        return $this->morphTo();
    }
}
