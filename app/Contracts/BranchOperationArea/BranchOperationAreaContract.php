<?php

namespace App\Contracts\BranchOperationArea;

/**
 * Interface BranchContract
 * @package App\Contracts
 */
interface BranchOperationAreaContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listBranchOperationArea(array $filterConditions, string $orderBy = 'id', string $sortBy = 'desc', $limit = null, $inRandomOrder = false);

    /**
     * @param array $attributes
     * @return mixed
     */

    public function createBranchOperationArea(array $attributes);

    /**
     * @param array $attributes
     * @param int $id
     * @return mixed
     */

    public function updateBranchOperationArea(array $attributes, int $id);

    /**
     * @param int $id
     * @return mixed
     */

    public function deleteBranchOperationArea(int $id);
    
    
}
