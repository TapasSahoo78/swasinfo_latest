<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invitation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'email',
        'invitation_token',
        'role_id',
        'registered_at',
    ];

    /**
     * Generate invitation token
     */
    public function generateInvitationToken()
    {
        $this->invitation_token = substr(md5(rand(0, 9) . $this->email . time()), 0, 32);
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

    /**
     * Generate link for invitation
     *
     * @return string
     */
    public function getLink()
    {
        return urldecode(route('admin.register') . '?invitation_token=' . $this->invitation_token);
    }

}
