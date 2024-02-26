<?php

namespace App\Services\Store;

use App\Contracts\Store\StoreContract;

class StoreService
{
    /**
     * @var StoreContract
     */
    protected $storeRepository;

    /**
     * BlogService constructor
     */
    public function __construct(StoreContract $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }
    public function listStores(array $filterConditions, string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->storeRepository->listStores($filterConditions, $orderBy, $sortBy, $limit, $inRandomOrder);
    }

    public function findStoreById($id)
    {
        return $this->storeRepository->find($id);
    }

    public function findZipcode($zip_code)
    {
        return $this->storeRepository->findZipcode($zip_code);
    }

    public function createOrUpdateStore(array $attributes, $id = null)
    {
        if (is_null($id)) {
            return $this->storeRepository->createStore($attributes);
        } else {
            return $this->storeRepository->updateStore($attributes, $id);
        }
    }
    public function updateStoreStatus($attributes, $id)
    {
        $attributes['is_active'] = $attributes['value'] == '1' ? 1 : 0;
        return $this->storeRepository->update($attributes, $id);
    }

    public function deleteStore(int $id)
    {
        return $this->storeRepository->deleteStore($id);
    }
}
