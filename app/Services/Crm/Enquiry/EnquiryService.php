<?php

namespace App\Services\Crm\Enquiry;
use App\Contracts\Crm\Enquiry\EnquiryContract;

class EnquiryService
{
    /**
     * @var EnquiryContract
     */
    protected $enquiryRepository;

	/**
     * CouponService constructor
     */
    public function __construct(EnquiryContract $enquiryRepository){
        $this->enquiryRepository= $enquiryRepository;
    }

    public function listEnquiry(array $filterConditions,string $orderBy='id',$sortBy='asc',$limit= null,$inRandomOrder= false){
        return $this->enquiryRepository->listEnquiry($filterConditions,$orderBy,$sortBy,$limit);
    }
    // public function findCouponById($id){
    //     return $this->enquiryRepository->find($id);
    // }


    // public function setCouponStatus(array $attributes,int $id){
    //     $data['is_active']= $attributes['value'] == '1' ? 1 : 0;
    //     return $this->couponRepository->update($data,$id);
    // }

    // public function createOrUpdateCoupon(array $attributes,$id= null){
    //     if(is_null($id)){
    //         return $this->couponRepository->createCoupon($attributes);
    //     }else{
    //         return $this->couponRepository->updateCoupon($attributes,$id);
    //     }
    // }

    // public function deleteCoupon($id){
    //     return $this->couponRepository->delete($id);
    // }
}
