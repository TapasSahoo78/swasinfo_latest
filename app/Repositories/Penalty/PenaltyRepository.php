<?php

namespace App\Repositories\Penalty;

use App\Contracts\Penalty\PenaltyContract;
use App\Models\Media;
use App\Models\PenaltySetting;
use App\Repositories\BaseRepository;
use App\Traits\UploadAble;

/**
 * Class PenaltyRepository
 *
 * @package \App\Repositories
 */
class PenaltyRepository extends BaseRepository implements PenaltyContract
{
    use UploadAble;

    protected $model;
    /**
     * BrandRepository constructor.
     * @param PenaltySetting $model
     * @param Media $mediaModel
     */
    public function __construct(PenaltySetting $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
    public function listPenalty($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $penalty = $this->model;
        if (!is_null($filterConditions)) {
            $penalty = $penalty->where($filterConditions);
        }
        $occupation = $penalty->orderBy($orderBy, $sortBy);
        if (!is_null($limit)) {
            return $occupation->paginate($limit);
        }
        return $occupation->get();
    }
    public function createCaseThreePenalty($attributes)
    {
        $attributes['created_by'] = auth()->user()->id;
        $attributes['updated_by'] = auth()->user()->id;
        $attributes['mfi_id'] = auth()->user() ? auth()->user()->mfi_id : null;
        $attributes['penalty_type'] = $attributes['ptype'];
        $attributes['case_type'] = $attributes['ctype'];
        $attributes['penalty_amount'] = $attributes['amount'];
        $isPenaltyThirdcaseCreated = $this->create($attributes);
        return $isPenaltyThirdcaseCreated;
    }

    public function updateCaseThreePenalty($attributes, $id)
    {
        $penaltyCaseThreeData = $this->find($id);
        $attributes['updated_by'] = auth()->user()->id;
        $attributes['penalty_amount'] = $attributes['amount'];

        $ispenaltyCaseThreeDataUpdated = $this->update($attributes, $id);

        return $penaltyCaseThreeData;
    }

    /* public function deleteOccupation($id)
    {
        $occupationData = $this->find($id);
        //$branchData->media()->delete();
        return $occupationData->delete();
    } */
}
