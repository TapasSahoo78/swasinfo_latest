<?php
namespace App\Repositories\Banner;

use App\Models\Banner;
use App\Traits\UploadAble;
use App\Repositories\BaseRepository;
use App\Contracts\Banner\BannerContract;

/**
 * Class UserRepository
 *
 * @package \App\Repositories
 */
class BannerRepository extends BaseRepository implements BannerContract
{
    use UploadAble;

    /**
     * UserRepository constructor.
     * @param Banner $model
     */
    public function __construct(Banner $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function findBanners($filterConditions,$orderBy='id',$sortBy='asc',$limit= null,$inRandomOrder= false){
        $banners= $this->model;
        if(!is_null($filterConditions)){
            $banners= $banners->where($filterConditions);
        }
        $banners= $banners->orderBy($orderBy,$sortBy);
        if(!is_null($limit)){
            return $banners->paginate($limit);
        }
        return $banners->get();
    }

    public function createBanner($attributes){
        $isBannerCreated= $this->create([
            'name' => $attributes['name'],
            'description' => $attributes['description'],
            'order' => $attributes['order'],
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);
        if($isBannerCreated){
            $fileName= $fileName= uniqid().'.'.$attributes['banner_image']->getClientOriginalExtension();
            $isBannerRelatedMediaUploaded= $this->uploadOne($attributes['banner_image'],config('constants.SITE_BANNER_IMAGE_UPLOAD_PATH'), $fileName);
            if($isBannerRelatedMediaUploaded){
                $isBannerCreated->image()->create([
                    'user_id'=> auth()->user()->id,
                    'media_type' => 'image',
                    'file'=> $fileName,
                    'alt_text'=> $attributes['alt_text'],
                    'is_profile_picture' => false
                ]);
            }
        }
        return $isBannerCreated;
    }

    public function updateBanner($attributes,$id){
        $isBannerExist= $this->find($id);
        $isBannerUpdated= $this->update([
            'name' => $attributes['name'],
            'description' => $attributes['description'],
            'order' => $attributes['order'],
            'updated_by' => auth()->user()->id,
        ],$id);
        if($isBannerUpdated){
            if(isset($attributes['banner_image'])){
                $fileName= $fileName= uniqid().'.'.$attributes['banner_image']->getClientOriginalExtension();
                $isBannerRelatedMediaUploaded= $this->uploadOne($attributes['banner_image'],config('constants.SITE_BANNER_IMAGE_UPLOAD_PATH'), $fileName);
                if($isBannerRelatedMediaUploaded){
                    $isBannerExist->image()->update([
                        'file'=> $fileName,
                        'alt_text'=> $attributes['alt_text'],
                    ]);
                }
            }
        }
        return $isBannerUpdated;
    }

    public function deleteBanner($id){
        $isBannerExist= $this->find($id);
        if($isBannerExist){
            $isBannerExist->image()->delete();
            //$isBannerExist->seo()->delete();
            return $isBannerExist->delete();
        }else{
            return false;
        }
    }

}
