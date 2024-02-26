<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\CategoryAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttributeController extends BaseController
{
    public function index()
    {
        $this->setPageTitle('Attribute List');
        $data = Attribute::with('categories')->get();

        return view('admin.product-attribute.index', compact('data'));
    }

    public function addAttribute(Request $request)
    {
        $this->setPageTitle('Attribute Add');
        if ($request->isMethod('post')) {

            $request->validate([
                'steps' => 'required|unique:attributes',
                'points' => 'required|unique:attributes',
                'discount' => 'required|unique:attributes',
            ]);
            DB::beginTransaction();
            try {
                $isAttributeCreated = Attribute::create([
                    'steps' => $request['steps'],
                    'points' => $request['points'],
                    'discount' => $request['discount'],
                    'created_by' => auth()->user()->id,
                    'updated_by' => auth()->user()->id
                ]);
                if ($isAttributeCreated) {
                    $isAttributeWithCategory = $isAttributeCreated->categories()->attach($request->category);
                }

                if ($isAttributeCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.product.points.list', 'Attribute created successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        } else {
            $listCategories = Category::all();
            $listCategories = $listCategories->chunk(ceil($listCategories->count() / 3));
            return view('admin.product-attribute.add', compact('listCategories'));
        }
    }

    public function editAttribute(Request $request, $id)
    {
        $this->setPageTitle('Attribute Edit');
        if ($request->isMethod('post')) {
            $request->validate([
                'steps' => 'required'
            ]);
            DB::beginTransaction();
            try {
                $isAttribute = Attribute::where('uuid', $id)->first();
                $isAttributeCreated = Attribute::where('uuid', $id)->update([
                    'steps' => $request['steps'],
                    'points' => $request['points'],
                    'discount' => $request['discount'],
                    'created_by' => auth()->user()->id,
                    'updated_by' => auth()->user()->id
                ]);

                // if ($isAttribute->id) {
                //     $category = Category::whereIn('id', $request['category'])->get();
                //     $isAttribute->categories()->detach();
                //     $isAttribute->categories()->attach($category);
                // }

                if ($isAttributeCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.product.points.list', 'Attribute updated successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        } else {
            $listCategories = Category::all();
            $listCategories = $listCategories->chunk(ceil($listCategories->count() / 3));
            $data = Attribute::where('uuid', $id)->first();
            return view('admin.product-attribute.edit', compact('data', 'listCategories'));
        }
    }

    public function deleteCategory()
    {
    }
}
