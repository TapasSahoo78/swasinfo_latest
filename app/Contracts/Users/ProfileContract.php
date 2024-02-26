<?php

namespace App\Contracts\Users;

/**
 * Interface AdsContract
 * @package App\Contracts
 */
interface ProfileContract
{
	/**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function list(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    
    //public function findUserById(int $id);

    //public function blockUser($id,$is_block);
}