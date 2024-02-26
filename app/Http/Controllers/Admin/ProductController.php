<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use App\Services\Product\ProductService;
use App\Services\Category\CategoryService;
use App\Services\User\UserService;
use App\Services\Brand\BrandService;
use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;

class ProductController extends BaseController
{
    protected $productService;

    protected $categoryService;

    protected $userService;

    protected $brandService;


    public function __construct(ProductService $productService, CategoryService $categoryService, UserService $userService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->userService = $userService;
    }
    public function index(Request $request)
    {
        $this->setPageTitle('All Products');
        if(auth()->user()->id == 1){
            $listCategories = Product::orderBy('created_at', 'desc')->get();
        }else{
            $listCategories = Product::where('created_by',auth()->user()->id)->orderBy('created_at', 'desc')->get();
            }
        return view('admin.product.list', compact('listCategories'));
    }

    public function addProduct(Request $request,$id)
    {

        $productId = uuidtoid($id, 'categories');
        $this->setPageTitle('Add Product');

        $filterConditions = [
            'is_active' => 1,
        ];

        $listCategories = Category::where('is_active','1')->get();
      
       // $listBrands = $this->brandService->listBrands($filterConditions, 'id', 'asc');

       // $listVendor = $this->userService->getSellers();
        if ($request->post()) {
            $request->validate([
                'name' => 'required|string|min:3',
                "price" => 'required|numeric|min:1',
                "category_id" => 'required|exists:categories,id',
                "is_featured" => 'required|in:yes,no'
            ]);
            DB::beginTransaction();
            try {
                $banner = new Product();
                $banner->category_id = $request->input('category_id');
                $banner->name = $request->input('name');
                $banner->title = $request->input('title');
                $banner->price = $request->input('price');
                //$banner->actual_price = $request->input('actual_price');
                $banner->discount = $request->input('discount');
                $banner->stock = $request->input('stock');
                $banner->color = $request->input('color');
                $banner->is_featured = $request->input('is_featured');
                $banner->description = $request->input('description');
                // Handle image upload
                if ($request->hasFile('product_image')) {
                    $imgData=[];
                    $images = $request->file('product_image');
                    foreach ($images as $image) {
                        $imageName = time() . '_' . $image->getClientOriginalName();
                        $image->move(public_path('images'), $imageName);
                        $imgData[] = $imageName;
                        // Save $imageName to the database or perform other operations
                    }
                    $imageString = implode(',', $imgData);
                   
                    $banner->product_image=$imageString;
                }
                $banner->created_by=auth()->user()->id;
                $banner->updated_by=auth()->user()->id;
                
                // Assign other fields here
                $banner->save();
                if ($banner) {
                    DB::commit();
                    return $this->responseRedirect('admin.product.list', 'Product created successfully', 'success', false);
                }

                
            } catch (\Exception $e) {
                echo $e->getMessage();
                die();
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.product.add-product', compact('listCategories','productId','id','productId'));
    }
    public function editProduct(Request $request, $uuid)
    {
        $this->setPageTitle('Edit Product');
        $productId = uuidtoid($uuid, 'products');
        $productData = $this->productService->findProductById($productId);
        $listCategories = Category::where('is_active','1')->get();
        $filterConditions = [];
        $listMasterCategories = $this->categoryService->listMasterCategories($filterConditions, 'id', 'asc');

       // $listBrands = $this->brandService->listBrands($filterConditions, 'id', 'asc');

        //$listVendor = $this->userService->getSellers();

        if (!empty($productData->category->rootAncestor)) {
            $productData->sub_category_id = $productData->category_id;
            $productData->category_id = $productData->category->rootAncestor->id;
        }
        if ($request->post()) {
            $request->validate([
                'name' => 'required|string|min:3',
                "price" => 'required|numeric|min:1',
                "category_id" => 'required|exists:categories,id',
                "is_featured" => 'required|in:yes,no'
            ]);
            DB::beginTransaction();
            try {
                $isproductUpdated = $this->productService->createOrUpdateProduct($request->except('_token'), $productId);
                if ($isproductUpdated) {
                    DB::commit();
                    return $this->responseRedirect('admin.catalog.product.list', 'Product updated successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
      
        return view('admin.product.edit-product', compact('productData','listMasterCategories','listCategories'));
    }

    public function viewProduct(Request $request, $uuid)
    {
        $this->setPageTitle('Product Details');
        $id = uuidtoid($uuid, 'products');
        $productData = $this->productService->findProductById($id);
        return view('admin.product.view', compact('productData'));
    }

    public function deleteProduct(Request $request, $id)
    {
        $productId = uuidtoid($id, 'products');
        DB::beginTransaction();
        try {
            $isProductDeleted = $this->productService->deleteProduct($productId);
            if ($isProductDeleted) {
                DB::commit();
                return $this->responseRedirect('admin.catalog.product.list', 'Product deleted successfully', 'success', false);
            }
        } catch (\Exception $e) {
            DB::rollback();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseRedirectBack('Something went wrong', 'error', true);
        }
    }


    public function bannerlist(Request $request)
    {
        $this->setPageTitle('All Banner');
        $listbanner = Banner::all();
        return view('admin.product.bannerlist', compact('listbanner'));
    }

    public function addBanner(Request $request)
    {
        $this->setPageTitle('Add Banner');

        $filterConditions = [
            'is_active' => 1,
        ];

      
       // $listBrands = $this->brandService->listBrands($filterConditions, 'id', 'asc');

       // $listVendor = $this->userService->getSellers();
        if ($request->post()) {
            $request->validate([
                'title' => 'required|string|min:3',
                "link" => 'required',
                "description" => 'required'
            ]);
            DB::beginTransaction();
            try {
                $banner = new Banner();
                $banner->title = $request->input('title');
                $banner->link = $request->input('link');
                $banner->description = $request->input('description');
                // Handle image upload
                if ($request->hasFile('banner_img_file')) {
                    $image = $request->file('banner_img_file');
                    $imageName = time().'.'.$image->extension();
                    $image->move(public_path('images'), $imageName);
                    $banner->banner_img_file = $imageName;
                }
                // Assign other fields here
                $banner->save();
                if ($banner) {
                    DB::commit();
                    return $this->responseRedirect('admin.product.list', 'Product created successfully', 'success', false);
                }
            } catch (\Exception $e) {
                echo $e->getMessage();
                die();
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.product.add-banner');
    }
    public function editBanner(Request $request, $uuid)
    {

        $this->setPageTitle('Edit Banner');
        $productId = uuidtoid($uuid, 'products');
        echo $uuid;
        die();
        $productData = $this->productService->findProductById($productId);
        $listCategories = Category::where('is_active','1')->get();
        $filterConditions = [];
        $listMasterCategories = $this->categoryService->listMasterCategories($filterConditions, 'id', 'asc');

       // $listBrands = $this->brandService->listBrands($filterConditions, 'id', 'asc');

        //$listVendor = $this->userService->getSellers();

        if (!empty($productData->category->rootAncestor)) {
            $productData->sub_category_id = $productData->category_id;
            $productData->category_id = $productData->category->rootAncestor->id;
        }
        if ($request->post()) {
            $request->validate([
                'name' => 'required|string|min:3',
                "price" => 'required|numeric|min:1',
                "category_id" => 'required|exists:categories,id',
                "is_featured" => 'required|in:yes,no'
            ]);
            DB::beginTransaction();
            try {
                $isproductUpdated = $this->productService->createOrUpdateProduct($request->except('_token'), $productId);
                if ($isproductUpdated) {
                    DB::commit();
                    return $this->responseRedirect('admin.catalog.product.list', 'Product updated successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
      
        return view('admin.product.edit-product', compact('productData','listMasterCategories','listCategories'));
    }

   

    public function deleteBanner(Request $request, $id)
    {
        $productId = uuidtoid($id, 'products');
        DB::beginTransaction();
        try {
            $isProductDeleted = $this->productService->deleteProduct($productId);
            if ($isProductDeleted) {
                DB::commit();
                return $this->responseRedirect('admin.catalog.product.list', 'Product deleted successfully', 'success', false);
            }
        } catch (\Exception $e) {
            DB::rollback();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseRedirectBack('Something went wrong', 'error', true);
        }
    }

    public function addProductimport(Request $request, $id){
        try {
        
           
            $file = request()->file('file');
        
            if ($file !== null && $file->getSize() > 0 && $file->isValid()) {
              
                $importUsers = new ProductImport($id);
                Excel::import($importUsers, $file);
            } else {
                throw new \Exception('The uploaded file is empty, invalid, or not a valid file format.');
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
            die();
            return back()->with('errorr', $th->getMessage());
        }

        return back()->with('successs', 'CSV file imported successfully!');
    }



}
