<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MfiRolesPermissions extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->mfi_id =auth()->user()->mfi_id;
        });
    }
    public function permission() {
        return $this->belongsTo(Permission::class,'permission_id');
    }

}
