<?php

namespace App\Repositories\Store;

use App\Contracts\Store\StoreContract;
use App\Models\Store;
use App\Repositories\BaseRepository;
use App\Traits\UploadAble;

/**
 * Class StoreRepository
 *
 * @package \App\Repositories
 */
class StoreRepository extends BaseRepository implements StoreContract
{
    use UploadAble;

    protected $model;
    /**
     * StoreRepository constructor.
     * @param Store $model
     */
    public function __construct(Store $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
    public function listStores($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $stores = $this->model;
        if (!is_null($filterConditions)) {
            $stores = $stores->where($filterConditions);
        }
        $stores = $stores->orderBy($orderBy, $sortBy);
        if (!is_null($limit)) {
            return $stores->paginate($limit);
        }
        return $stores->get();
    }
    public function createStore($attributes)
    {
        //$user_id = uuidtoid($attributes['user_id'], 'users');
        return $this->create($attributes);

    }

    public function updateStore($attributes, $id)
    {
        $storeData = $this->find($id);
        return $storeData->update($attributes);

    }
    public function findZipcode($zip_code){
        //return $this->wishlistModel->find($id);
        return  $this->model->where('zip_code', $zip_code)->get();
    }

    public function deleteStore($id)
    {
        return $this->delete($id);
    }
}
