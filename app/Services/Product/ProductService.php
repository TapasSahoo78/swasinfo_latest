<?php

namespace App\Services\Product;

use App\Contracts\Product\ProductContract;

class ProductService
{
    /**
     * @var ProductContract
     */
    protected $productRepository;

    /**
     * ProductService constructor
     */
    public function __construct(ProductContract $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function listProducts(array $filterConditions, string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->productRepository->findProducts($filterConditions, $orderBy, $sortBy, $limit);
    }

    public function listVendor(array $filterConditions, string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->productRepository->listVendor($filterConditions, $orderBy, $sortBy, $limit);
    }

    public function findProductById($id)
    {
        return $this->productRepository->find($id);
    }
    public function findWishlistBYProductId($id)
    {
        return $this->productRepository->find($id);
    }

    public function createOrUpdateProduct(array $attributes, $id = null)
    {
        if (is_null($id)) {
            return $this->productRepository->createProduct($attributes);
        } else {
            return $this->productRepository->updateProduct($attributes, $id);
        }
    }
    public function createWishlist(array $attributes)
    {
        return $this->productRepository->createWishlist($attributes);
    }

    public function deleteWishlist(int $id)
    {
        return $this->productRepository->deleteWishlist($id);
    }

    public function updateProductStatus($attributes, $id)
    {
        $attributes['is_active'] = $attributes['value'] == '1' ? 1 : 0;
        return $this->productRepository->update($attributes, $id);
    }

    public function deleteProduct(int $id)
    {
        return $this->productRepository->deleteProduct($id);
    }

    public function minPrice()
    {
        return $this->productRepository->getMinPrice();
    }
    public function maxPrice()
    {
        return $this->productRepository->getMaxPrice();
    }
}
