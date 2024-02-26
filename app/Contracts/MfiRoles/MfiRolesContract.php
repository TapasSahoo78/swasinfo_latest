<?php

namespace App\Contracts\MfiRoles;

/**
 * Interface MfiRolesContract
 * @package App\Contracts
 */
interface MfiRolesContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listMfiRoles(array $filterConditions, string $orderBy = 'id', string $sortBy = 'desc', $limit = null, $inRandomOrder = false);

    /**
     * @param array $attributes
     * @return mixed
     */

    public function createMfiRoles(array $attributes);

    /**
     * @param array $attributes
     * @param int $id
     * @return mixed
     */

    public function updateMfiRoles(array $attributes, int $id);

    /**
     * @param int $id
     * @return mixed
     */

    public function deleteMfiRoles(int $id);
}
