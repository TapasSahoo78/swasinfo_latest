<?php

namespace App\Services\Mfi;

use App\Contracts\Mfi\MfiContract;

class MfiService
{
    /**
     * @var MfiContract
     */
    protected $mfiRepository;

    /**
     * BlogService constructor
     */
    public function __construct(MfiContract $mfiRepository)
    {
        $this->mfiRepository = $mfiRepository;
    }

    public function getTotalData($search=null)
    {
        return $this->mfiRepository->getTotalData($search);
    }

    public function listMfi(array $filterConditions, string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->mfiRepository->listMfi($filterConditions, $orderBy, $sortBy, $limit, $inRandomOrder);
    }

    public function getList($start, $limit, $order, $dir, $search=null)
    {
        return $this->mfiRepository->getList($start, $limit, $order, $dir, $search);
    }

    public function findMfiById($id)
    {
        return $this->mfiRepository->find($id);
    }

    public function createOrUpdateMfi(array $attributes, $id = null)
    {
        if (is_null($id)) {
            return $this->mfiRepository->createMfi($attributes);
        } else {
            return $this->mfiRepository->updateMfi($attributes, $id);
        }
    }
    public function updateMfiStatus($attributes, $id)
    {
        $attributes['status'] = $attributes['value'] == '1' ? 1 : 0;
        return $this->mfiRepository->update($attributes, $id);
    }

    public function deleteMfi(int $id)
    {
        return $this->mfiRepository->deleteMfi($id);
    }
}
