<?php

namespace App\Contracts\Group;

/**
 * Interface PurposeContract
 * @package App\Contracts
 */
interface AgentGroupContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listGroup(array $filterConditions, string $orderBy = 'id', string $sortBy = 'desc', $limit = null, $inRandomOrder = false);

   /**
     * @param array $attributes
     * @return mixed
     */

    public function createGroup(array $attributes);

    /**
     * @param array $attributes
     * @param int $id
     * @return mixed
     */

    public function updateGroup(array $attributes, int $id);

    /**
     * @param int $id
     * @return mixed
     */

    public function deleteGroup(int $id);


}
