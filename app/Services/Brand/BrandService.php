<?php

namespace App\Services\Brand;
use App\Contracts\Brand\BrandContract;

class BrandService
{
    /**
     * @var BrandContract
     */
    protected $brandRepository;

	/**
     * UserService constructor
     */
    public function __construct(BrandContract $brandRepository){
        $this->brandRepository= $brandRepository;
    }
    public function listBrands(array $filterConditions,string $orderBy='id',$sortBy='asc',$limit= null,$inRandomOrder= false){
        return $this->brandRepository->listBrands($filterConditions,$orderBy,$sortBy,$limit);
    }

    public function findBrandById($id){
        return $this->brandRepository->find($id);
    }

    public function createOrUpdateBrand(array $attributes, $id = null){
        if (is_null($id)) {
            return $this->brandRepository->createBrand($attributes);
        } else {
            return $this->brandRepository->updateBrand($attributes, $id);
        }
    }
    public function updateBrandStatus($attributes,$id){
        $attributes['is_active']= $attributes['value'] == '1' ? 1 : 0;
        return $this->brandRepository->update($attributes, $id);
    }
    public function updateCourseStatus($attributes,$id){
        $attributes['status']= $attributes['value'] == '1' ? 1 : 0;
        return $this->brandRepository->update($attributes, $id);
    }

    public function deleteBrand(int $id){
        return $this->brandRepository->deleteBrand($id);
    }
    public function deleteCourse(int $id){
        return $this->brandRepository->deleteCourse($id);
    }
}
