<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class PurposeBranches extends Model
{
    use HasFactory/* , SoftDeletes */;

    protected $fillable = [
        /* 'uuid', */
        'purpose_id',
        'branch_id',
      
    ];
    protected $table ="purposes_branches";

    /* public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
        });
    } */

   /*  public function purpose(){
        return $this->belongsTo(Purpose::class);
    }
    public function branch(){
        return $this->belongsTo(Branch::class);
    } */


    /* public function userBranch()
{
return $this->belongsToMany(UserBranch::class, 'user_branches');
} */
}
