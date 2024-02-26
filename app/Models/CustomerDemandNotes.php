<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class CustomerDemandNotes extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'mfi_id',
        'demand_id',
        'notes',
        'demand_status',
        'disbursement_status',
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

    public function demand()
    {
        return $this->belongsTo(CustomerDemand::class,'demand_id');
    }

    // public function enquiry()
    // {
    //     return $this->belongsTo(Enquiry::class);
    // }

    /* public function userBranch()
    {
    return $this->belongsToMany(UserBranch::class, 'user_branches');
    } */

    /* public function branchPurposes(){
return $this->hasMany(PurposeBranches::class);
} */
}
