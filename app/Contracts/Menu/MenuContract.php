<?php

namespace App\Contracts\Menu;

/**
 * Interface AdsContract
 * @package App\Contracts
 */
interface MenuContract
{
    public function findMenus(array $filterConditions,string $orderBy='id',$sortBy='asc',$limit= null,$inRandomOrder= false);
}
