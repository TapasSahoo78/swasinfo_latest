<?php

namespace App\Repositories\Loan;

use App\Contracts\Loan\LoanContract;
use App\Models\Loan;
use App\Models\Media;
use App\Repositories\BaseRepository;
use App\Traits\UploadAble;
use PHPUnit\Framework\Constraint\Count;

/**
 * Class LoanRepository
 *
 * @package \App\Repositories
 */
class LoanRepository extends BaseRepository implements LoanContract
{
    use UploadAble;

    protected $model;
    /**
     * BrandRepository constructor.
     * @param Loan $model
     * @param Media $mediaModel
     */
    public function __construct(Loan $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
    public function listLoan($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $loan = $this->model;
        /* if (!is_null($filterConditions)) {
            $loan = $loan->where($filterConditions);
        } */
        if(!is_null($filterConditions)){
            //dd($filterConditions);
            foreach($filterConditions as $fKey => $fCondition){
                if ($fKey == 'loan_product_name') {
                    $loan = $loan->where(function ($query) use ($fCondition) {
                        $query->where('name', 'LIKE', "%$fCondition%");
                    });
                }elseif($fKey == 'loan_code'){
                    $loan = $loan->where(function ($query) use ($fCondition) {
                        $query->where('code', 'LIKE', "%$fCondition%");
                    });
                }else{
                    $loan = $loan->where($fKey, $fCondition);
                }
            }
        }
        $loan = $loan->listLoans()->orderBy($orderBy, $sortBy);
        if (!is_null($limit)) {
            return $loan->paginate($limit);
        }
        return $loan->get();
    }
    public function createLoan($attributes)
    {
        $attributes['created_by'] = auth()->user()->id;
        $attributes['updated_by'] = auth()->user()->id;
        $attributes['mfi_id'] = auth()->user() ? auth()->user()->mfi_id : '';
        $isLoanCreated = $this->create($attributes);
        if ($isLoanCreated) {

            $isLoanCreated->branches()->attach($attributes['branches']);

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
        return $isLoanCreated;
    }

    public function updateLoan($attributes, $id)
    {
        $loanData = $this->find($id);
        $attributes['updated_by'] = auth()->user()->id;
        // $attributes['slug'] = isSluggable($attributes['name']);
        $isBrandUpdated = $this->update($attributes, $id);
        $branches = $loanData->loanBranches;
        if(!empty($branches) && count($branches))
        {
            $loanData->loanBranches()->delete();
        }

        $loanData->branches()->attach($attributes['branches']);

        return $loanData;
    }

    public function deleteLoan($id)
    {
        $loanData = $this->find($id);
        //$branchData->media()->delete();
        return $loanData->delete();
    }


    public function createLoanEmi($attributes)
    {

        $attributes['mfi_id'] = auth()->user() ? auth()->user()->mfi_id : '';
        $isLoanCreated = $this->create($attributes);
        if ($isLoanCreated) {

            $isLoanCreated->branches()->attach($attributes['branches']);


        }
        return $isLoanCreated;
    }

    public function updateLoanEmi($attributes, $id)
    {
        $loanData = $this->find($id);
        $attributes['updated_by'] = auth()->user()->id;
        // $attributes['slug'] = isSluggable($attributes['name']);
        $isBrandUpdated = $this->update($attributes, $id);
        $loanData->branches()->delete();

        $loanData->branches()->attach($attributes['branches']);

        return $loanData;
    }

}
