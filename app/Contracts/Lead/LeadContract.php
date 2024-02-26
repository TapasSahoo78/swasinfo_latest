<?php

namespace App\Contracts\Lead;

/**
 * Interface LeadContract
 * @package App\Contracts
 */
interface LeadContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listLeads(array $filterConditions, string $orderBy = 'id', string $sortBy = 'desc', $limit = null, $inRandomOrder = false);

    /**
     * @param array $attributes
     * @return mixed
     */

    public function createLead(array $attributes);

    /**
     * @param array $attributes
     * @param int $id
     * @return mixed
     */

    public function updateLead(array $attributes, int $id);


    public function leadVerify(array $attributes, int $id);


    /**
     * @param int $id
     * @return mixed
     */

    public function deleteLead(int $id);
}
