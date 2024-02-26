<?php

namespace App\Contracts\Banner;

/**
 * Interface AdsContract
 * @package App\Contracts
 */
interface BannerContract
{
    public function findBanners(array $filterConditions,string $orderBy='id',$sortBy='asc',$limit= null,$inRandomOrder= false);

    public function createBanner(array $attributes);

    public function updateBanner(array $attributes,int $id);

    public function deleteBanner(int $id);


}
