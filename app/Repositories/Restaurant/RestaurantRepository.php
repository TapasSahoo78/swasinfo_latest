<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Traits\UploadAble;
use App\Repositories\BaseRepository;
use App\Contracts\Product\ProductContract;
use App\Contracts\RestaurantContract\RestaurantContract;
use App\Models\Media;
use App\Models\Seo;
use App\Models\User;
use App\Models\ProductAttribute;
use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class RestaurantRepository
 *
 * @package \App\Repositories
 */
class RestaurantRepository extends BaseRepository implements RestaurantContract
{
    use UploadAble;


    protected $model;

    protected $mediaModel;

    protected $seoModel;

    protected $userModel;

    protected $productAttributeModel;

    protected $wishlistModel;


    /**
     * ProductRepository constructor.
     * @param Product $model
     * @param Media $mediaModel
     * @param Seo $seoModel
     * @param user $userModel
     * @param ProductAttribute $userModel
     * @param Wishlist $wishlistModel
     */
    public function __construct(Product $model, Media $mediaModel, Seo $seoModel, user $userModel,Wishlist $wishlistModel,ProductAttribute $productAttributeModel){
        parent::__construct($model);

        $this->model = $model;
        $this->mediaModel = $mediaModel;
        $this->seoModel = $seoModel;
        $this->userModel = $userModel;
        $this->productAttributeModel = $productAttributeModel;
        $this->wishlistModel = $wishlistModel;

    }

    public function findProducts($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false){
        // dd($orderBy, $sortBy);
        $products = $this->model;
        if(!is_null($filterConditions)){
            foreach($filterConditions as $fKey => $fCondition){
                if(in_array($fKey, array('category', 'brand'))){
                    $products = $products->whereHas($fKey, function(Builder $query) use($fKey, $fCondition){
                        if(!in_array('All', $fCondition)){
                            $query->whereIn('id', $fCondition)
                            ->orWhereIn('slug',$fCondition);
                        }
                    });
                }
                elseif($fKey == 'priceRange'){
                    $products= $products->whereBetween('price', [ $fCondition['minPrice'],$fCondition['maxPrice']]);
                }elseif($fKey=='search'){
                    $products = $products->whereHas('category', function(Builder $query) use( $fCondition){
                        $query->where('name', 'LIKE', "%$fCondition%");
                    })->orWhere('name','LIKE', "%$fCondition%")
                    ->orWhere('title','LIKE', "%$fCondition%");
                }
                else{
                    $products = $products->where($fKey,$fCondition);
                }
            }
        }
        $products = $products->orderBy($orderBy, $sortBy);

        // dd($products->toSql());
        if (!is_null($limit)) {
            return $products->paginate($limit);
        }
        return $products->get();
    }

    public function findProductById($id){
        return $this->find($id);
    }

    public function findWishlistBYProductId($id){
        //return $this->wishlistModel->find($id);
        return  $this->wishlistModel->where('product_id', $id)->first();
    }


    public function getMaxPrice(){
        return $this->all()->max('price');
    }
    public function getMinPrice(){
        return $this->all()->min('price');
    }

    public function createProduct($attributes){
        $userId= auth()->user()->id;
        $attributes['category_id'] = $attributes['category_id'];
        $attributes['color'] = $attributes['color'];
        $attributes['created_by']= $userId;
        $attributes['updated_by']= $userId;
        /* create product */
        $isProductCreated = $this->create($attributes);

        if ($isProductCreated) {
            /* product image create */
            if (isset($attributes['product_image'])) {
                foreach ($attributes['product_image'] as $image) {
                    $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
                    $isFileUploaded = $this->uploadOne($image, config('constants.SITE_PRODUCT_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                    if ($isFileUploaded) {
                        $isFileRelatedMediaCreated = $isProductCreated->media()->create([
                            'user_id' => $userId,
                            'media_type' => 'image',
                            'file' => $fileName,
                            'is_profile_picture' => false
                        ]);
                    }
                }
            }

            /* product meta details creation */
            // $isProductRelatedSeoCreated = $isProductCreated->seo()->create([
            //     'body' => $attributes['seo'],
            // ]);

            /* product attribute details creation */


            if (isset($attributes['attribute'])) {
                foreach ($attributes['attribute'] as $key => $attribute) {
                    if(!is_null($attribute)){
                        foreach ($attribute['value'] as $vKey=>$value) {
                            if($value!= null){
                                $isProductRelatedAttributeCreated= $isProductCreated->productAttribute()->updateOrCreate(['value'=>$value,'attribute_id' => $key],[
                                    'attribute_id' => $key,
                                    'value' => $value,
                                    'attribute_price' => $attribute['price'][$vKey] ?? $attributes['price'],
                                    'created_by' => $userId,
                                    'updated_by' => $userId
                                ]);
                            }
                        }
                    }
                }
            }
        }
        return $isProductCreated;
    }

    public function updateProduct($attributes, $id){
        $productData = $this->find($id);
        $userId= auth()->user()->id;
        if (isset($attributes['sub_category_id'])) {
            $attributes['category_id'] = $attributes['sub_category_id'];
        }
        $attributes['color'] = $attributes['color'];
        $attributes['created_by']= $userId;
        $attributes['updated_by']= $userId;

        // dd($attributes);

        /* update product */
        $isProductUpdated = $productData->update($attributes);

        if ($isProductUpdated) {
            if (isset($attributes['product_image'])) {
                foreach ($attributes['product_image'] as $image) {
                    $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
                    $isFileUploaded = $this->uploadOne($image, config('constants.SITE_PRODUCT_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                    if ($isFileUploaded) {
                        $isFileRelatedMediaCreated = $productData->media()->create([
                            'user_id' => $userId,
                            'mediaable_type' => get_class($productData),
                            'mediaable_id' => $productData->id,
                            'media_type' => 'image',
                            'file' => $fileName,
                            'is_profile_picture' => false
                        ]);
                    }
                }
            }
            $isProductRelatedSeoUpdated = $productData->seo()->update([
                'body' => $attributes['seo']
            ]);
            if (isset($attributes['attribute'])) {
                $isPreviousAttributeDeleted= $productData->productAttribute()->delete();
                foreach ($attributes['attribute'] as $key => $attribute) {
                    if(!is_null($attribute)){
                        foreach ($attribute['value'] as $vKey=>$value) {
                            if($value!= null){
                                $isProductRelatedAttributeCreated= $productData->productAttribute()->updateOrCreate(['value'=>$value, 'attribute_id' => $key],[
                                    'attribute_id' => $key,
                                    'value' => $value,
                                    'attribute_price' => $attribute['price'][$vKey] ?? $attributes['price'],
                                    'created_by' => $userId,
                                    'updated_by' => $userId
                                ]);
                            }
                        }
                    }
                }
            }
        }
        return $isProductUpdated;
    }

    public function deleteProduct($id)
    {
        $productData = $this->find($id);
        $productData->media()->delete();
        return $productData->delete();
    }
    public function listVendor($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $vendor = $this->userModel->get();
        if (!is_null($limit)) {
            return $vendor->paginate($limit);
        }
        return $vendor;
    }

    public function createWishlist($attributes){
        $userId= auth()->user()->id;
        $attributes['user_id']= $userId;
        $attributes['product_id'] = uuidtoid($attributes['uuid'], 'products');
        /* create product */
        $isWishlistCreated = $this->wishlistModel->create($attributes);

        return $isWishlistCreated;
    }

    public function deleteWishlist($id){
        return $this->wishlistModel->where('product_id',$id)->delete();
    }

     /* public function updateWishlist($attributes, $id){

        return $isProductUpdated;
    } */
}
