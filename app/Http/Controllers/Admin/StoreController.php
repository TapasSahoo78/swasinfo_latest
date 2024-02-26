<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Services\Store\StoreService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreController extends BaseController
{
    protected $storeService;

    public function __construct(
        StoreService $storeService
    ) {
        $this->storeService = $storeService;
    }

    public function index(Request $request)
    {
        $this->setPageTitle('All Stores');
        $filterConditions = [];
        $stores = $this->storeService->listStores($filterConditions, 'id', 'asc', 15);
        //dd($stores);
        return view('admin.store.index', compact('stores'));
    }

    public function addStoreLocation(Request $request)
    {
        $this->setPageTitle('Add Store');
        return view('admin.store.add');
    }
    public function store(Request $request)
    {
        if ($request->post()) {
            $this->validate($request, [
                'name' => 'required|string',
                'phone_number' => 'required|numeric',
                'full_address' => 'sometimes|string|min:3|nullable',
                'zip_code' => 'sometimes|numeric|nullable',
            ]);
            DB::beginTransaction();
            try {
                $isStoreCreated = $this->storeService->createOrUpdateStore($request->except('_token'));
                if ($isStoreCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.store.list', 'Store created Successfully', 'success', false, false);
                }
            } catch (\Exception$e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
    }
    public function editStoreLocation(Request $request, $uuid)
    {
        $this->setPageTitle('Edit Store');
        $id = uuidtoid($uuid, 'stores');
        $store = $this->storeService->findStoreById($id);
        if ($request->post()) {
            $this->validate($request, [
                'name' => 'required|string',
                'phone_number' => 'required|numeric',
                'full_address' => 'sometimes|string|min:3|nullable',
                'zip_code' => 'sometimes|numeric|nullable',
            ]);
            DB::beginTransaction();
            try {
                $isStoreUpdated = $this->storeService->createOrUpdateStore($request->except('_token'), $id);
                if ($isStoreUpdated) {
                    DB::commit();
                    return $this->responseRedirect('admin.store.list', 'Store updated successfully', 'success', false);
                }
            } catch (\Exception$e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.store.edit', compact('store'));
    }
}
