<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Services\User\UserService;
use App\Http\Controllers\BaseController;
use App\Services\Product\ProductService;
use App\Services\Store\StoreService;


class FrontendAjaxController extends BaseController
{
    /**
     * @var ProductService
     */
    protected $productService;
    /**
     * @var UserService
     */
    protected $userService;
    /**
     * @var StoreService
     */
    protected $storeService;

    public function __construct(ProductService $productService,UserService $userService,StoreService $storeService){
        $this->productService = $productService;
        $this->userService = $userService;
        $this->storeService = $storeService;
    }

    public function findProducts(Request $request){
        if($request->ajax()){
            $products =[];
            $filterProducts = [
                'is_active' => true
            ];
            if($request->has('category') && $request->category!= 'all'){
                $filterProducts = [
                    'category'=> [$request->category]
                ];
            }

            $isProducts= $this->productService->listProducts($filterProducts,'name');
            if($isProducts->isNotEmpty()){
                foreach ($isProducts as $key => $product) {
                    $products[$key]['name']= $product->title ?? $product->name;
                    $products[$key]['picture']= $product->latest_image;
                    $products[$key]['url']= route('frontend.product.details',$product->uuid);
                    $products[$key]['price']= $product->discounted_price;
                }

            }
            return $this->responseJson(true,200,"Data Found Successfully",$products);
        }else{
            abort(403);
        }
    }

    public function addToCart(Request $request){
        if($request->ajax()){
            $attributes = [];
            if($request->has('uuid')){
                $id = uuidtoid($request->uuid,'products');
                $isProduct= $this->productService->findProductById($id);
                $specifications= $isProduct->specifications;
                if($request->has('attributes')){
                    foreach($request->attributes as $attributekey =>$attributevalue){
                        $attributes[$attributekey]['value']= $attributevalue;
                    }
                }else{
                    // dd($specifications);
                    if(!is_null($specifications)){
                        foreach ($specifications as $key => $value) {
                            $attributes[$key]= array_values($value)[0]['value'];
                        }
                    }
                    $request->merge(['attributes'=>$attributes,'product_id'=>$id,'quantity'=>1]);
                }
                if(auth()->user()){

                    $isCart= $this->userService->createOrUpdateCart($request->except(['_token','uuid']));
                    $datas = auth()->user()->carts;
                    // dd($datas->first()->product->latest_image);
                }else{
                    $cart = session()->get('cart', []);
                    if(isset($cart[$id])) {
                        $cart[$id]['quantity']++;
                    } else {
                        $cart[$id] = [
                            "name" => $isProduct->name,
                            "quantity" => 1,
                            "price" => $isProduct->price,
                            "image" => $isProduct->latest_image,
                            "attributes" => $attributes ?? ''
                        ];
                    }
                    session()->put('cart', $cart);
                    $datas = session()->get('cart', []);
                }
                // foreach($datas as $key=> $value)
                // {
                //      echo($value->product->latest_image);
                // }
                // die();
                $data = [
                    'data'=> $datas,
                    'cartHtml'=> view('frontend.components.cart')->with(['cartProducts' => $datas])->render()
                ];
                // return $data;
                return $this->responseJson(true,200,'Product added to cart',$data);
            }else{
                return $this->responseJson(false,200,'Invalid Params provided');
            }
        }else{
            abort(403);
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function updateCart(Request $request)
    {
        if($request->ajax()){
            if($request->id && $request->quantity){
                if(auth()->user()){
                    $isProductUpdated= auth()->user()->carts()->where('product_id',$request->id )->update([
                        'quantity'=> $request->quantity
                    ]);
                    $datas= auth()->user()->carts;
                }else{
                    $cart = session()->get('cart');
                    $cart[$request->id]["quantity"] = $request->quantity;
                    session()->put('cart', $cart);
                    $datas= session()->get('cart', []);
                }

                $data = [
                    'data'=> session()->get('cart', []),
                    'cartHtml'=> view('frontend.components.cart')->with(['cartProducts' => $datas])->render()
                ];

                return $this->responseJson(true,200,"Product Updated Successfully",$data);
            }
        }else{
            abort(403);
        }

    }

    public function removeFromCart(Request $request)
    {
        if($request->ajax()){
            if($request->id) {
                if(auth()->user()){
                    $isCartDeleted = auth()->user()->carts()->where('product_id',$request->id)->delete();
                    $datas= auth()->user()->carts;
                }
                $cart = session()->get('cart');
                if(isset($cart[$request->id])) {
                    unset($cart[$request->id]);
                    session()->put('cart', $cart);
                    $datas= collect(session()->get('cart',[]));
                }
                $data = [
                    'data'=> session()->get('cart', []),
                    'cartHtml'=> view('frontend.components.cart-detailed')->with(['carts' => $datas ])->render()
                ];

                return $this->responseJson(true,200,"Product Removed Successfully",$data);
            }
        }else{
            abort(403);
        }
    }

    public function clearCart(Request $request){
        if($request->ajax()){
            if(auth()->user()){
                $isCartDeleted= auth()->user()->carts()->delete();
                $datas= auth()->user()->carts;
            }else{
                session()->forget('cart');
                $datas= collect(session()->get('cart',[]));
            }
            $data = [
                'data'=> $datas,
                'cartHtml'=> view('frontend.components.cart-detailed')->with(['carts' => $datas ])->render(),
                 /* 'carCount'=> view('frontend.components.cart-detailed')->with(['carts' => $datas ])->render(), */
            ];
            return $this->responseJson(true,200,"Product Removed Successfully",$data);

        }else{
            abort(403);
        }
    }
    public function storePickup(Request $request){
        if($request->ajax()){

            $zip_code = $request->zip;
            /* dd($zip_code); */
            $address = $this->storeService->findZipcode($zip_code);
            if($address->isNotEmpty()){
                return $this->responseJson(true, 200, "Data Available !!", $address);
            }else{
                return $this->responseJson(false, 200, "Data Unvailable !!");

            }
            
           

        }else{
            abort(403);
        }
    }
}
