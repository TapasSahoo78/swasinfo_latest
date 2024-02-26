<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReviewAttribute extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'review_id',
        'name',
        'rating',
    ];
    public function review(){
        return $this->belongsTo(Review::class);
    }
    /* public function reviewAttributes(){
        return $this->morphMany(Review::class,'reviewable');
    } */
}
