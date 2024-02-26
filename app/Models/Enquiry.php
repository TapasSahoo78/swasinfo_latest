<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Enquiry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'mfi_id',
        'message',
        'lead_id',
        'branch_id',
        'loan_id',
        'min_amount',
        'max_amount',
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

    public function lead(){
        return $this->belongsTo(Lead::class);
    }
    public function loan(){
        return $this->belongsTo(Loan::class);
    }

    public function note(){
        return $this->hasOne(EnquiryNotes::class);
    }
    /* public function scopeListEnquiry($query)
    {
        $branchIds = getAllBranchIds();
        $query->where('mfi_id',auth()->user()->mfi->id);
        if(!empty($branchIds) && count($branchIds))
        {
            $query->whereIn('branch_id', $branchIds);
        }

        return $query;
    } */

    /* public function userBranch()
    {
        return $this->belongsToMany(UserBranch::class, 'user_branches');
    } */

    /* public function branchPurposes(){
return $this->hasMany(PurposeBranches::class);
} */
}
