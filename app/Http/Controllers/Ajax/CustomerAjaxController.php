<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\BaseController;
use App\Services\Product\ProductService;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerAjaxController extends BaseController
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var ProductService
     */
    protected $productService;

    public function __construct(UserService $userService, ProductService $productService)
    {
        $this->userService = $userService;
        $this->productService = $productService;

    }

    public function findAddress(Request $request)
    {
        if ($request->ajax()) {
            $id = uuidtoid($request->uuid, 'addresses');
            $address = $this->userService->findAddress($id);
            return $this->responseJson(true, 200, 'Data Found Successfully', $address);
        } else {
            abort(403);
        }
    }
    public function addAddress(Request $request)
    {
        if ($request->ajax()) {
            // dd($request->all());
            $user = auth()->user();

            $request->merge(['created_by' => $user->id, 'updated_by' => $user->id]);

            DB::beginTransaction();
            try {
                if ($request->has('uuid') && $request->uuid != '') {
                    $id = uuidtoid($request->uuid, 'addresses');
                    $isAddress = $this->userService->createOrUpdateAddress($request->except(['_token', 'uuid']), $id);
                } else {
                    $isAddress = $this->userService->createOrUpdateAddress($request->except('_token'));
                }

                if ($isAddress) {
                    DB::commit();
                    $addressData = auth()->user()->addressBook;
                    $data = [
                        'addressHtml' => view('customer.address.components.addreess')->with(['addresses' => $addressData])->render(),
                    ];
                    return $this->responseJson(true, 200, 'Addres added or updated Successfully', $data);
                }
            } catch (\Exception$e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseJson(false, 200, 'Something went wrong');
            }
        } else {
            abort(403);
        }
    }
    public function editAddress(Request $request)
    {
        if ($request->ajax()) {
            $isAddressUpdated = $this->userService->createOrUpdateAddress($request->only('is_default'), $id);
        }
    }
    public function defaultAddress(Request $request)
    {
        if ($request->ajax()) {
            $user = auth()->user();
            $id = uuidtoid($request->uuid, 'addresses');
            $request->merge(['is_default' => 1]);
            DB::beginTransaction();
            try {
                $defaultOtherAddressRemove = auth()->user()->addressBook()->update(['is_default' => false]);
                $isAddressUpdated = $this->userService->createOrUpdateAddress($request->only('is_default'), $id);
                if ($isAddressUpdated) {
                    DB::commit();
                    $addressData = $user->addressBook;
                    $data = [
                        'addressHtml' => view('customer.address.components.addreess')->with(['addresses' => $addressData])->render(),
                    ];
                    return $this->responseJson(true, 200, 'Addres added Successfully', $data);
                }
            } catch (\Exception$e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseJson(false, 200, 'Something went wrong');
            }
        } else {
            abort(403);
        }
    }
    public function deleteAddress(Request $request)
    {
        if ($request->ajax()) {

            $user = auth()->user();
            $id = uuidtoid($request->uuid, 'addresses');

            DB::beginTransaction();
            try {
                $isAddressDeleted = $this->userService->deleteAddress($id);
                if ($isAddressDeleted) {
                    DB::commit();
                    $addressData = $user->addressBook;
                    $data = [
                        'addressHtml' => view('customer.address.components.addreess')->with(['addresses' => $addressData])->render(),
                    ];
                    return $this->responseJson(true, 200, 'Address removed Successfully', $data);
                }
            } catch (\Exception$e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseJson(false, 200, 'Something went wrong');
            }
        } else {
            abort(403);
        }
    }

    public function addToWishlist(Request $request)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                $id = uuidtoid($request->uuid, 'products');
                $productData = $this->productService->findWishlistBYProductId($id);
                //dd($productData->toArray());
                $userWishlist = auth()->user()->wishlists?->pluck('product_id')->toArray();
                //dd($userWishlist);
                if ($userWishlist && !is_null($userWishlist)) {
                    if (in_array($productData->id, $userWishlist)) {
                        $isWishlist = $this->productService->deleteWishlist($id);
                    } else {
                        $isWishlist = $this->productService->createWishlist($request->except('_token'));
                    }
                } else {
                    $isWishlist = $this->productService->createWishlist($request->except('_token'));
                }
                //$isWishlist = $this->productService->createWishlist($request->except('_token'));

                /*  if ($request->has('uuid') && $request->uuid != '') {
                $id = uuidtoid($request->uuid, 'products');
                $isWishlist = $this->productService->createOrDeleteWishlist($request->except(['_token', 'uuid']), $id);
                } else {
                $isWishlist = $this->productService->createOrDeleteWishlist($request->except('_token'));
                } */
                if ($isWishlist) {
                    DB::commit();
                    return $this->responseJson(true, 200, 'Product Added/Removed in wishlist successfully');
                }
            } catch (\Exception$e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseJson(false, 200, 'Something went wrong');
            }
        } else {
            abort(403);
        }
    }
    public function removeFromWishlist(Request $request)
    {
        if ($request->ajax()) {

            //dd($request->all());

            $user = auth()->user();
            $id = uuidtoid($request->uuid, 'products');
            DB::beginTransaction();
            try {
                $isWishlistDeleted = $this->productService->deleteWishlist($id);
                if ($isWishlistDeleted) {
                    DB::commit();
                    $wishlistData = auth()->user()->wishlists;

                    $data = [
                        'wishlistHtml' => view('customer.wishlist.components.wish-list-products')->with(['wishlists' => $wishlistData])->render(),
                    ];
                    return $this->responseJson(true, 200, 'Product removed Successfully', $data);
                }
            } catch (\Exception$e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseJson(false, 200, 'Something went wrong');
            }
        } else {
            abort(403);
        }

    }
}
