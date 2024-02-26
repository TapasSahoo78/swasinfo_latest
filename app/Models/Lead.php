<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Lead extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'mfi_id',
        'name',
        'branch_id',
        'group_id',
        'agent_id',
        'email',
        'is_customer',
        'phone',
        'aadhaar_no',
        'address',
        'country_name',
        'state_name',
        'city_name',
        'zip_code',
        'landmark',
        'note',
        'is_verified',
        'verified_at',
        'verified_note',
        'verified_by',
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
    }
    public function enquiry(){
        return $this->hasOne(Enquiry::class);
    }
    public function loan()
    {
        return $this->belongsTo(Loan::class,'loan_id');
    }
    public function branch(){
        return $this->belongsTo(Branch::class);
    }
    public function scopeListLead($query)
    {
        $branchIds = getAllBranchIds();
        $query->where('is_customer',0)->where('mfi_id',auth()->user()->mfi->id);
        if(!empty($branchIds) && count($branchIds))
        {
            $query->whereIn('branch_id', $branchIds);
        }

        return $query;
    }

    /* public function loan(){
        return $this->belongsTo(Loan::class);
    } */



    /* public function userBranch()
    {
        return $this->belongsToMany(UserBranch::class, 'user_branches');
    } */

    /* public function branchPurposes(){
return $this->hasMany(PurposeBranches::class);
} */
}
