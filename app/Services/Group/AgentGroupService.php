<?php

namespace App\Services\Group;

use App\Contracts\Group\AgentGroupContract;

class AgentGroupService
{
    /**
     * @var AgentGroupContract
     */
    protected $agentGroupRepository;

    /**
     * PurposeService constructor
     */
    public function __construct(AgentGroupContract $agentGroupRepository)
    {
        $this->agentGroupRepository = $agentGroupRepository;
    }
    public function listGroup(array $filterConditions, string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->agentGroupRepository->listGroup($filterConditions, $orderBy, $sortBy, $limit);
    }

     public function findGroupById($id)
    {
        return $this->agentGroupRepository->find($id);
    }

    public function createOrUpdateGroup(array $attributes, $id = null)
    {
        if (is_null($id)) {
            return $this->agentGroupRepository->createGroup($attributes);
        } else {
            return $this->agentGroupRepository->updateGroup($attributes, $id);
        }
    }

    public function updateGroupStatus($attributes, $id)
    {
        $attributes['status'] = $attributes['value'] == '1' ? 1 : 0;
        return $this->agentGroupRepository->update($attributes, $id);
    }

    public function deleteGroup(int $id)
    {
        return $this->agentGroupRepository->deleteGroup($id);
    }
}
