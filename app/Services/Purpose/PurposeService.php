<?php

namespace App\Services\Purpose;

use App\Contracts\Purpose\PurposeContract;

class PurposeService
{
    /**
     * @var PurposeContract
     */
    protected $purposeRepository;

    /**
     * PurposeService constructor
     */
    public function __construct(PurposeContract $purposeRepository)
    {
        $this->purposeRepository = $purposeRepository;
    }
    public function listPurpose(array $filterConditions, string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->purposeRepository->listPurpose($filterConditions, $orderBy, $sortBy, $limit);
    }

    public function findPurposeById($id)
    {
        return $this->purposeRepository->find($id);
    }

    public function createOrUpdatePurpose(array $attributes, $id = null)
    {
        if (is_null($id)) {
            return $this->purposeRepository->createPurpose($attributes);
        } else {
            return $this->purposeRepository->updatePurpose($attributes, $id);
        }
    }
    /* public function createMfiBranch(array $attributes, $id = null)
    {
        $attributes['name'] = $attributes['branch_name'];
        $attributes['code'] = $attributes['code'];
        $attributes['is_head_branch'] = 1;
        // return $attributes;
        if (is_null($id)) {
            return $this->branchRepository->createBranch($attributes);
        } else {
            return $this->branchRepository->updateBranch($attributes, $id);
        }
    } */
    public function updatePurposeStatus($attributes, $id)
    {
        $attributes['status'] = $attributes['value'] == '1' ? 1 : 0;
        return $this->purposeRepository->update($attributes, $id);
    }

    public function deletePurpose(int $id)
    {
        return $this->purposeRepository->deletePurpose($id);
    }
}
