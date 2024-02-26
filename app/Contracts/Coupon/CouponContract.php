<?php

namespace App\Contracts\Coupon;

/**
 * Interface PageContract
 * @package App\Contracts
 */
interface CouponContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listCoupons(array $filterConditions,string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */

    public function findCouponById(int $id);

    /**
     * @param $slug
     * @return mixed
     */

    /**
     * @param array $params
     * @return mixed
     */
    public function createCoupon(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCoupon(array $params,string $id);

    /**
     * @param $id
     * @return bool
     */
    public function deleteCoupon($id);

    /**
     * @param array $params
     * @return mixed
     */
    public function setCouponStatus(array $params, int $id);

    /* public function findCoupon(array $params); */
}
