<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerDetail extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'gender',
        'age',
        'preffered_language',
        'expertise',
        'qualification_name',
        'intro',
        'ac_no',
        'reenter_ac_no',
        'ifsc_code',
        'bank_name',
        'profile_picture_file',
        'qualification_file',
        'bank_check_file',
        'id_proof_file',
        'day',
        'slot_select'

    ];
}
