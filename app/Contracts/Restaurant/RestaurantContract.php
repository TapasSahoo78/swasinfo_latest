<?php

namespace App\Contracts\RestaurantContract;

/**
 * Interface AdsContract
 * @package App\Contracts
 */
interface RestaurantContract
{
    public function findProducts(array $filterConditions,string $orderBy='id',$sortBy='asc',$limit= null,$inRandomOrder= false);

    public function findProductById(int $id);

    public function createProduct(array $attributes);

    public function updateProduct(array $attributes, int $id);

    /* public function createWishlist(array $attributes);

    public function updateWishlist(array $attributes, int $id); */


}
