<?php

namespace App\Repositories\Branch;

use App\Contracts\Branch\BranchContract;
use App\Models\Branch;
use App\Models\Media;
use App\Repositories\BaseRepository;
use App\Traits\UploadAble;
use App\Models\Role;
/**
 * Class BranchRepository
 *
 * @package \App\Repositories
 */
class BranchRepository extends BaseRepository implements BranchContract
{
    use UploadAble;

    protected $model;
    /**
     * BrandRepository constructor.
     * @param Branch $model
     * @param Media $mediaModel
     */
    public function __construct(Branch $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
    public function listBranch($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $branch = $this->model;

       /*  if (!is_null($filterConditions)) {
            $branch = $branch->where($filterConditions);
        } */
        if(!is_null($filterConditions)){
           // dd($filterConditions);
            foreach($filterConditions as $fKey => $fCondition){
                if(!empty($fCondition))
                {
                    if ($fKey == 'branch') {
                        $branch = $branch->where(function ($query) use ($fCondition) {
                            $query->where('name', 'LIKE', "%$fCondition%");
                        });
                    }elseif($fKey == 'brcode'){
                        $branch = $branch->where(function ($query) use ($fCondition) {
                            $query->where('code', 'LIKE', "%$fCondition%");
                        });
                    }else{
                        $branch = $branch->where($fKey, $fCondition);
                    }
                }
            }
        }
       // if (!is_null($filterSearchConditions)) {
         //   $branch = $branch->where($filterSearchConditions);
        //}
        $branch = $branch->orderBy($orderBy, $sortBy);
        if (!is_null($limit)) {
            return $branch->paginate($limit);
        }
        return $branch->get();
    }
    public function createBranch($attributes)
    {
        $attributes['created_by'] = auth()->user()->id;
        $attributes['updated_by'] = auth()->user()->id;
        $attributes['mfi_id'] = !empty($attributes['mfi_id']) ? $attributes['mfi_id'] : auth()->user()->mfi_id;
        $isBrandCreated = $this->create($attributes);
        if ($isBrandCreated) {
            $mfiRoles = Role::where('is_default_role',1)->where('role_type','branch')->get();
            $isBrandCreated->roles()->attach($mfiRoles);

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
        return $isBrandCreated;
    }

    public function updateBranch($attributes, $id)
    {
        $branchData = $this->find($id);
        $attributes['updated_by'] = auth()->user()->id;
        $isBranchUpdated = $this->update($attributes, $id);

        return $branchData;
    }

    public function deleteBranch($id)
    {
        $branchData = $this->find($id);
        //$branchData->media()->delete();
        return $branchData->delete();
    }
}
