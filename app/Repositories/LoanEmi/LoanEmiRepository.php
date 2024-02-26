<?php

namespace App\Repositories\LoanEmi;

use App\Contracts\LoanEmi\LoanEmiContract;
use App\Models\Loan;
use App\Models\LoanEmi;
use App\Models\Media;
use App\Repositories\BaseRepository;
use App\Traits\UploadAble;

/**
 * Class LoanRepository
 *
 * @package \App\Repositories
 */
class LoanEmiRepository extends BaseRepository implements LoanEmiContract
{
    use UploadAble;

    protected $model;
    /**
     * BrandRepository constructor.
     * @param LoanEmi $model
     * @param Media $mediaModel
     */
    public function __construct(LoanEmi $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
    public function listLoanEmi($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $loanEmi = $this->model;
        if (!is_null($filterConditions)) {
            $loanEmi = $loanEmi->where($filterConditions);
        }
        $loanEmi = $loanEmi->orderBy($orderBy, $sortBy);
        if (!is_null($limit)) {
            return $loanEmi->paginate($limit);
        }
        return $loanEmi->get();
    }
   


    public function createLoanEmi($attributes)
    {
        $attributes['mfi_id'] = auth()->user() ? auth()->user()->mfi_id : '';
        foreach($attributes['number_of_week'] as $key => $value)
        {
            $data = ['number_of_week'=>$value,'emi_amount'=>$attributes['emi_amount'][$key],'loan_id'=>$attributes['loan_id'],'mfi_id'=>$attributes['mfi_id']];
            if(!empty($attributes['loan_emi_id'][$key]))
            {
                $find = $this->find($attributes['loan_emi_id'][$key]);
                $isLoanCreated = $find->update($data);
            }else
            {
                $isLoanCreated = $this->create($data);
            }
        }
        $loan = Loan::find($attributes['loan_id']);
        $loan->update(['status'=>1]);
        // if ($isLoanCreated) {


           
        // }
        return $isLoanCreated;
    }

 

}
