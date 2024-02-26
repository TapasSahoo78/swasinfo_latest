<?php
namespace App\Traits;

use App\Models\Role;
use App\Models\Permission;
trait HasRolesAndPermissions
{
    /**
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class,'users_roles');
    }

    /**
     * @return mixed
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'users_permissions');
    }

    /**
     * @param mixed ...$roles
     * @return bool
     */
    public function hasRole(... $roles ) {
        foreach ($roles as $role) {
            if ($this->roles->contains('slug', $role)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        return (bool) $this->permissions->where('slug', $permission->slug)->count();
    }
    public function hasUserPermission($slug)
    {
         return (bool) $this->permissions->where('slug', $slug)->count();
    }
    /**
     * @param $permission
     * @return bool
     */
    public function hasPermissionTo($permission)
    {
        if($this->hasRole('super-admin'))
        {
            return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
        }else
        {
            return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
        }
    }

    /**
     * @param $permission
     * @return bool
     */
    public function hasPermissionThroughRole($permission)
    {
        foreach ($permission->roles as $role){
            if($this->roles->contains($role)) {
                return true;
            }
        }
        return false;
    }
    /**
     * @param $permission
     * @return bool
     */
    public function hasPermissionThroughMfiRole($permission)
    {
        foreach ($permission->mfiRoles as $role){
            $tempRole = collect($role);
            if($tempRole->where('mfi_id',auth()->user()->mfi_id)->where('slug',$role)->isEmpty()){
                return true;
            }
        }
        return false;
    }

    /**
     * @param array $permissions
     * @return mixed
     */
    public function getAllPermissions(array $permissions)
    {
        return Permission::whereIn('slug',$permissions)->get();
    }

    /**
     * @param mixed ...$permissions
     * @return $this
     */
    public function givePermissionsTo($permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        if($permissions === null) {
            return $this;
        }
        $this->permissions()->saveMany($permissions);
        return $this;
    }

    /**
     * @param mixed ...$permissions
     * @return $this
     */
    public function deletePermissions(... $permissions )
    {
        $permissions = $this->getAllPermissions($permissions);
        $this->permissions()->detach($permissions);
        return $this;
    }

    /**
     * @param mixed ...$permissions
     * @return HasRolesAndPermissions
     */
    public function refreshPermissions(... $permissions )
    {
        $this->permissions()->detach();
        return $this->givePermissionsTo($permissions);
    }
}
