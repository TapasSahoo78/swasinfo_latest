<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Models\PlanCategory;
use App\Traits\UploadAble;
use App\Repositories\BaseRepository;
use App\Contracts\Category\CategoryContract;
use App\Models\Media;
use App\Models\Attribute;
use App\Models\AttributeValue;

/**
 * Class UserRepository
 *
 * @package \App\Repositories
 */
class CategoryRepository extends BaseRepository implements CategoryContract
{
    use UploadAble;


    protected $model;
    protected $mediaModel;
    protected $attributeModel;

    protected $attributeValueModel;
    protected $categoryModel;
    /**
     * CategoryRepository constructor.
     * @param Category $categoryModel
     * @param PlanCategory $model
     * @param Media $mediaModel
     *  @param Attribute $attributeModel
     */
    public function __construct(PlanCategory $model, Category $categoryModel, Media $mediaModel, Attribute $attributeModel, AttributeValue $attributeValueModel)
    {
        parent::__construct($model);
        $this->model = $model;
        $this->categoryModel = $categoryModel;
        $this->mediaModel = $mediaModel;
        $this->attributeModel = $attributeModel;
        $this->attributeValueModel = $attributeValueModel;
    }
    public function findCategories($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $categories = $this->model->where($filterConditions)->orderBy($orderBy,$sortBy);
        if (!is_null($limit)) {
            return $categories->paginate($limit);
        }
        return $categories->get();
    }
    public function listMasterCategories($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $categories = $this->model->get();
       // dd($categories);
        return $categories;
    }
    public function findAttributes($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $attribute = $this->attributeModel;

        if (!is_null($filterConditions)) {
            $attribute= $attribute->where($filterConditions);
        }

        $attribute= $attribute->orderBy($orderBy,$sortBy);
        if (!is_null($limit)) {
            return $attribute->paginate($limit);
        }
        return $attribute->get();
    }
    public function getCategories()
    {
        return $this->with('subcategories')->where(['parent_id' => 0])->get();
    }
    public function findCategoryById($id)
    {
        return $this->find($id);
    }
    public function createCategory($attributes)
    {
        $isCategoryCreated = $this->create([
            'category_name' => $attributes['category_name']
            /* 'parent_id' => $attributes['parent_id'] && $attributes['parent_id'] > 0 ? $attributes['parent_id'] : NULL,
            'description' => $attributes['description'],
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id */
        ]);
       /*  if ($isCategoryCreated) {
            if (isset($attributes['category_image'])) {
                foreach ($attributes['category_image'] as $image) {
                    $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
                    $isFileUploaded = $this->uploadOne($image, config('constants.SITE_CATEGORY_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                    if ($isFileUploaded) {
                        $isFileRelatedMediaCreated = $isCategoryCreated->media()->create([
                            'user_id' => auth()->user()->id,
                            'mediaable_type' => get_class($isCategoryCreated),
                            'mediaable_id' => $isCategoryCreated->id,
                            'media_type' => 'image',
                            'file' => $fileName,
                            'is_profile_picture' => false
                        ]);
                    }
                }
            }
        } */

        return $isCategoryCreated;
    }
    public function updateCategory($attributes, $id)
    {
        $categoryData = $this->find($id);
        $isCategoryUpdated = $this->update([
            'category_name' => $attributes['category_name']
        ], $id);

       /*  if ($isCategoryUpdated) {
            if (isset($attributes['category_image'])) {
                foreach ($attributes['category_image'] as $image) {
                    $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
                    $isFileUploaded = $this->uploadOne($image, config('constants.SITE_CATEGORY_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                    if ($isFileUploaded) {
                        $isFileRelatedMediaCreated = $categoryData->media()->create([
                            'user_id' => auth()->user()->id,
                            'media_type' => 'image',
                            'file' => $fileName,
                            'is_profile_picture' => false
                        ]);
                    }
                }
            }
        } */
        return $isCategoryUpdated;
    }
    public function setCategoryStatus($attributes, $id)
    {
        return $this->update($attributes, $id);
    }
    public function updateCategoryStatus($attributes, $id)
    {
        return $this->categoryModel->find($id)->update($attributes);
    }
    public function deleteCategory($id)
    {
        $category = $this->findCategoryById($id);
        ## Delete page seo

        $category->delete();
        return $category ?? false;
    }
    public function listAttributes($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $attribute = $this->attributeModel->get();
        if (!is_null($limit)) {
            return $attribute->paginate($limit);
        }
        return $attribute;
    }
    public function findAttributeById($id)
    {
        return $this->attributeModel->find($id);
    }
    public function createAttribute($attributes)
    {
        $isAttributCreated = $this->attributeModel->create([
            'name' => $attributes['name'],
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id
        ]);
        if ($isAttributCreated->id) {
            foreach ($attributes['category']  as $cat_id) {
                $category = $this->find($cat_id);
                $isAttributeAttached = $category->attribute()->attach($isAttributCreated);
            }
        }
        return $isAttributCreated;
    }
    public function createAttributeValue($attributes)
    {
        return $this->attributeValueModel->create([
            'value' => $attributes['value'],
            'attribute_id' => $attributes['attribute_id'],
        ]);
    }
    public function updateAttribute($attributes, $id)
    {
        $isAttribute = $this->attributeModel->where('id', $id)->first();
        $isAttributeUpdate =  $this->attributeModel->where('id', $id)->update([
            'name' => $attributes['name'],
            'updated_by' => auth()->user()->id
        ]);
        if ($isAttribute->id) {

            $category = $this->model->whereIn('id', $attributes['category'])->get();
            $isAttribute->categories()->detach();
            $isAttribute->categories()->attach($category);
        }
        return $isAttributeUpdate;
    }
    public function deleteAttribute($id)
    {
        $attribute = $this->findAttributeById($id);
        ## Delete page seo
        if ($attribute) {
            $attribute->is_active = 3;
            $attribute->update();
            $attribute->delete();
        }
        return $attribute ?? false;
    }

    public function updateAttributeStatus($attributes, $id)
    {
        return $this->attributeModel->find($id)->update($attributes);
    }


}
