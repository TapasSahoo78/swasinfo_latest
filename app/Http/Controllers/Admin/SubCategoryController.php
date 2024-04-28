<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CommissionRate;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Traits\UploadAble;

class SubCategoryController extends BaseController
{

    use UploadAble;

    public function __construct(
        //UserService $userService,
        //RoleService $roleService
    )
    {
        //$this->userService = $userService;
        //$this->roleService = $roleService;
    }
    public function index()
    {
        $this->setPageTitle('Commision List');
        $data = Subcategory::all();
        return view('admin.subcategory.index', compact('data'));
    }

    public function addSubCategory(Request $request)
    {
        $this->setPageTitle('Sub Category Add');
        if ($request->isMethod('post')) {
            $request->validate([
                // 'category_id' => 'required|exists:categories',
                // 'sub_category' => 'required|unique:subcategories',
                'category_id' => 'required',
                'sub_category' => 'required|unique:subcategories,name',
                'price_range_min.*' => 'required|numeric',
                'price_range_max.*' => 'required|numeric',
                'commission_rate.*' => 'required|numeric',
            ]);
            DB::beginTransaction();
            try {
                $subcategory = new Subcategory();
                $subcategory->category_id = $request->input('category_id');
                $subcategory->name = $request->input('sub_category');
                $subcategory->save();

                // If validation passes, insert data into the database
                foreach ($request->price_range_min as $key => $value) {
                    CommissionRate::create([
                        'subcategory_id' => $subcategory->id,
                        'price_range_min' => $request->price_range_min[$key],
                        'price_range_max' => $request->price_range_max[$key],
                        'commission_rate' => $request->commission_rate[$key],
                    ]);
                }

                if ($subcategory) {
                    DB::commit();
                    return $this->responseRedirect('admin.subcategory.list', 'Sub Category created successfully', 'success', false);
                }
            } catch (\Exception $e) {
                echo $e->getMessage();
                die();
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        } else {
            return view('admin.subcategory.add');
        }
    }

    public function editSubCategory(Request $request, $id)
    {
        $productId = uuidtoid($id, 'subcategories');
        $this->setPageTitle('Sub Category Edit');
        if ($request->isMethod('post')) {

            $request->validate([
                'category_id' => 'required|exists:categories',
                'sub_category' => 'required',
                'price_range_min.*' => 'required|numeric',
                'price_range_max.*' => 'required|numeric',
                'commission_rate.*' => 'required|numeric',
            ]);
            DB::beginTransaction();
            try {
                $subcategory = Subcategory::where('uuid', $id)->first();
                $subcategory->category_id = $request->input('category_id');
                $subcategory->name = $request->input('sub_category');
                $subcategory->save();

                // If validation passes, insert data into the database
                foreach ($request->price_range_min as $key => $value) {
                    CommissionRate::create([
                        'subcategory_id' => $subcategory->id,
                        'price_range_min' => $request->price_range_min[$key],
                        'price_range_max' => $request->price_range_max[$key],
                        'commission_rate' => $request->commission_rate[$key],
                    ]);
                }
                if ($subcategory) {
                    DB::commit();
                    return $this->responseRedirect('admin.subcategory.list', 'Sub Category updated successfully', 'success', false);
                }
            } catch (\Exception $e) {

                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        } else {
            $data = Subcategory::where('uuid', $id)->first();
            return view('admin.subcategory.edit', compact('data'));
        }
    }

    public function deleteSubCategory()
    {
    }
}
