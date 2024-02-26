<?php

namespace App\Repositories\Group;

use App\Contracts\Group\AgentGroupContract;
use App\Models\Group;
use App\Models\User;
use App\Models\Media;
use App\Repositories\BaseRepository;
use App\Traits\UploadAble;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class BranchRepository
 *
 * @package \App\Repositories
 */
class AgentGroupRepository extends BaseRepository implements AgentGroupContract
{
    use UploadAble;

    protected $model;
    protected $userModel;
    /* protected $purposeBranchesModel; */
    /**
     * BrandRepository constructor.
     * @param Group $model
     * @param Media $mediaModel
     * @param User $userModel
     */
    public function __construct(Group $model,User $userModel)
    {
        parent::__construct($model);
        $this->model = $model;
        $this->userModel = $userModel;


    }
    public function listGroup($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $group = $this->model->listGroup();
        if (!is_null($filterConditions)) {
            foreach($filterConditions as $fKey => $fCondition){
                if(!empty($fCondition))
                {
                    if ($fKey == 'group') {
                        $group = $group->where(function ($query) use ($fCondition) {
                            $query->where('name', 'LIKE', "%$fCondition%");
                        });
                    }elseif($fKey == 'leader_id'){
                     $group = $group->whereHas('branch', function(Builder $query) use( $fCondition){
                        $query->where('branch_id', '=', $fCondition);
                    });

                    }else{
                        $group = $group->where($fKey, $fCondition);
                    }
                }
            }
        }
        $group = $group->orderBy($orderBy, $sortBy);
        if (!is_null($limit)) {
            return $group->paginate($limit);
        }
        return $group->get();
    }
    public function createGroup($attributes)
    {
        $groupCreated = $this->create([
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
            'mfi_id' => auth()->user() ? auth()->user()->mfi_id : null,
            'code' => $attributes['code'],
            'branch_id' => $attributes['branch_id'],
            'country_name' => $attributes['country_name'],
            'state_name' => $attributes['state_name'],
            'city_name' => $attributes['city_name'],
            'zip_code' => $attributes['zip_code'],
            'full_address' => $attributes['full_address'],
            'landmark' => $attributes['landmark'],
            'leader_user_id' => $attributes['leader_user_id'],
            /* 'frequency' => $attributes['frequency'], */
            'remarks' => $attributes['remarks']
            /* 'days' => json_encode($attributes['days']), */

        ]);

        if ($groupCreated) {
            $groupCreated->agents()->attach($attributes['user_id']);

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
        return $groupCreated;
    }

    public function updateGroup($attributes, $id)
    {
        $occupationData = $this->find($id);
        $attributes['updated_by'] = auth()->user()->id;
        $isOccupationUpdated = $this->update($attributes, $id);
        if($isOccupationUpdated){
            $occupationData->agents()->detach();
            $occupationData->agents()->attach($attributes['user_id']);
        }
        return $isOccupationUpdated;
    }

    public function deleteGroup($id)
    {
        $occupationData = $this->find($id);
        //$branchData->media()->delete();
        return $occupationData->delete();
    }
}
