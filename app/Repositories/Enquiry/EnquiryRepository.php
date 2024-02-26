<?php

namespace App\Repositories\Enquiry;

use App\Contracts\Enquiry\EnquiryContract;
use App\Models\Enquiry;
use App\Models\EnquiryNotes;
use App\Models\Lead;
use App\Models\Media;
use App\Repositories\BaseRepository;
use App\Traits\UploadAble;

/**
 * Class EnquiryRepository
 *
 * @package \App\Repositories
 */
class EnquiryRepository extends BaseRepository implements EnquiryContract
{
    use UploadAble;

    protected $model;
    protected $enquiryNotesModel;
    protected $leadModel;
    /**
     * BrandRepository constructor.
     * @param Enquiry $model
     * @param Media $mediaModel
     * @param EnquiryNotes $enquiryNotesModel
     * @param Lead $leadModel
     */
    public function __construct(Enquiry $model, EnquiryNotes $enquiryNotesModel,Lead $leadModel)
    {
        parent::__construct($model);
        $this->model = $model;
        $this->enquiryNotesModel = $enquiryNotesModel;
        $this->leadModel = $leadModel;
    }
    public function listEnquiry($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $enquiry = $this->model;
        if (!is_null($filterConditions)) {
            $enquiry = $enquiry->where($filterConditions);
        }
        $enquiry = $enquiry->orderBy($orderBy, $sortBy);
        if (!is_null($limit)) {
            return $enquiry->paginate($limit);
        }
        return $enquiry->get();
    }
    public function createEnquiry($attributes)
    {
        /*  $attributes['created_by'] = auth()->user()->id;
        $attributes['updated_by'] = auth()->user()->id;
        $attributes['mfi_id'] = auth()->user()?auth()->user()->mfi_id:null;
        $attributes['account_type'] = $attributes['account_type'];
        $isBrandCreated = $this->create($attributes); */
        //return $attributes;
       // $lead_id = uuidtoid($attributes['lead_id'], 'leads');
        $loan_id = uuidtoid($attributes['loan_id'], 'loans');
        $isEnquiryCreated = $this->create([
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
            'mfi_id' => auth()->user() ? auth()->user()->mfi_id : null,
            'lead_id' => !empty($attributes['lead_id']) ? $attributes['lead_id'] : '',
            /* 'branch_id'=> !empty($attributes['branch_id']) ? $attributes['branch_id'] : '',, */
            'loan_id' => !empty($loan_id) ? $loan_id : '',
            'min_amount' => !empty($attributes['min_amount']) ? $attributes['min_amount'] : '',
            'max_amount' => !empty($attributes['max_amount']) ? $attributes['max_amount'] : '',
            'message' => !empty($attributes['message']) ? $attributes['message'] : '',
        ]);
        return $isEnquiryCreated;
        if ($isEnquiryCreated) {
        }
    }

    public function updateEnquiry($attributes, $id)
    {
        /* $branchData = $this->find($id);
        $attributes['updated_by'] = auth()->user()->id;
        $isBrandUpdated = $this->update($attributes, $id);

        return $branchData; */

        $loan_id = uuidtoid($attributes['loan_id'], 'loans');
        $enquiryData = $this->find($id);
        return $enquiryData->update([
            'updated_by' => auth()->user()->id,
            'mfi_id' => auth()->user() ? auth()->user()->mfi_id : null,
           'lead_id' => !empty($attributes['lead_id']) ? $attributes['lead_id'] : '',
            'loan_id' => !empty($loan_id) ? $loan_id : '',
            'min_amount' => !empty($attributes['min_amount']) ? $attributes['min_amount'] : '',
            'max_amount' => !empty($attributes['max_amount']) ? $attributes['max_amount'] : '',
            'message' => !empty($attributes['message']) ? $attributes['message'] : '',
        ]);

    }
    public function enquiryStatusChange($attributes, $id)
    {
        $enquiryData = $this->find($id);
        $enquiryStatusUpdate = $enquiryData->update([
            'updated_by' => auth()->user()->id,
            'status' => $attributes['status']
        ]);
        if ($enquiryStatusUpdate) {
            $enquiryData->note()->create([
                'mfi_id' => auth()->user() ? auth()->user()->mfi_id : null,
                'enquiry_id' => $enquiryData->id,
                'enquiry_status' => $attributes['status'],
                'notes' => $attributes['notes'],
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);
            return $enquiryStatusUpdate;
        }

    }

    public function deleteEnquiry($id)
    {
        $enquiryData = $this->find($id);
        $enquiryData->note()->delete();
        return $enquiryData->delete();

    }
     public function leadWiseEnquiry($id){
        return $this->model->where('lead_id',$id)->get();
    }

}
