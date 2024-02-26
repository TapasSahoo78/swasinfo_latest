<?php

namespace App\Contracts\Purpose;

/**
 * Interface PurposeContract
 * @package App\Contracts
 */
interface PurposeContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listPurpose(array $filterConditions, string $orderBy = 'id', string $sortBy = 'desc', $limit = null, $inRandomOrder = false);

    /**
     * @param array $attributes
     * @return mixed
     */

    public function createPurpose(array $attributes);

    /**
     * @param array $attributes
     * @param int $id
     * @return mixed
     */

    public function updatePurpose(array $attributes, int $id);

    /**
     * @param int $id
     * @return mixed
     */

    public function deletePurpose(int $id);
}
