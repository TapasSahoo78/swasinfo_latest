<?php
namespace App\Repositories\Blog;

use App\Models\Blog;
use App\Traits\UploadAble;
use App\Repositories\BaseRepository;
use App\Contracts\Blog\BlogContract;

/**
 * Class UserRepository
 *
 * @package \App\Repositories
 */
class BlogRepository extends BaseRepository implements BlogContract
{
    use UploadAble;

    /**
     * UserRepository constructor.
     * @param Blog $model
     */
    public function __construct(Blog $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function listBlogs($filterConditions,$orderBy='id',$sortBy='asc',$limit= null,$inRandomOrder= false){
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

    public function createBlog($attributes){
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

    public function updateBlog($attributes,$id){
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

    public function deleteBlog($id){
        $isBannerExist= $this->find($id);
        if($isBannerExist){
            $isBannerExist->image()->delete();
            $isBannerExist->seo()->delete();
            return $isBannerExist->delete();
        }else{
            return false;
        }
    }

}
