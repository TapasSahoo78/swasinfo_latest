<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiHit extends Model
{
    protected $table = 'api_hits'; // Define the table name

    protected $fillable = [
        'user_id',
        'route',
        'method',
        'ip_address',
        'request_page',
        'created_at',
    ];

    // Define relationships or additional configurations here if needed
}