<?php

namespace App\Services\Occupation;

use App\Contracts\Occupation\OccupationContract;

class OccupationService
{
    /**
     * @var OccupationContract
     */
    protected $occupationRepository;

    /**
     * OccupationService constructor
     */
    public function __construct(OccupationContract $occupationRepository)
    {
        $this->occupationRepository = $occupationRepository;
    }
    public function listOccupation(array $filterConditions, string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->occupationRepository->listOccupation($filterConditions, $orderBy, $sortBy, $limit);
    }

    public function findOccupationById($id)
    {
        return $this->occupationRepository->find($id);
    }

    public function createOrUpdateOccupation(array $attributes, $id = null)
    {
        if (is_null($id)) {
            return $this->occupationRepository->createOccupation($attributes);
        } else {
            return $this->occupationRepository->updateOccupation($attributes, $id);
        }
    }
    
    public function updateOccupationStatus($attributes, $id)
    {
        $attributes['status'] = $attributes['value'] == '1' ? 1 : 0;
        return $this->occupationRepository->update($attributes, $id);
    }

    public function deleteOccupation(int $id)
    {
        return $this->occupationRepository->deleteOccupation($id);
    }
}
