<?php

namespace App\Contracts\LoanEmi;

/**
 * Interface LoanContract
 * @package App\Contracts
 */
interface LoanEmiContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listLoanEmi(array $filterConditions, string $orderBy = 'id', string $sortBy = 'desc', $limit = null, $inRandomOrder = false);

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

  
    
 
}
