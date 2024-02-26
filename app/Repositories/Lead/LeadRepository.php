<?php

namespace App\Repositories\Lead;

use App\Contracts\Lead\LeadContract;
use App\Models\Lead;
use App\Models\Media;
use App\Repositories\BaseRepository;
use App\Traits\UploadAble;
use Carbon\Carbon;

/**
 * Class LeadRepository
 *
 * @package \App\Repositories
 */
class LeadRepository extends BaseRepository implements LeadContract
{
    use UploadAble;

    protected $model;
    /**
     * BrandRepository constructor.
     * @param Lead $model
     * @param Media $mediaModel
     */
    public function __construct(Lead $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
    public function listLeads($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $leads = $this->model->listLead();
        if(!is_null($filterConditions)){
            //dd($filterConditions);
            foreach($filterConditions as $fKey => $fCondition){
                if ($fKey == 'lead_name') {
                    $leads = $leads->where(function ($query) use ($fCondition) {
                        $query->where('name', 'LIKE', "%$fCondition%")
                        ;
                    });
                }elseif($fKey == 'lead_email'){
                    $leads = $leads->where(function ($query) use ($fCondition) {
                        $query->where('email', 'LIKE', "%$fCondition%")
                        ->orWhere('phone','LIKE', "%$fCondition%");
                    });
                }else{
                    $leads = $leads->where($fKey, $fCondition);
                }
            }
        }
        $leads = $leads->orderBy($orderBy, $sortBy);
        if (!is_null($limit)) {
            return $leads->paginate($limit);
        }
        return $leads->get();
    }
    public function createLead($attributes)
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
            'branch_id' => $attributes['branch_id'],
            'agent_id' => $attributes['agent_id'],
            'group_id' => $attributes['group_id'],
            'email' => !empty($attributes['email']) ? $attributes['email'] : '',
            'phone' => !empty($attributes['phone']) ? $attributes['phone'] : '',
            'aadhaar_no' => !empty($attributes['aadhaar_no']) ? $attributes['aadhaar_no'] : '',
            'country_name' => !empty($attributes['country_name']) ? $attributes['country_name'] : '',
            'state_name' => !empty($attributes['state_name']) ? $attributes['state_name'] : '',
            'city_name' => !empty($attributes['city_name']) ? $attributes['city_name'] : '',
            'zip_code' => !empty($attributes['zip_code']) ? $attributes['zip_code'] : '',
            'address' => !empty($attributes['address']) ? $attributes['address'] : '',
            'landmark' => !empty($attributes['landmark']) ? $attributes['landmark'] : '',
            'note' => !empty($attributes['note']) ? $attributes['note'] : '',

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

    public function updateLead($attributes, $id)
    {
        //$branchData = $this->find($id);
        $leadData = $this->find($id);
        return $leadData->update([
            'updated_by' => auth()->user()->id,
             'branch_id' => $attributes['branch_id'],
            'agent_id' => $attributes['agent_id'],
            'group_id' => $attributes['group_id'],
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
            'note' => !empty($attributes['note']) ? $attributes['note'] : '',
        ]);

        /* $attributes['updated_by'] = auth()->user()->id;
        $isBrandUpdated = $this->update($attributes, $id); */


    }

     public function leadVerify($attributes, $id)
    {
        $leadData = $this->find($id);
        $leadData = $leadData->update([
            'updated_by' => auth()->user()->id,
            'verified_note' => $attributes['verified_note'],
            'is_verified'=>!empty($attributes['is_verified'])?$attributes['is_verified']:0,
            'verified_at'=>currentDate(),
            'verified_by'=>auth()->user()->id
        ]);
       return $leadData;


    }

    public function deleteLead($id)
    {
        $enquiryData = $this->find($id);
        //$branchData->media()->delete();
        return $enquiryData->delete();
    }
}
