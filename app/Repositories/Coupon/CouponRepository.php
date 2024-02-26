<?php
namespace App\Repositories\Coupon;

use App\Models\Coupon;
use App\Contracts\Coupon\CouponContract;
use App\Models\Category;
use App\Repositories\BaseRepository;
/**
 * Class PageRepository
 *
 * @package \App\Repositories
 */
class CouponRepository extends BaseRepository implements CouponContract
{
    protected $categoryModel;
    /**
     * CouponRepository constructor
     *
     * @param Coupon $model
     * @param Category $categoryModel
     */
    /**
     * CouponRepository constructor
     *
     *
     */
    public function __construct(Coupon $model,Category $categoryModel)
    {
        parent::__construct($model);
        $this->model = $model;
        $this->categoryModel = $categoryModel;

    }

    /**
     * List of all coupons
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listCoupons($filterConditions,string $order = 'id', string $sort = 'desc',$limit= null,$inRandomOrder= false){
        $coupons = $this->model->where($filterConditions);
        if (!is_null($limit)) {
            return $coupons->paginate($limit);
        }
        return $coupons->get();
    }

    /**
     * Find a coupon with id
     *
     * @param int $id
     */
    public function findCouponById(int $id){
        return $this->find($id);
    }

    /**
     * Create a coupon
     *
     * @param array $attributes
     * @return Coupon|mixed
     */
    public function createCoupon($attributes){
        $attributes['created_by'] = auth()->user()->id;
        $attributes['updated_by'] = auth()->user()->id;
        $isCouponCreated= $this->create($attributes);
        if($isCouponCreated){
            $categories= $this->categoryModel->whereIn('id',$attributes['category'])->get();
            $isCouponCreated->categories()->attach($categories);
        }
        return $isCouponCreated;
    }

    /**
     *  Update a coupon
     *
     * @param array $attributes
     * @param int $id
     * @return Coupon|mixed
     */
    public function updateCoupon($attributes, $id){
        $coupon= $this->find($id);
        $attributes['created_by'] = auth()->user()->id;
        $attributes['updated_by'] = auth()->user()->id;
        $isCouponUpdated= $coupon->update($attributes);
        if($isCouponUpdated){
            $categories= $this->categoryModel->whereIn('id',$attributes['category'])->get();
            $coupon->categories()->detach();
            $coupon->categories()->attach($categories);
        }
        return $isCouponUpdated;
    }

    /**
     * Delete a coupon
     *
     * @param int $id
     * @return bool|mixed
     */
    public function deleteCoupon($id){
        return $this->delete($id);
    }

    /**
     * Update a coupon's status
     *
     * @param array $params
     * @param int $id
     * @return mixed
     */
    public function setCouponStatus($attributes, $id){
        return $this->update($attributes, $id);
    }
}
