<?php

namespace App\Contracts\Penalty;

/**
 * Interface PenaltyContract
 * @package App\Contracts
 */
interface PenaltyContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listPenalty(array $filterConditions, string $orderBy = 'id', string $sortBy = 'desc', $limit = null, $inRandomOrder = false);

    /**
     * @param array $attributes
     * @return mixed
     */

    /* public function createPenalty(array $attributes); */


    public function createCaseThreePenalty(array $attributes);

    public function updateCaseThreePenalty(array $attributes, int $id);
    /**
     * @param array $attributes
     * @param int $id
     * @return mixed
     */

    /* public function updatePenalty(array $attributes, int $id); */

    /**
     * @param int $id
     * @return mixed
     */

    /* public function deleteOccupation(int $id); */
}
