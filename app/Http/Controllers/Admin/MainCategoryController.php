<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use App\Services\Category\CategoryService;

class CategoryController extends BaseController
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    public function viewCategory()
    {
        $this->setPageTitle('All Categories');
        $filterConditions = [];
        $listCategories = $this->categoryService->listCategories($filterConditions, 'id', 'asc', 15);
        return view('admin.category.list', compact('listCategories'));
    }
    public function categoryDetails(Request $request, $uuid)
    {
        $this->setPageTitle('Category Details');
        $filterConditions = [
            'is_active' => true
        ];
        $categoryId = uuidtoid($uuid, 'categories');

        $categoryData = $this->categoryService->findCategoryById($categoryId);

        $listAttributes = $this->categoryService->listAttributes($filterConditions, 'id', 'asc', 15);
        $categoryAttributes = array();
        if (!empty($categoryData->attribute)) {
            foreach ($categoryData->attribute as $data) {
                $categoryAttributes[] = $data->id;
            }
        }
        return view('admin.category.details', compact('categoryData', 'listAttributes'));
    }

    public function addCategory(Request $request)
    {
        $this->setPageTitle('Add Category');
        $filterConditions = [
            'is_active' => true
        ];
        $listCategories = $this->categoryService->listCategories($filterConditions, 'id', 'asc');
        if ($request->post()) {
            $request->validate([
                'name' => 'required',
            ]);
            DB::beginTransaction();
            try {
                $isCategoryCreated = $this->categoryService->createOrUpdateCategory($request->except('_token'));
                if ($isCategoryCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.catalog.category.list', 'Category created successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.category.add-category', compact('listCategories'));
    }

    public function editCategory(Request $request, $uuid)
    {
        $this->setPageTitle('Edit Category');
        $filterConditions = [
            'is_active' => true
        ];
        $listCategories = $this->categoryService->listCategories($filterConditions, 'id', 'asc');
        $categoryId = uuidtoid($uuid, 'categories');
        $categoryData = $this->categoryService->findCategoryById($categoryId);

        if ($request->post()) {
            $request->validate([
                'name' => 'required'
            ]);
            DB::beginTransaction();
            try {
                $iscategoryUpdated = $this->categoryService->createOrUpdateCategory($request->except('_token'), $categoryId);
                if ($iscategoryUpdated) {
                    DB::commit();
                    return $this->responseRedirect('admin.catalog.category.list', 'Category updated successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.category.edit-category', compact('listCategories', 'categoryData'));
    }

    public function deleteCategory(Request $request, $id)
    {
        $categoryId = uuidtoid($id, 'categories');
        DB::beginTransaction();
        try {
            $isCategoryDeleted = $this->categoryService->deleteCategory($categoryId);
            if ($isCategoryDeleted) {
                DB::commit();
                return $this->responseRedirect('admin.catalog.category.list', 'Category deleted successfully', 'success', false);
            }
        } catch (\Exception $e) {
            DB::rollback();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseRedirectBack('Something went wrong', 'error', true);
        }
    }
    public function viewAttribute()
    {
        $this->setPageTitle('All Attribute');
        $filterConditions = [
            'is_active' => true
        ];
        $listAttributes = $this->categoryService->listAttributes($filterConditions, 'id', 'asc', 15);
        return view('admin.attribute.list', compact('listAttributes'));
    }
    public function addAttribute(Request $request)
    {
        $filterConditions = [
            'is_active' => true
        ];
        $listCategories = $this->categoryService->listMasterCategories($filterConditions, 'id', 'asc', 15);
        $listCategories = $listCategories->chunk(ceil($listCategories->count() / 4));
        $this->setPageTitle('Add Attribute');
        if ($request->post()) {
            $request->validate([
                'name' => 'required',
                'category' => 'required|array',
            ]);
            DB::beginTransaction();
            try {
                $isAttributeCreated = $this->categoryService->createOrUpdateAttribute($request->except('_token'));
                if ($isAttributeCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.catalog.attribute.list', 'Attribute created successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.attribute.add-attribute', compact('listCategories')); //,''
    }

    public function editAttribute(Request $request, $uuid)
    {
        $this->setPageTitle('Edit Attribute');
        $filterConditions = [
            'is_active' => true
        ];
        $attributeId = uuidtoid($uuid, 'attributes');
        $attributeData = $this->categoryService->findAttributeById($attributeId);
        $listCategories = $this->categoryService->listMasterCategories($filterConditions, 'id', 'asc', 15);
        $listCategories = $listCategories->chunk(ceil($listCategories->count() / 4));
        if ($request->post()) {
            $request->validate([
                'name' => 'required',
                'category' => 'required|array',
            ]);
            DB::beginTransaction();
            try {
                $iscategoryUpdated = $this->categoryService->createOrUpdateAttribute($request->except('_token'), $attributeId);
                if ($iscategoryUpdated) {
                    DB::commit();
                    return $this->responseRedirect('admin.catalog.attribute.list', 'Attribute updated successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.attribute.edit-attribute', compact('attributeData', 'listCategories'));
    }

    public function addAttributeValue(Request $request)
    {
        if ($request->post()) {
            $request->validate([
                'attribute_id' => 'required',
                'value' => 'required',
            ]);
            DB::beginTransaction();
            try {
                $isAttributeValue = $this->categoryService->createOrUpdateAttributeValue($request->except('_token'));
                if ($isAttributeValue) {
                    DB::commit();
                    return $this->responseRedirect('admin.catalog.attribute.list', 'Attribute value created successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
    }
    public function deleteAttribute(Request $request, $id)
    {
        $attributeId = uuidtoid($id, 'attributes');
        DB::beginTransaction();
        try {
            $isCategoryDeleted = $this->categoryService->deleteAttribute($attributeId);
            if ($isCategoryDeleted) {
                DB::commit();
                return $this->responseRedirect('admin.catalog.attribute.list', 'Attribute deleted successfully', 'success', false);
            }
        } catch (\Exception $e) {
            DB::rollback();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseRedirectBack('Something went wrong', 'error', true);
        }
    }
}
