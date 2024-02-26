<?php

namespace App\Services\Branch;

use App\Contracts\Branch\BranchContract;
use App\Contracts\BranchOperationArea\BranchOperationAreaContract;

use App\Repositories\BranchOperationArea\BranchOperationAreaRepository;

class BranchService
{
    /**
     * @var BranchContract
     */
    protected $branchRepository;
    protected $branchOperationAreaRepository;

    /**
     * BranchService constructor
     */
    public function __construct(BranchContract $branchRepository,BranchOperationAreaContract $branchOperationAreaRepository)
    {
        $this->branchRepository = $branchRepository;
        $this->branchOperationAreaRepository = $branchOperationAreaRepository;
    }
    public function listBranch(array $filterConditions, string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->branchRepository->listBranch($filterConditions,$orderBy, $sortBy, $limit);
    }

    public function findBranchById($id)
    {
        return $this->branchRepository->find($id);
    }

    public function createOrUpdateBranch(array $attributes, $id = null)
    {

        if (is_null($id)) {
            return $this->branchRepository->createBranch($attributes);
        } else {
            return $this->branchRepository->updateBranch($attributes, $id);
        }
    }
    public function createOrUpdateBranchOperationArea(array $attributes, $id = null)
    {
        //$attributes['states_name'] = $attributes['states_name'];
        $attributes['cities_name'] = json_encode($attributes['cities_name']);
        $attributes['zip_codes']   = json_encode($attributes['zip_codes']);

        if (is_null($id)) {
            return $this->branchOperationAreaRepository->createBranchOperationArea($attributes);
        } else {
            return $this->branchOperationAreaRepository->updateBranchOperationArea($attributes, $id);
        }
    }
    public function createMfiBranch(array $attributes, $id = null)
    {
        $attributes['name']= $attributes['branch_name'];
        $attributes['is_head_branch']=1;
        // return $attributes;
        if (is_null($id)) {
            return $this->branchRepository->createBranch($attributes);
        } else {
            return $this->branchRepository->updateBranch($attributes, $id);
        }
    }
    public function updateBranchStatus($attributes, $id)
    {
        $attributes['status'] = $attributes['value'] == '1' ? 1 : 0;
        return $this->branchRepository->update($attributes, $id);
    }

    public function deleteBranch(int $id)
    {
        return $this->branchRepository->deleteBranch($id);
    }
}
