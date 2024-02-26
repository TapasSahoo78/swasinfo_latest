<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VersionControl extends Model
{
    protected $fillable = [
        'version', 'device', 'update_type', 'release_date'
    ];

}
