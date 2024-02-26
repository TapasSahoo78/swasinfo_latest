<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'code',
        'is_head_branch',
        'mfi_id',
        'landmark',
        'city_name',
        'state_name',
        'full_address',
        'country_name',
        'zip_code',
        'status',
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
        self::deleting(function ($query) { // before delete() method call this
            $query->oprationArea()->delete();
        });

    }

    public function userBranch()
    {
        return $this->belongsToMany(UserBranch::class, 'user_branches');
    }

    public function oprationArea()
    {
        return $this->hasOne(BranchOperationArea::class, 'branch_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'branch_roles');
    }

    /* public function branchPurposes(){
return $this->hasMany(PurposeBranches::class);
} */
}
