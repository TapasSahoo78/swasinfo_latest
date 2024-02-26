<?php

namespace App\Contracts\Occupation;

/**
 * Interface OccupationContract
 * @package App\Contracts
 */
interface OccupationContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listOccupation(array $filterConditions, string $orderBy = 'id', string $sortBy = 'desc', $limit = null, $inRandomOrder = false);

    /**
     * @param array $attributes
     * @return mixed
     */

    public function createOccupation(array $attributes);

    /**
     * @param array $attributes
     * @param int $id
     * @return mixed
     */

    public function updateOccupation(array $attributes, int $id);

    /**
     * @param int $id
     * @return mixed
     */

    public function deleteOccupation(int $id);
}
