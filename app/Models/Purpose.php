<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Purpose extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'mfi_id',
        /* 'lone_type_id', */
        'name',
        'note',
        'status',
        /* 'is_repayment', */
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted_at',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
        /* static::deleting(function ($model) 
        {
            $model->purposeBranches()->delete();
        }); */

    }

    /* public function branches()
    {
        return $this->belongsToMany(Branch::class, 'purposes_branches');
    }

    public function loan(){
        return $this->belongsTo(Loan::class,'lone_type_id');
    }
    public function purposeBranches(){
        return $this->hasMany(PurposeBranches::class);
    } */

    /* public function userBranch()
{
return $this->belongsToMany(UserBranch::class, 'user_branches');
} */
}
