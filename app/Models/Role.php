<?php

namespace App\Models;

use App\Models\Permission;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Role extends Model
{

    use HasFactory, Sluggable, SoftDeletes;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    protected $fillable = [
        'name',
        'short_code',
        'slug',
        'description',
        'mfi_id',
        'is_default_role',
        'role_type',
        'status',
        'created_by',
        'updated_by',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'roles_permissions');
    }
    public function mfiPermissions()
    {
        return $this->hasMany(MfiRolesPermissions::class);
    }


    public function getAllPermissions(array $permissions)
    {
        return Permission::whereIn('slug', $permissions)->get();
    }
    public function getPermission($permission)
    {
        return Permission::where('slug', $permission)->first();
    }

    public function hasPermission($permission)
    {
        if(auth()->user()->hasRole('super-admin'))
        {
            return (bool) $this->permissions->where('slug', $permission)->count();
        }else
        {
            $permission_id =$this->getPermission($permission)->id;
            return (bool) $this->mfiPermissions->where('mfi_id', auth()->user()->mfi_id)->where('permission_id',$permission_id)->count();
        }
    }
    public function scopeListMfiRoles($query,$status=NULL)
    {
        $query->whereHas('mfiRole', function ($q) use ($status) {
             $q->where('mfi_id', auth()->user()->mfi->id);
            if($status)
            {
                $q->where('status',1);
            }
        });
    }

    public function givePermissionsTo($permissions)
    {
        // dd($permissions);
        $permissions = $this->getAllPermissions($permissions);
        if ($permissions === null) {
            return $this;
        }
        if(auth()->user()->hasRole('super-admin'))
        {
            $this->permissions()->saveMany($permissions);
        }else{
            foreach($permissions as $key=> $permission)
            {
                $data= ['mfi_id'=>auth()->user()->mfi_id,'permission_id'=>$permission->id,'role_id'=>$this->id];
                $this->mfiPermissions()->updateOrCreate($data,$data);
            }
        }
        return $this;
    }

    public function mfi() {
        return $this->hasMany(MfiRole::class,'role_id');
    }
    public function mfiRole() {
        return $this->hasMany(MfiRole::class,'role_id');
    }
    /*  public function mfi() {
        return $this->belongsToMany(MfiRole::class,'mfi_roles');
    } */

    /* public function userRole(){
        return $this->belongsToMany(UserRole::class,'user_roles');
    } */
}
