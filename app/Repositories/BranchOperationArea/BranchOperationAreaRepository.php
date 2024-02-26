<?php

namespace App\Repositories\BranchOperationArea;

use App\Contracts\BranchOperationArea\BranchOperationAreaContract;
use App\Models\BranchOperationArea;
use App\Models\Media;
use App\Repositories\BaseRepository;
use App\Traits\UploadAble;
use App\Models\Role;
/**
 * Class BranchOperationAreaRepository
 *
 * @package \App\Repositories
 */
class BranchOperationAreaRepository extends BaseRepository implements BranchOperationAreaContract
{
    use UploadAble;

    protected $model;
    /**
     * BrandRepository constructor.
     * @param BranchOperationArea $model
     * @param Media $mediaModel
     */
    public function __construct(BranchOperationArea $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
    public function listBranchOperationArea($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $branchOperationArea = $this->model;
        if (!is_null($filterConditions)) {
            $branchOperationArea = $branchOperationArea->where($filterConditions);
        }
        $branchOperationArea = $branchOperationArea->orderBy($orderBy, $sortBy);
        if (!is_null($limit)) {
            return $branchOperationArea->paginate($limit);
        }
        return $branchOperationArea->get();
    }
    public function createBranchOperationArea($attributes)
    {

        $attributes['mfi_id'] = !empty($attributes['mfi_id']) ? $attributes['mfi_id'] : auth()->user()->mfi_id;
        $isBranchOperationAreaCreated = $this->create($attributes);
        if ($isBranchOperationAreaCreated) {

        }
        return $isBranchOperationAreaCreated;
    }

    public function updateBranchOperationArea($attributes, $id)
    {
        $branchOperationAreaData = $this->find($id);
        $isBranchOperationAreaUpdated = $this->update($attributes, $id);

        return $branchOperationAreaData;
    }

    public function deleteBranchOperationArea($id)
    {
        $branchOperationAreaData = $this->find($id);

        return $branchOperationAreaData->delete();
    }
}
