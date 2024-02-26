<?php

namespace App\Services\Coupon;
use App\Contracts\Coupon\CouponContract;

class CouponService
{
    /**
     * @var CouponContract
     */
    protected $couponRepository;

	/**
     * CouponService constructor
     */
    public function __construct(CouponContract $couponRepository){
        $this->couponRepository= $couponRepository;
    }

    public function listCoupons(array $filterConditions,string $orderBy='id',$sortBy='asc',$limit= null,$inRandomOrder= false){
        return $this->couponRepository->listCoupons($filterConditions,$orderBy,$sortBy,$limit);
    }
    public function findCouponById($id){
        return $this->couponRepository->find($id);
    }


    public function setCouponStatus(array $attributes,int $id){
        $data['is_active']= $attributes['value'] == '1' ? 1 : 0;
        return $this->couponRepository->update($data,$id);
    }

    public function createOrUpdateCoupon(array $attributes,$id= null){
        if(is_null($id)){
            return $this->couponRepository->createCoupon($attributes);
        }else{
            return $this->couponRepository->updateCoupon($attributes,$id);
        }
    }

    public function deleteCoupon($id){
        return $this->couponRepository->delete($id);
    }
}
