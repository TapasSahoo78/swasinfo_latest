<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use App\Services\Banner\BannerService;
use App\Services\Blog\BlogService;
use App\Services\Brand\BrandService;
use App\Services\Category\CategoryService;
use App\Services\Faq\FaqService;
use App\Services\Product\ProductService;
use App\Services\Testimonial\TestimonialService;
use Illuminate\Http\Request;

/* use App\Services\Banner\BannerService; */

class FrontendController extends BaseController
{

    //protected $bannerService;
    protected $brandService;
    protected $categoryService;
    protected $productService;
    protected $bannerService;
    protected $testimonialService;
    protected $blogService;
    protected $faqService;

    public function __construct(BrandService $brandService, CategoryService $categoryService, ProductService $productService, BannerService $bannerService, TestimonialService $testimonialService, BlogService $blogService, FaqService $faqService)
    {
        $this->brandService = $brandService;
        $this->categoryService = $categoryService;
        $this->productService = $productService;
        $this->bannerService = $bannerService;
        $this->testimonialService = $testimonialService;
        $this->blogService = $blogService;
        $this->faqService = $faqService;

    }

    public function index(Request $request)
    {
        $this->setPageTitle('Home');
        $filterConditions = [
            'is_popular' => true,
            'is_active' => true,
        ];
        $filterProducts = [
            'category' => ['delta-8'],
        ];
        $filterBrandProducts = [
            'brand' => ['cannamoly', 'pluscbd'],
        ];
        $filterBanners = [
            'is_active' => 1,
        ];

        $filterCategories = [
            'is_active' => true,
        ];
        $filterTestimonials = [
            'status' => true,
        ];
        $filterBlogs = [
            'is_active' => true,
        ];

        $listBrands = $this->brandService->listBrands($filterConditions, 'id', 'asc');
        $listBlogs = $this->blogService->listBlogs($filterBlogs, 'id', 'asc', 3);
        // dd($listBlogs);
        $categories = $this->categoryService->listMasterCategories($filterCategories, 'id', 'asc');
        // dd($categories);
        $listDelta8Products = $this->productService->listProducts($filterProducts, 'id', 'asc');
        $canamolyCbdProducts = $this->productService->listProducts($filterBrandProducts, 'id', 'asc');
        $banners = $this->bannerService->listBanners($filterBanners, 'id', 'asc');
        $listTestimonials = $this->testimonialService->listTestimonials($filterTestimonials, 'id', 'asc', 10);
        return view('frontend.index', compact('listBrands', 'listDelta8Products', 'banners', 'canamolyCbdProducts', 'categories', 'listTestimonials', 'listBlogs'));
    }

    public function products(Request $request)
    {
        $this->setPageTitle('Products');
    }

    public function productDetails(Request $request, $uuid)
    {
        $this->setPageTitle('Product-Details');
        $id = uuidtoid($uuid, 'products');
        $productData = $this->productService->findProductById($id);
        if ($productData) {
            $relatedProductCondition = [
                'is_active' => true,
                'category_id' => $productData->category_id,
            ];
            $relatedProducts = $this->productService->listProducts($relatedProductCondition, 'id', 'asc');
        }
        return view('frontend.product.details', compact('productData', 'relatedProducts'));
    }

