<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanEmi extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'loan_id',
        'mfi_id',
        'number_of_week',
        'emi_amount',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public function loan(){
        return $this->belongsTo(Loan::class);
    }
}
