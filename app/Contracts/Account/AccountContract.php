<?php

namespace App\Contracts\Account;

/**
 * Interface AccountContract
 * @package App\Contracts
 */
interface AccountContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listAccount(array $filterConditions, string $orderBy = 'id', string $sortBy = 'desc', $limit = null, $inRandomOrder = false);

    /**
     * @param array $attributes
     * @return mixed
     */

    public function createAccount(array $attributes);

    /**
     * @param array $attributes
     * @param int $id
     * @return mixed
     */

    public function updateAccount(array $attributes, int $id);

    /**
     * @param int $id
     * @return mixed
     */

    public function deleteAccount(int $id);
}
