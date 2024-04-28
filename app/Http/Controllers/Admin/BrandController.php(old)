<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\Brand\BrandService;
use App\Http\Controllers\BaseController;

class BrandController extends BaseController
{
    protected $brandService;
    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }
    public function viewBrand()
    {
        $this->setPageTitle('All Brands');
        $filterConditions = [];
        $listBrands = $this->brandService->listBrands($filterConditions, 'id', 'asc', 15);
        return view('admin.brand.list', compact('listBrands'));
    }

    public function addBrand(Request $request)
    {
        $this->setPageTitle('Add Brand');
        if ($request->post()) {
            $request->validate([
                'name' => 'required',
                'is_popular' => 'required',
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
        return view('admin.brand.add-brand');
    }
    public function editBrand(Request $request, $uuid)
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
        return view('admin.brand.edit-brand', compact('brandData'));
    }

    public function deleteBrand(Request $request, $uuid)
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
