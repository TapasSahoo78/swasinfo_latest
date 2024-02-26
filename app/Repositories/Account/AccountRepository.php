<?php

namespace App\Repositories\Account;

use App\Contracts\Account\AccountContract;
use App\Models\Account;
use App\Models\Media;
use App\Repositories\BaseRepository;
use App\Traits\UploadAble;

/**
 * Class BranchRepository
 *
 * @package \App\Repositories
 */
class AccountRepository extends BaseRepository implements AccountContract
{
    use UploadAble;

    protected $model;
    /**
     * BrandRepository constructor.
     * @param Account $model
     * @param Media $mediaModel
     */
    public function __construct(Account $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
    public function listAccount($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $account = $this->model;
        if (!is_null($filterConditions)) {
            $account = $account->where($filterConditions);
        }
        $account = $account->orderBy($orderBy, $sortBy);
        if (!is_null($limit)) {
            return $account->paginate($limit);
        }
        return $account->get();
    }
    public function createAccount($attributes)
    {
        /*  $attributes['created_by'] = auth()->user()->id;
        $attributes['updated_by'] = auth()->user()->id;
        $attributes['mfi_id'] = auth()->user()?auth()->user()->mfi_id:null;
        $attributes['account_type'] = $attributes['account_type'];
        $isBrandCreated = $this->create($attributes); */
        $data = array(
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
            'mfi_id'=> auth()->user() ? auth()->user()->mfi_id : null,
            'branch_id' => $attributes['branch_id'],
            'account_type' => $attributes['account_type'],
            /* 'account_sub_type' => $attributes['account_sub_type'], */
            'account_name' => !empty($attributes['account_name']) ? $attributes['account_name'] : '',
            'opening_balance' => !empty($attributes['opening_balance']) ? $attributes['opening_balance'] : '',
            'note' => !empty($attributes['note']) ? $attributes['note'] : '',
        );
        /* if($attributes['account_sub_type'] == 1){
            $data['account_number'] = !empty($attributes['account_number']) ? $attributes['account_number'] : '';
            $data['ifsc_code'] = !empty($attributes['ifsc_code']) ? $attributes['ifsc_code'] : '';
            $data['upi_id'] = !empty($attributes['upi_id']) ? $attributes['upi_id'] : '';
            $data['account_holder_name'] = !empty($attributes['account_holder_name']) ? $attributes['account_holder_name'] : '';
        }
        if($attributes['account_sub_type'] == 3){
            $data['upi_id'] = !empty($attributes['upi_id']) ? $attributes['upi_id'] : '';
        } */

        $isAccountCreated = $this->create($data);

        if ($isAccountCreated) {
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
        return $isAccountCreated;
    }

    public function updateAccount($attributes, $id)
    {
        $branchData = $this->find($id);
        $attributes['updated_by'] = auth()->user()->id;
        $isBrandUpdated = $this->update($attributes, $id);

        return $branchData;
    }

    public function deleteAccount($id)
    {
        $accountData = $this->find($id);
        //$branchData->media()->delete();
        return $accountData->delete();
    }
}
