<?php

namespace App\Contracts\Enquiry;

/**
 * Interface EnquiryContract
 * @package App\Contracts
 */
interface EnquiryContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listEnquiry(array $filterConditions, string $orderBy = 'id', string $sortBy = 'desc', $limit = null, $inRandomOrder = false);

    /**
     * @param array $attributes
     * @return mixed
     */

    public function createEnquiry(array $attributes);

    /**
     * @param array $attributes
     * @param int $id
     * @return mixed
     */

    public function updateEnquiry(array $attributes, int $id);
    public function enquiryStatusChange(array $attributes, int $id);

    /**
     * @param int $id
     * @return mixed
     */

    public function deleteEnquiry(int $id);
}
