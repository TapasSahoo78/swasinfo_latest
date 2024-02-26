<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAddress extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_address';

    protected $fillable = [
        'user_id',
        'name',
        'mobile_number',
        'email',
        'address',
        'option_address',
        'pin_code',
        'county',
        'state',
        'city'
    ];
}