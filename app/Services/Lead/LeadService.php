<?php

namespace App\Services\Lead;

use App\Contracts\Lead\LeadContract;

class LeadService
{
    /**
     * @var LeadContract
     */
    protected $leadRepository;

    /**
     * LeadService constructor
     */
    public function __construct(LeadContract $leadRepository)
    {
        $this->leadRepository = $leadRepository;
    }
    public function listLeads(array $filterConditions, string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->leadRepository->listLeads($filterConditions, $orderBy, $sortBy, $limit);
    }

    public function findLeadById($id)
    {
        return $this->leadRepository->find($id);
    }

    public function createOrUpdateLead(array $attributes, $id = null)
    {
        if (is_null($id)) {
            return $this->leadRepository->createLead($attributes);
        } else {
            return $this->leadRepository->updateLead($attributes, $id);
        }
    }

    public function updateLeadStatus($attributes, $id)
    {
        $attributes['status'] = $attributes['value'] == '1' ? 1 : 0;
        return $this->leadRepository->update($attributes, $id);
    }

    public function leadVerify(array $attributes, int $id)
    {
            return $this->leadRepository->leadVerify($attributes, $id);
    }

    public function deleteLead(int $id)
    {
        return $this->leadRepository->deleteLead($id);
    }

}
