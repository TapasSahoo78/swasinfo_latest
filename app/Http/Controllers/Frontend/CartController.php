<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use App\Services\Banner\BannerService;
use App\Services\Brand\BrandService;
use App\Services\Category\CategoryService;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;

/* use App\Services\Banner\BannerService; */

class CartController extends BaseController
{

    //protected $bannerService;
    protected $brandService;
    protected $categoryService;
    protected $productService;
    protected $bannerService;

    public function __construct(BrandService $brandService, CategoryService $categoryService, ProductService $productService, BannerService $bannerService)
    {
        $this->brandService = $brandService;
        $this->categoryService = $categoryService;
        $this->productService = $productService;
        $this->bannerService = $bannerService;

    }

    public function cart(Request $request)
    {
        $this->setPageTitle('Cart');

        return view('frontend.cart');
    }

}
