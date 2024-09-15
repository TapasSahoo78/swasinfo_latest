<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymBooking extends Model
{
    use HasFactory;

    public function userDetails()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function gymCategory()
    {
        return $this->belongsTo(GymCategory::class, 'gym_category_id', 'id');
    }
    public function gymManage()
    {
        return $this->belongsTo(GymManagement::class, 'gym_management_id', 'id');
    }
}
