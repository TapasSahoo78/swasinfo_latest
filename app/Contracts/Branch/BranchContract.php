<?php

namespace App\Contracts\Branch;

/**
 * Interface BranchContract
 * @package App\Contracts
 */
interface BranchContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listBranch(array $filterConditions, string $orderBy = 'id', string $sortBy = 'desc', $limit = null, $inRandomOrder = false);

    /**
     * @param array $attributes
     * @return mixed
     */

    public function createBranch(array $attributes);

    /**
     * @param array $attributes
     * @param int $id
     * @return mixed
     */

    public function updateBranch(array $attributes, int $id);

    /**
     * @param int $id
     * @return mixed
     */

    public function deleteBranch(int $id);
}
