<?php

namespace App\Services\Role;

use App\Contracts\Role\RoleContract;

class RoleService
{
    protected $roleRepository;

    /**
     * class InviteService constructor
     */
    public function __construct(RoleContract $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function findRoleById($id)
    {
        return $this->roleRepository->findById($id);
    }

    public function getList($start, $limit, $order, $dir, $search = null)
    {
        return $this->roleRepository->getList($start, $limit, $order, $dir, $search);
    }

    public function roleList(array $filterConditions)
    {
        return $this->roleRepository->roleList($filterConditions);
    }

    public function getTotalData($search = null)
    {
        return $this->roleRepository->getTotalData($search);
    }

    public function getPermissionList($start, $limit, $order, $dir, $search = null)
    {
        return $this->roleRepository->getPermissionList($start, $limit, $order, $dir, $search);
    }

    public function getTotalPermissionData($search = null)
    {
        return $this->roleRepository->getTotalPermissionData($search);
    }

    public function getAllPermissions()
    {
        return $this->roleRepository->getAllPermissions();
    }
    public function getSpecificPermissions()
    {
        return $this->roleRepository->getSpecifiedPermissions();
    }

    /* public function addRole(array $attributes)
    {
        return $this->roleRepository->createRole($attributes);
    } */

    public function createOrUpdateRole(array $attributes, $id = null)
    {
        if (is_null($id)) {
            return $this->roleRepository->createRole($attributes);
        } else {
            return $this->roleRepository->updateRole($attributes, $id);
        }
    }

    public function addPermission(array $attributes)
    {
        return $this->roleRepository->createPermission($attributes);
    }

    public function updateRoleStatus($attributes, $id)
    {
        $attributes['status'] = $attributes['value'] == '1' ? 1 : 0;
        return $this->roleRepository->update($attributes, $id);
    }
    public function updateMfiRoleStatus($attributes, $id)
    {
        $attributes['status'] = $attributes['value'] == '1' ? 1 : 0;
        return $this->roleRepository->updateMfiRole($attributes, $id);
    }

    public function deleteRole(int $id)
    {
        return $this->roleRepository->deleteRole($id);
    }

}
