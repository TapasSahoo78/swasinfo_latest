<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileQuestion extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function answers()
    {
        return $this->hasMany(ProfileAnswer::class);
    }
}
