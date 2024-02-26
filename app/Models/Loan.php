<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Loan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'mfi_id',
        'name',
        'code',
        'maturity_amount',
        'principal_amount',
        'applicability',
        'tenure',
        // 'no_of_kist',
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
            $query->loanEmis()->delete();
        });

    }

    public function loanEmis()
    {
        return $this->hasMany(LoanEmi::class);
    }
    public function enquiry()
    {
        return $this->hasOne(Enquiry::class);
    }
   

    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'loan_branches');
    }
    public function loanBranches()
    {
        return $this->hasMany(LoanBranch::class, 'loan_id');
    }
    
    public function scopeListLoans($query)
    {
        $branch_ids = getAllBranchIds();
        $query->where('mfi_id',auth()->user()->mfi->id)->whereHas('branches', function ($q) use ($branch_ids) {
            $q->whereIn('branch_id', $branch_ids);
        });
    }
}
