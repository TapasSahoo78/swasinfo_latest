<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\Coupon\CouponService;
use App\Http\Controllers\BaseController;
use App\Services\Category\CategoryService;
use App\Http\Requests\Coupon\AddCouponRequest;

class CouponController extends BaseController
{

    protected $couponService;

    //protected $userService;

    public function __construct(
        CouponService $couponService,
        CategoryService $categoryService
    )
    {
        $this->couponService    = $couponService;
        $this->categoryService    = $categoryService;
    }
    public function index(Request $request){
        $this->setPageTitle('All Coupons');
        $filterConditions = [];
        $listCoupons = $this->couponService->listCoupons($filterConditions, 'id', 'asc', 15);
        return view('admin.coupon.index',compact('listCoupons'));
    }


    public function addCoupon(Request $request){
        $this->setPageTitle('Add Coupon');
        $filterConditions = [
            'is_active' => true
        ];
        $listCategories = $this->categoryService->listMasterCategories($filterConditions, 'id', 'asc', 15);
        $listCategories= $listCategories->chunk(ceil($listCategories->count()/4));
        return view('admin.coupon.add',compact('listCategories'));
    }

    public function store(AddCouponRequest $request){
        DB::beginTransaction();
        try{
            $isCouponCreated= $this->couponService->createOrUpdateCoupon($request->except('_token'));
            if($isCouponCreated){
                DB::commit();
                return $this->responseRedirect('admin.coupon.list', 'Coupon created Successfully' ,'success',false, false);
            }
        }catch(\Exception $e){
            DB::rollback();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseRedirectBack('Something went wrong','error',true);
        }
    }


    public function editCoupon(Request $request, $uuid){
        $this->setPageTitle('Edit Coupon');
        $filterConditions = [
            'is_active' => true
        ];
        $id = uuidtoid($uuid, 'coupons');
        $coupons= $this->couponService->findCouponById($id);
        $listCategories = $this->categoryService->listMasterCategories($filterConditions, 'id', 'asc', 15);
        $listCategories= $listCategories->chunk(ceil($listCategories->count()/4));
        if ($request->post()) {
            $this->validate($request, [
                'code'              =>  'required|string|unique:coupons,code,'. $id,
                'title'             =>  'required|string',
                'coupon_type'       =>  'required',
                'coupon_discount'   =>  'required|numeric',
                'usage_per_user'    =>  'required|numeric',
                'usage_of_coupon'   =>  'required|numeric',
                'started_at'        =>  'required|date|after:today',
                'ended_at'          =>  'required|date|after_or_equal:started_at',
                ]);
            DB::beginTransaction();
            try {
                $isCouponUpdated = $this->couponService->createOrUpdateCoupon($request->except(['_token']), $id);
                if ($isCouponUpdated) {
                    DB::commit();
                    return $this->responseRedirect('admin.coupon.list', 'Coupon updated successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.coupon.edit', compact('coupons','listCategories'));
    }
}
