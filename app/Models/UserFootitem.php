<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserFootitem extends Model
{
    use SoftDeletes;

    protected $table = 'user_footitem';
    protected $fillable = ['user_id','trainer_id','foot_type','food','option_food','water','remarks'];
}