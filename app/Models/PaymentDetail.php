<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'transaction_id',
        'payment_by',
        'payment_information',
        'is_refund',
        'refund_details',
        'stripe_transaction_id',
        'stripe_receipt_url',
        'is_all_active',
        'created_at',
        'updated_at',
    ];

    protected $table = 'payment_details';
}