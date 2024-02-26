<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class UserBranch extends Model
{
    use HasFactory ;

    public static function boot()
    {
        parent::boot();
    }

    protected $fillable = [
        'user_id',
        'branch_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function branch(){
        return $this->belongsTo(Branch::class);
    }
}
