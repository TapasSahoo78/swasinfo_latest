<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->setPageTitle('All Brands');
        $filterConditions = [];
        $listProductss = [];
        return view('vendor.pages.product.list', compact('listProductss'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createProduct(Request $request)
    {
        $this->setPageTitle('Add Product');
        if ($request->post()) {
            $request->validate([
                'category' => 'required',
                'product_name' => 'required',
                'unit' => 'required',
                'quantity' => 'required',
                'price' => 'required',
                'selling_price' => 'required',
                'sku_number' => 'required',
                'brand' => 'required',
                // 'product_img' => 'nullable',
                'stock' => 'required',
                'description' => 'required'
            ]);
            DB::beginTransaction();
            try {
                $isBrandCreated = $this->brandService->createOrUpdateBrand($request->except('_token'));
                if ($isBrandCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.catalog.brand.list', 'Brand created successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('vendor.pages.product.create');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editProduct(Request $request, $uuid)
    {
        $this->setPageTitle('Edit Brand');
        $filterConditions = [
            'is_active' => true
        ];
        $brandId = uuidtoid($uuid, 'brands');
        $brandData = $this->brandService->findBrandById($brandId);

        if ($request->post()) {
            DB::beginTransaction();
            try {
                $isBrandUpdated = $this->brandService->createOrUpdateBrand($request->except('_token'), $brandId);
                if ($isBrandUpdated) {
                    DB::commit();
                    return $this->responseRedirect('admin.catalog.brand.list', 'Brand updated successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('avendor.pages.product.edit', compact('brandData'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteProduct(Request $request, $uuid)
    {
        $brandId = uuidtoid($uuid, 'brands');
        DB::beginTransaction();
        try {
            $isBrandDeleted = $this->brandService->deleteBrand($brandId);
            if ($isBrandDeleted) {
                DB::commit();
                return $this->responseRedirect('admin.catalog.brand.list', 'Brand deleted successfully', 'success', false);
            }
        } catch (\Exception $e) {
            DB::rollback();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseRedirectBack('Something went wrong', 'error', true);
        }
    }
}
