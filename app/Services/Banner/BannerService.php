<?php

namespace App\Services\Banner;

use Str;
use Illuminate\Support\Carbon;
use App\Contracts\Banner\BannerContract;

class BannerService
{
    /**
     * @var BannerContract
     */
    protected $bannerRepository;

	/**
     * UserService constructor
     */
    public function __construct(BannerContract $bannerRepository){
        $this->bannerRepository= $bannerRepository;
    }

    public function listBanners(array $filterConditions,string $orderBy='id',$sortBy='asc',$limit= null,$inRandomOrder= false){
        return $this->bannerRepository->findBanners($filterConditions,$orderBy,$sortBy,$limit);
    }

    public function findBannerById($id){
        return $this->bannerRepository->find($id);
    }

    public function createOrUpdateBanner(array $attributes, $id=null){
        if(is_null($id)){
            return $this->bannerRepository->createBanner($attributes);
        }else{
            return $this->bannerRepository->updateBanner($attributes,$id);
        }
    }

    public function updateBanner($attributes,$id){
        $data['is_active']= $attributes['value'] == 1 ? 1 : 0;
        return $this->bannerRepository->update($data,$id);
    }

    public function deleteBanner($id){
        return $this->bannerRepository->deleteBanner($id);
    }
}
