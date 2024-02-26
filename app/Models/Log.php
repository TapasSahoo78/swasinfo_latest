<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = ['screen_name', 'time_spend', 'device_id','user_id'];
    // Assuming the table name is 'logs' by convention
    protected $table = 'logs';
}
