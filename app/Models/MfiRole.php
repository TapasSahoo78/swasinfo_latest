<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MfiRole extends Model
{
    use HasFactory;

    public static function boot()
    {
        parent::boot();
    }
    public $timestamps = false;

    protected $fillable = [
        'mfi_id',
        'role_id',
        'status'
    ];
    public function role(){
        return $this->belongsTo(Role::class);
    }
}
