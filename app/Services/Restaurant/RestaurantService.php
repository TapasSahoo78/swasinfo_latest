<?php

namespace App\Services\RestaurantService;

use App\Contracts\Product\ProductContract;
use App\Contracts\RestaurantContract\RestaurantContract;

class RestaurantService
{
    /**
     * @var RestaurantContract
     */
    protected $restaurantRepository;

    /**
     * ProductService constructor
     */
        public function __construct(RestaurantContract $restaurantRepository)
    {
        $this->restaurantRepository = $restaurantRepository;
    }

    public function listProducts(array $filterConditions, string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->restaurantRepository->findProducts($filterConditions, $orderBy, $sortBy, $limit);
    }

    public function listVendor(array $filterConditions, string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->restaurantRepository->listVendor($filterConditions, $orderBy, $sortBy, $limit);
    }

    public function findProductById($id)
    {
        return $this->restaurantRepository->find($id);
    }
    public function findWishlistBYProductId($id)
    {
        return $this->restaurantRepository->find($id);
    }

    public function createOrUpdateProduct(array $attributes, $id = null)
    {
        if (is_null($id)) {
            return $this->restaurantRepository->createProduct($attributes);
        } else {
            return $this->restaurantRepository->updateProduct($attributes, $id);
        }
    }
    public function createWishlist(array $attributes)
    {
        return $this->restaurantRepository->createWishlist($attributes);
    }

    public function deleteWishlist(int $id)
    {
        return $this->restaurantRepository->deleteWishlist($id);
    }

    public function updateProductStatus($attributes, $id)
    {
        $attributes['is_active'] = $attributes['value'] == '1' ? 1 : 0;
        return $this->restaurantRepository->update($attributes, $id);
    }

    public function deleteProduct(int $id)
    {
        return $this->restaurantRepository->deleteProduct($id);
    }

    public function minPrice()
    {
        return $this->restaurantRepository->getMinPrice();
    }
    public function maxPrice()
    {
        return $this->restaurantRepository->getMaxPrice();
    }
}
