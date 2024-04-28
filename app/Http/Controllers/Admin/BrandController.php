<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProductBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Traits\UploadAble;
use Illuminate\Support\Str;

class BrandController extends BaseController
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
        $this->setPageTitle('Brand List');
        $data = ProductBrand::all();
        return view('admin.brand.index', compact('data'));
    }

    public function addBrand(Request $request)
    {
        $this->setPageTitle('Brand Add');
        if ($request->isMethod('post')) {

            $request->validate([
                'name' => 'required|unique:product_brands'
            ]);
            DB::beginTransaction();
            try {
                $banner = new ProductBrand();
                $banner->name = $request->input('name');
                $banner->slug = Str::slug($request->input('name'));
                $banner->description = $request->input('description');
                $banner->created_by = auth()->user()->id;
                $banner->updated_by = auth()->user()->id;
                // Handle image upload
                if ($request->hasFile('brand_image')) {
                    $image = $request->file('brand_image');
                    $imageName = time() . '.' . $image->extension();
                    $image->move(public_path('images'), $imageName);
                    $banner->brand_image = $imageName;
                }
                // Assign other fields here
                $banner->save();
                if ($banner) {
                    DB::commit();
                    return $this->responseRedirect('admin.product.brand.list', 'Brand created successfully', 'success', false);
                }
            } catch (\Exception $e) {
                echo $e->getMessage();
                die();
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        } else {
            return view('admin.brand.add');
        }
    }

    public function editBrand(Request $request, $id)
    {
        $productId = uuidtoid($id, 'product_brands');
        $this->setPageTitle('Brand Edit');
        if ($request->isMethod('post')) {

            $request->validate([
                'name' => 'required',
            ]);
            DB::beginTransaction();
            try {
                $isCategoryCreated = ProductBrand::where('uuid', $id)->update([
                    'name' => $request['name'],
                    'slug' => Str::slug($request->input('name')),
                    'description' => $request['description'],
                    'created_by' => auth()->user()->id,
                    'updated_by' => auth()->user()->id
                ]);


                $banner = ProductBrand::where('id', $productId)->first();
                $banner->name = $request->input('name');
                $banner->slug = Str::slug($request->input('name'));
                $banner->description = $request->input('description');
                $banner->created_by = auth()->user()->id;
                $banner->updated_by = auth()->user()->id;
                // Handle image upload
                if ($request->hasFile('brand_image')) {
                    $image = $request->file('brand_image');
                    $imageName = time() . '.' . $image->extension();
                    $image->move(public_path('images'), $imageName);
                    $banner->brand_image = $imageName;
                }
                // Assign other fields here
                $banner->save();
                if ($isCategoryCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.product.brand.list', 'Brand updated successfully', 'success', false);
                }
            } catch (\Exception $e) {

                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        } else {
            $data = ProductBrand::where('uuid', $id)->first();
            return view('admin.brand.edit', compact('data'));
        }
    }

    public function deleteBrand()
    {
    }
}
