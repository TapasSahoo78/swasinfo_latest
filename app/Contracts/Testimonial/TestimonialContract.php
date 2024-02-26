<?php

namespace App\Contracts\Testimonial;

/**
 * Interface PageContract
 * @package App\Contracts
 */
interface TestimonialContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listTestimonials(array $filterConditions, string $orderBy = 'id', string $sortBy = 'desc', $limit = null, $inRandomOrder = false);

    /**
     * @param array $attributes
     * @return mixed
     */

    public function createTestimonial(array $attributes);

    /**
     * @param array $attributes
     * @param int $id
     * @return mixed
     */

    public function updateTestimonial(array $attributes, int $id);

    /**
     * @param int $id
     * @return mixed
     */

    public function deleteTestimonial(int $id);
}
