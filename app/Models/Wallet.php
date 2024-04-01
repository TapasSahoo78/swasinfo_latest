<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    public function walletHistory()
    {
        return $this->hasMany(WalletTransaction::class);
    }
}
