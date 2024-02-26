<?php

namespace App\Repositories\Occupation;

use App\Contracts\Occupation\OccupationContract;
use App\Models\Occupation;
use App\Models\Media;
use App\Repositories\BaseRepository;
use App\Traits\UploadAble;

/**
 * Class OccupationRepository
 *
 * @package \App\Repositories
 */
class OccupationRepository extends BaseRepository implements OccupationContract
{
    use UploadAble;

    protected $model;
    /**
     * BrandRepository constructor.
     * @param Occupation $model
     * @param Media $mediaModel
     */
    public function __construct(Occupation $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
    public function listOccupation($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $occupation = $this->model;
        if (!is_null($filterConditions)) {
            foreach($filterConditions as $fKey => $fCondition){
                if ($fKey == 'occupation_name') {
                    $occupation = $occupation->where(function ($query) use ($fCondition) {
                        $query->where('name', 'LIKE', "%$fCondition%");
                    });
                }else{
                    $occupation = $occupation->where($fKey, $fCondition);
                }
            }
        }
        $occupation = $occupation->orderBy($orderBy, $sortBy);
        if (!is_null($limit)) {
            return $occupation->paginate($limit);
        }
        return $occupation->get();
    }
    public function createOccupation($attributes)
    {
        $attributes['created_by'] = auth()->user()->id;
        $attributes['updated_by'] = auth()->user()->id;
        $attributes['mfi_id'] = auth()->user()? auth()->user()->mfi_id : NULL;
        $isOccupationCreated = $this->create($attributes);
        if ($isOccupationCreated) {
            // if (isset($attributes['brand_image'])) {
            //     $fileName = uniqid() . '.' . $attributes['brand_image']->getClientOriginalExtension();
            //     $isFileUploaded = $this->uploadOne($attributes['brand_image'], config('constants.SITE_BRAND_IMAGE_UPLOAD_PATH'), $fileName, 'public');
            //     if ($isFileUploaded) {
            //         $isFileRelatedMediaCreated = $isBrandCreated->media()->create([
            //             'user_id' => auth()->user()->id,
            //             'media_type' => 'image',
            //             'file' => $fileName,
            //             'is_profile_picture' => false,
            //         ]);
            //     }
            // }
        }
        return $isOccupationCreated;
    }

    public function updateOccupation($attributes, $id)
    {
        $occupationData = $this->find($id);
        $attributes['updated_by'] = auth()->user()->id;
        $isOccupationUpdated = $this->update($attributes, $id);

        return $occupationData;
    }

    public function deleteOccupation($id)
    {
        $occupationData = $this->find($id);
        //$branchData->media()->delete();
        return $occupationData->delete();
    }
}
