<?php

namespace App\Contracts\Store;

/**
 * Interface PageContract
 * @package App\Contracts
 */
interface StoreContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listStores(array $filterConditions, string $orderBy = 'id', string $sortBy = 'desc', $limit = null, $inRandomOrder = false);

    /**
     * @param array $attributes
     * @return mixed
     */

    public function createStore(array $attributes);

    /**
     * @param array $attributes
     * @param int $id
     * @return mixed
     */

    public function updateStore(array $attributes, int $id);

    /**
     * @param int $id
     * @return mixed
     */

    public function deleteStore(int $id);
}
