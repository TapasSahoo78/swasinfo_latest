<?php

namespace App\Models;

use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Permission extends Model
{

    use Sluggable;
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    protected $fillable =[
        'name'
    ];

    public function scopeNotDashboard($query){
        return $query->whereNotIn('slug', ['view-dashboard','view-delivery','edit-delivery']);
    }
    public function scopeNotMfi($query){
        return $query->whereNotIn('slug', ['view-dashboard','view-mfi','add-mfi','edit-mfi','delete-mfi','add_branch']);
    }

    public function roles() {
        return $this->belongsToMany(Role::class,'roles_permissions');
    }
    public function mfiRoles() {
        return $this->belongsToMany(Role::class,'mfi_roles_permissions');
    }
}
