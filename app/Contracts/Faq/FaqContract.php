<?php

namespace App\Contracts\Faq;

/**
 * Interface PageContract
 * @package App\Contracts
 */
interface FaqContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listFaqs(array $filterConditions, string $orderBy = 'id', string $sortBy = 'desc', $limit = null, $inRandomOrder = false);

    /**
     * @param array $attributes
     * @return mixed
     */

    public function createFaq(array $attributes);

    /**
     * @param array $attributes
     * @param int $id
     * @return mixed
     */

    public function updateFaq(array $attributes, int $id);
}
