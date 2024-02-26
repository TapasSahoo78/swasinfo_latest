<?php

namespace App\Repositories\MfiRoles;

use App\Contracts\MfiRoles\MfiRolesContract;
use App\Models\MfiRole;
use App\Models\Media;
use App\Repositories\BaseRepository;
use App\Traits\UploadAble;

/**
 * Class LeadRepository
 *
 * @package \App\Repositories
 */
class MfiRolesRepository extends BaseRepository implements MfiRolesContract
{
    use UploadAble;

    protected $model;
    /**
     * BrandRepository constructor.
     * @param MfiRole $model
     * @param Media $mediaModel
     */
    public function __construct(MfiRole $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
    public function listMfiRoles($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $mfiRoles = $this->model;
        $mfiRoles = $mfiRoles->with('role')->where('mfi_id', auth()->user()->mfi_id);
        
        if (!is_null($limit)) {
            return $mfiRoles->paginate($limit);
        }
        return $mfiRoles->get();
    }
    public function createMfiRoles($attributes)
    {
        /*  $attributes['created_by'] = auth()->user()->id;
        $attributes['updated_by'] = auth()->user()->id;
        $attributes['mfi_id'] = auth()->user()?auth()->user()->mfi_id:null;
        $attributes['account_type'] = $attributes['account_type'];
        $isBrandCreated = $this->create($attributes); */

        $isLeadCreated = $this->create([
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
            'mfi_id' => auth()->user() ? auth()->user()->mfi_id : null,
            'name' => $attributes['name'],
            'email' => !empty($attributes['email']) ? $attributes['email'] : '',
            'phone' => !empty($attributes['phone']) ? $attributes['phone'] : '',
            'aadhaar_no' => !empty($attributes['aadhaar_no']) ? $attributes['aadhaar_no'] : '',
            'country_name' => !empty($attributes['country_name']) ? $attributes['country_name'] : '',
            'state_name' => !empty($attributes['state_name']) ? $attributes['state_name'] : '',
            'city_name' => !empty($attributes['city_name']) ? $attributes['city_name'] : '',
            'zip_code' => !empty($attributes['zip_code']) ? $attributes['zip_code'] : '',
            'address' => !empty($attributes['address']) ? $attributes['address'] : '',
            'landmark' => !empty($attributes['landmark']) ? $attributes['landmark'] : '',

        ]);

        if ($isLeadCreated) {
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
        return $isLeadCreated;
    }

    public function updateMfiRoles($attributes, $id)
    {
        //$branchData = $this->find($id);
        $leadData = $this->find($id);
        return $leadData->update([
            'updated_by' => auth()->user()->id,
            'name' => $attributes['name'],
            'email' => !empty($attributes['email']) ? $attributes['email'] : '',
            'phone' => !empty($attributes['phone']) ? $attributes['phone'] : '',
            'aadhaar_no' => !empty($attributes['aadhaar_no']) ? $attributes['aadhaar_no'] : '',
            'country_name' => !empty($attributes['country_name']) ? $attributes['country_name'] : '',
            'state_name' => !empty($attributes['state_name']) ? $attributes['state_name'] : '',
            'city_name' => !empty($attributes['city_name']) ? $attributes['city_name'] : '',
            'zip_code' => !empty($attributes['zip_code']) ? $attributes['zip_code'] : '',
            'address' => !empty($attributes['address']) ? $attributes['address'] : '',
            'landmark' => !empty($attributes['landmark']) ? $attributes['landmark'] : '',
        ]);

        /* $attributes['updated_by'] = auth()->user()->id;
    $isBrandUpdated = $this->update($attributes, $id); */

    }

    public function deleteMfiRoles($id)
    {
        $enquiryData = $this->find($id);
        //$branchData->media()->delete();
        return $enquiryData->delete();
    }
}
