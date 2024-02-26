<?php

namespace App\Services\Loan;

use App\Contracts\Loan\LoanContract;
use App\Contracts\LoanEmi\LoanEmiContract;

class LoanService
{
    /**
     * @var LoanContract
     * @var LoanEmiContract
     */
    protected $loanRepository;
    protected $loanEmiRepository;

    /**
     * LoanService constructor
     */
    public function __construct(LoanContract $loanRepository,LoanEmiContract $loanEmiRepository)
    {
        $this->loanRepository = $loanRepository;
        $this->loanEmiRepository = $loanEmiRepository;
    }
    public function listLoan(array $filterConditions, string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->loanRepository->listLoan($filterConditions, $orderBy, $sortBy, $limit);
    }

    public function findLoanById($id)
    {
        return $this->loanRepository->find($id);
    }
    public function findLoanEmisByLoanId($id)
    {
        $filterConditions = [
            'loan_id' =>$id,
        ];
        $orderBy = 'id';
        $sortBy = 'asc';
        return $this->loanEmiRepository->listLoanEmi($filterConditions,$orderBy, $sortBy);
    }

    public function createOrUpdateLoan(array $attributes, $id = null)
    {
        if (is_null($id)) {
            return $this->loanRepository->createLoan($attributes);
        } else {
            return $this->loanRepository->updateLoan($attributes, $id);
        }
    }
    public function createOrUpdateLoanEmai(array $attributes, $id = null)
    {
        return $this->loanEmiRepository->createLoanEmi($attributes);
        if (is_null($id)) {
        } else {
            // return $this->loanEmiRepository->updateLoanEmi($attributes, $id);
        }
    }
    /* public function createMfiBranch(array $attributes, $id = null)
    {
        $attributes['name'] = $attributes['branch_name'];
        $attributes['code'] = $attributes['code'];
        $attributes['is_head_branch'] = 1;
        // return $attributes;
        if (is_null($id)) {
            return $this->branchRepository->createBranch($attributes);
        } else {
            return $this->branchRepository->updateBranch($attributes, $id);
        }
    } */
    public function updateLoanStatus($attributes, $id)
    {
        $attributes['status'] = $attributes['value'] == '1' ? 1 : 0;
        return $this->loanRepository->update($attributes, $id);
    }

    public function deleteLoan(int $id)
    {
        return $this->loanRepository->deleteLoan($id);
    }
}
