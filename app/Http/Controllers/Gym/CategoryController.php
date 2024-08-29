<?php

namespace App\Http\Controllers\Gym;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GymCategory;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    public function index()
    {
        $this->setPageTitle('Category List');
        $data = GymCategory::all();
        return view('admin.product-category.index', compact('data'));
    }

    public function addCategory(Request $request)
    {
        $this->setPageTitle('Category Add');
        if ($request->isMethod('post')) {

            $request->validate([
                'name' => 'required|unique:categories'
            ]);
            DB::beginTransaction();
            try {
                $banner = new Category();
                $banner->name = $request->input('name');
                $banner->description = $request->input('description');
                $banner->created_by = auth()->user()->id;
                $banner->updated_by = auth()->user()->id;
                // Handle image upload
                if ($request->hasFile('category_image')) {
                    $image = $request->file('category_image');
                    $imageName = time().'.'.$image->extension();
                    $image->move(public_path('images'), $imageName);
                    $banner->category_image = $imageName;
                }
                // Assign other fields here
                $banner->save();
                if ($banner) {
                    DB::commit();
                    return $this->responseRedirect('admin.product.brand.list', 'Category created successfully', 'success', false);
                }
            } catch (\Exception $e) {
                echo $e->getMessage();
                die();
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        } else {
            return view('admin.product-category.add');
        }
    }

    public function editCategory(Request $request, $id)
    {
        $productId = uuidtoid($id, 'categories');
        $this->setPageTitle('Category Edit');
        if ($request->isMethod('post')) {

            $request->validate([
                'name' => 'required',
            ]);
            DB::beginTransaction();
            try {
                $isCategoryCreated = Category::where('uuid', $id)->update([
                    'name' => $request['name'],
                    'description' => $request['description'],
                    'created_by' => auth()->user()->id,
                    'updated_by' => auth()->user()->id
                ]);


                $banner =Category::where('id',$productId)->first();
                $banner->name = $request->input('name');
                $banner->description = $request->input('description');
                $banner->created_by = auth()->user()->id;
                $banner->updated_by = auth()->user()->id;
                // Handle image upload
                if ($request->hasFile('category_image')) {
                    $image = $request->file('category_image');
                    $imageName = time().'.'.$image->extension();
                    $image->move(public_path('images'), $imageName);
                    $banner->category_image = $imageName;
                }
                // Assign other fields here
                $banner->save();
                if ($isCategoryCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.product.category.list', 'Category updated successfully', 'success', false);
                }
            } catch (\Exception $e) {

                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        } else {
            $data = Category::where('uuid', $id)->first();
            return view('admin.product-category.edit', compact('data'));
        }
    }
    public function deleteCategory(){

    }
}