    public function shopByType(Request $request)
    {
        $this->setPageTitle('Shop By Type', ($request->type ?? ''));
        $type = $request->type;
        $orderBy = 'id';
        $sortBy = $request->sortBy ?? 'asc';
        $paginate = $request->paginate ?? 12;
        $filterProducts = [
            'is_active' => true,
        ];
        if ($request->has('categories')) {
            $filterProducts = [
                'category' => $request->categories,
            ];
        }
        if ($request->value) {
            $filterProducts = [
                'brand' => [$request->value],
            ];
        }
        if ($request->has('brands')) {
            $filterProducts = [
                'brand' => $request->brands,
            ];
        }
        if ($request->has('orderBy')) {
            if ($request->orderBy == 'newest') {
                $orderBy = 'created_at';
                $sortBy = 'desc';
            } else if ($request->orderBy == 'lowtoHigh') {
                $orderBy = 'price';
            } else if ($request->orderBy == 'hightolow') {
                $orderBy = 'price';
                $sortBy = 'desc';
            } else if ($request->orderBy == 'featured') {
                $filterProducts = [
                    'is_featured' => 'yes',
                ];
            }
        }
        if ($request->has('priceRange')) {
            $price = explode('-', $request->priceRange);
            $filterProducts['priceRange']['minPrice'] = $price[0];
            $filterProducts['priceRange']['maxPrice'] = $price[1];
        }
        if ($request->has('sliderPrice')) {
            $filterProducts['priceRange']['minPrice'] = trim(str_replace('$', '', $request->sliderPrice['min']));
            $filterProducts['priceRange']['maxPrice'] = trim(str_replace('$', '', $request->sliderPrice['max']));
        }
        switch ($type) {
            case 'brand':
                $filterConditions = [
                    'is_popular' => true,
                    'is_active' => true,
                ];
                $data['brands'] = $this->brandService->listBrands($filterConditions, 'id', 'asc');
                break;
            default:
                $commonConditions = [
                    'is_active' => true,
                ];
                $data['brands'] = $this->brandService->listBrands($commonConditions, 'id', 'asc');
                $data['categories'] = $this->categoryService->listCategories($commonConditions, 'id', 'asc');
                break;
        }
        $products = $this->productService->listProducts($filterProducts, $orderBy, $sortBy, $paginate);
        if ($request->ajax()) {
            $data = [
                'productHtml' => view('frontend.shop.partials.product')->with(['products' => $products])->render(),
                'producthorizontalHtml' => view('frontend.shop.partials.product-horizontal')->with(['products' => $products])->render(),
                'paginationHtml' => view('admin.product.partials.paginate')->with(['paginatedCollection' => $products]),
            ];
            return $this->responseJson(true, 200, 'Data Found Successfully', $data);
        }
        return view('frontend.shop.by-type', compact('data', 'products'));
    }

    public function shopByCategory(Request $request)
    {
        $this->setPageTitle('Shop By Category', ($request->slug ?? ''));
        $type = $request->type;
        $orderBy = 'id';
        $sortBy = $request->sortBy ?? 'asc';
        $paginate = $request->paginate ?? 12;
        $filterConditions = [
            'is_active' => true,
        ];
        $filterProducts = [
            'is_active' => true,
        ];
        if ($request->has('categories')) {
            $filterProducts = [
                'category' => $request->categories,
            ];
        } else {
            if ($request->slug != 'all') {
                $filterProducts = [
                    'category' => [$request->slug],
                ];
            }

        }
        if ($request->has('orderBy')) {
            if ($request->orderBy == 'newest') {
                $orderBy = 'created_at';
                $sortBy = 'desc';
            } else if ($request->orderBy == 'lowtoHigh') {
                $orderBy = 'price';
            } else if ($request->orderBy == 'hightolow') {
                $orderBy = 'price';
                $sortBy = 'desc';
            } else if ($request->orderBy == 'featured') {
                $filterProducts = [
                    'is_featured' => 'yes',
                ];
            }
        }

        if ($request->has('search')) {
            $filterProducts = [
                'search' => $request->search,
            ];
        }
        if ($request->has('priceRange')) {
            $price = explode('-', $request->priceRange);
            $filterProducts['priceRange']['minPrice'] = $price[0];
            $filterProducts['priceRange']['maxPrice'] = $price[1];
        }

        if ($request->has('sliderPrice')) {
            $filterProducts['priceRange']['minPrice'] = trim(str_replace('$', '', $request->sliderPrice['min']));
            $filterProducts['priceRange']['maxPrice'] = trim(str_replace('$', '', $request->sliderPrice['max']));
        }

        $data['categories'] = $this->categoryService->listCategories($filterConditions, 'id', 'asc');
        $products = $this->productService->listProducts($filterProducts, $orderBy, $sortBy, $paginate);
        if ($request->ajax()) {
            $data = [
                'productHtml' => view('frontend.shop.partials.product')->with(['products' => $products])->render(),
                'paginationHtml' => view('admin.product.partials.paginate')->with(['paginatedCollection' => $products]),
            ];
            return $this->responseJson(true, 200, 'Data Found Successfully', $data);
        }

        return view('frontend.shop.by-category', compact('data', 'products'));
    }
    public function cart(Request $request)
    {
        $this->setPageTitle('Cart');
        return view('frontend.cart');
    }

    public function blogDetails(Request $request, $uuid)
    {
        $this->setPageTitle('Blog Details');
        $filterByPopularConditions = [
            'is_featured' => 1,
        ];
        $blogId = uuidtoid($uuid, 'blogs');
        $blogData = $this->blogService->findBlogById($blogId);
        $listPopularBlogs = $this->blogService->listBlogs($filterByPopularConditions, 'id', 'asc', 15);
        return view('frontend.blog.blog-details', compact('blogData','listPopularBlogs'));
    }

}
