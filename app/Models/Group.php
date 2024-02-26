<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Group extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'mfi_id',
        'branch_id',
        'leader_user_id',
        'code',
        'landmark',
        'city_name',
        'state_name',
        'full_address',
        'country_name',
        'zip_code',
        'frequency',
        'days',
        'status',
        'remarks',
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
            $query->agents()->detach();

        });
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'leader_user_id');
    }

    public function scopeListGroup($query)
    {
        $branchIds = getAllBranchIds();
        $query->where('mfi_id',auth()->user()->mfi->id);
        if(!empty($branchIds) && count($branchIds))
        {
            $query->whereIn('branch_id', $branchIds);
        }

        return $query;
    }

    public function agents()
    {
        return $this->belongsToMany(User::class, 'group_agents');
    }

    /* public function agents(){
    return $this->belongsToMany(Role::class,'mfi_roles');
    } */

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
