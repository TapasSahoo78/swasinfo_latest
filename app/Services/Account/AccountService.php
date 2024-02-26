<?php

namespace App\Services\Account;

use App\Contracts\Account\AccountContract;

class AccountService
{
    /**
     * @var AccountContract
     */
    protected $accountRepository;

    /**
     * AccountService constructor
     */
    public function __construct(AccountContract $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }
    public function listAccount(array $filterConditions, string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->accountRepository->listAccount($filterConditions, $orderBy, $sortBy, $limit);
    }

    public function findAccountById($id)
    {
        return $this->accountRepository->find($id);
    }

    public function createOrUpdateAccount(array $attributes, $id = null)
    {
        if (is_null($id)) {
            return $this->accountRepository->createAccount($attributes);
        } else {
            return $this->accountRepository->updateAccount($attributes, $id);
        }
    }
    
    public function updateAccountStatus($attributes, $id)
    {
        $attributes['status'] = $attributes['value'] == '1' ? 1 : 0;
        return $this->accountRepository->update($attributes, $id);
    }

    public function deleteAccount(int $id)
    {
        return $this->accountRepository->deleteAccount($id);
    }
}
