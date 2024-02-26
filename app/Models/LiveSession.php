<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveSession extends Model
{
    protected $table = 'live_sessions';

    protected $fillable = [
        'trainer_id',
        'topic',
        'date_and_time',
        'status'
        // Add other fillable fields here
    ];

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }
}