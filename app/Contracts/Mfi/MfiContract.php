<?php

namespace App\Contracts\Mfi;

/**
 * Interface MfiContract
 * @package App\Contracts
 */
interface MfiContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listMfi(array $filterConditions, string $orderBy = 'id', string $sortBy = 'desc', $limit = null, $inRandomOrder = false);
    public function getTotalData($search = null);

    /**
     * @param $start
     * @param $limit
     * @param $order
     * @param $dir
     * @param null $search
     * @return mixed
     */
    public function getList($start, $limit, $order, $dir, $search = null);
    /**
     * @param array $attributes
     * @return mixed
     */

    public function createMfi(array $attributes);

    /**
     * @param array $attributes
     * @param int $id
     * @return mixed
     */

    public function updateMfi(array $attributes, int $id);

    /**
     * @param int $id
     * @return mixed
     */

    public function deleteMfi(int $id);
}
