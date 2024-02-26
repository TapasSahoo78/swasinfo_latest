<?php

namespace App\Contracts\Loan;

/**
 * Interface LoanContract
 * @package App\Contracts
 */
interface LoanContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listLoan(array $filterConditions, string $orderBy = 'id', string $sortBy = 'desc', $limit = null, $inRandomOrder = false);

    /**
     * @param array $attributes
     * @return mixed
     */

    public function createLoan(array $attributes);

    /**
     * @param array $attributes
     * @param int $id
     * @return mixed
     */

    public function updateLoan(array $attributes, int $id);

    /**
     * @param int $id
     * @return mixed
     */

    public function deleteLoan(int $id);

      /**
     * @param array $attributes
     * @return mixed
     */

     public function createLoanEmi(array $attributes);

     /**
      * @param array $attributes
      * @param int $id
      * @return mixed
      */
 
     public function updateLoanEmi(array $attributes, int $id);
 
}
