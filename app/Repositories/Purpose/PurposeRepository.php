<?php

namespace App\Repositories\Purpose;

use App\Contracts\Purpose\PurposeContract;
use App\Models\Media;
use App\Models\Purpose;
use App\Models\PurposeBranches;
use App\Repositories\BaseRepository;
use App\Traits\UploadAble;

/**
 * Class BranchRepository
 *
 * @package \App\Repositories
 */
class PurposeRepository extends BaseRepository implements PurposeContract
{
    use UploadAble;

    protected $model;
    protected $purposeBranchesModel;
    /**
     * BrandRepository constructor.
     * @param Purpose $model
     * @param Media $mediaModel
     * @param PurposeBranches $purposeBranchesModel
     */
    public function __construct(Purpose $model, PurposeBranches $purposeBranchesModel)
    {
        parent::__construct($model);
        $this->model = $model;
        $this->purposeBranchesModel = $purposeBranchesModel;

    }
    public function listPurpose($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $purpose = $this->model;
        if (!is_null($filterConditions)) {
            foreach($filterConditions as $fKey => $fCondition){
                if ($fKey == 'purpose_name') {
                    $purpose = $purpose->where(function ($query) use ($fCondition) {
                        $query->where('name', 'LIKE', "%$fCondition%");
                    });
                }else{
                    $purpose = $purpose->where($fKey, $fCondition);
                }
            }
        }
        $purpose = $purpose->orderBy($orderBy, $sortBy);
        if (!is_null($limit)) {
            return $purpose->paginate($limit);
        }
        return $purpose->get();
    }
    public function createPurpose($attributes)
    {
        /* $loane_type_id = uuidtoid($attributes['lone_type_id'], 'loans'); */
        $loane = $this->create([
            /* 'lone_type_id' => $loane_type_id, */
            'name' => $attributes['name'],
            'note' => $attributes['note'],
            'mfi_id' => auth()->user() ? auth()->user()->mfi_id : null,
            'created_by' => auth()->user() ? auth()->user()->id : null,
            'updated_by' => auth()->user() ? auth()->user()->id : null,
        ]);
        return $loane;

    }

    public function updatePurpose($attributes, $id)
    {
        $purposeData = $this->find($id);
        return $purposeData->update([
            'name' => $attributes['name'],
            'note' => $attributes['note'],
            'updated_by' => auth()->user()->id,
        ]);

    }

    public function deletePurpose($id)
    {
        $purposeData = $this->find($id);
        // $purposeData->branches()->delete();
        return $purposeData->delete();
    }
}
