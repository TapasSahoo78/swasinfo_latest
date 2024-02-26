<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class CustomerPersonalDetail extends Model
{
    use HasFactory, SoftDeletes;
    // protected $guarded = [];

    protected $fillable = [
        'uuid',
        'user_id',
        'mfi_id',
        'loan_id',
        'loan_group',
        'aadhaar_no',
        'alternative_phone',
        'address',
        'aadhaar_address',
        'landmark',
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
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
