<?php

namespace App\Services\MfiRoles;

use App\Contracts\MfiRoles\MfiRolesContract;

class MfiRolesService
{
    /**
     * @var MfiRolesContract
     */
    protected $mfiRolesRepository;

    /**
     * MfiRolesService constructor
     */
    public function __construct(MfiRolesContract $mfiRolesRepository)
    {
        $this->mfiRolesRepository = $mfiRolesRepository;
    }
    public function listMfiRoles(array $filterConditions, string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->mfiRolesRepository->listMfiRoles($filterConditions, $orderBy, $sortBy, $limit);
    }

    public function findMfiRoleById($id)
    {
        return $this->mfiRolesRepository->find($id);
    }

    public function createOrUpdateMfiRole(array $attributes, $id = null)
    {
        if (is_null($id)) {
            return $this->mfiRolesRepository->createMfiRoles($attributes);
        } else {
            return $this->mfiRolesRepository->updateMfiRoles($attributes, $id);
        }
    }

    public function updateMfiRoleStatus($attributes, $id)
    {
        $attributes['status'] = $attributes['value'] == '1' ? 1 : 0;
        return $this->mfiRolesRepository->update($attributes, $id);
    }

    public function deleteMfiRoles(int $id)
    {
        return $this->mfiRolesRepository->deleteMfiRoles($id);
    }
}
