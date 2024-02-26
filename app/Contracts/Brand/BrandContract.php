<?php

namespace App\Contracts\Brand;

/**
 * Interface PageContract
 * @package App\Contracts
 */
interface BrandContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listBrands(array $filterConditions,string $orderBy = 'id', string $sortBy = 'desc', $limit= null,$inRandomOrder= false);

    /**
     * @param array $attributes
     * @return mixed
     */


    public function createBrand(array $attributes);

    /**
     * @param array $attributes
     * @param int $id
     * @return mixed
     */

    public function updateBrand(array $attributes, int $id);

    /**
     * @param int $id
     * @return mixed
     */

    public function deleteBrand(int $id);
}
