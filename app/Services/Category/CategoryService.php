<?php

namespace App\Services\Category;

use App\Contracts\Category\CategoryContract;

class CategoryService
{
    /**
     * @var CategoryContract
     */
    protected $categoryRepository;

    /**
     * CategoryService constructor
     */
    public function __construct(CategoryContract $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function listCategories(array $filterConditions, string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->categoryRepository->findCategories($filterConditions, $orderBy, $sortBy, $limit);
    }
    public function listMasterCategories(array $filterConditions, string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->categoryRepository->listMasterCategories($filterConditions, $orderBy, $sortBy, $limit);
    }
    public function listBrands(array $filterConditions, string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->categoryRepository->listBrands($filterConditions, $orderBy, $sortBy, $limit);
    }
    public function listAttributes(array $filterConditions, string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->categoryRepository->listAttributes($filterConditions, $orderBy, $sortBy, $limit);
    }
    public function findAttributeById($id)
    {
        return $this->categoryRepository->findAttributeById($id);
    }
    public function createOrUpdateAttribute(array $attributes, $id = null)
    {
        if (is_null($id)) {
            return $this->categoryRepository->createAttribute($attributes);
        } else {
            return $this->categoryRepository->updateAttribute($attributes, $id);
        }
    }

    public function createOrUpdateAttributeValue(array $attributes, $id = null)
    {
        if (is_null($id)) {
            return $this->categoryRepository->createAttributeValue($attributes);
        } else {
            return $this->categoryRepository->updateAttributeValue($attributes, $id);
        }
    }
    public function deleteAttribute(int $id)
    {
        return $this->categoryRepository->deleteAttribute($id);
    }
    public function getCategories()
    {
        return $this->categoryRepository->getCategories();
    }
    public function findCategoryById($id)
    {
        return $this->categoryRepository->findCategoryById($id);
    }

    public function createOrUpdateCategory(array $attributes, $id = null)
    {
        if (is_null($id)) {
            return $this->categoryRepository->createCategory($attributes);
        } else {
            return $this->categoryRepository->updateCategory($attributes, $id);
        }
    }

    public function deleteCategory(int $id)
    {
        return $this->categoryRepository->deleteCategory($id);
    }

    public function updateStatus(array $attributes, $id)
    {
        $data['status'] = $attributes['value'] == '1' ? 1 : 0;
        return $this->categoryRepository->setCategoryStatus($data, $id);
    }
    public function updateCategoryStatus(array $attributes, $id)
    {
        $data['is_active'] = $attributes['value'] == '1' ? 1 : 0;
        return $this->categoryRepository->updateCategoryStatus($data, $id);
    }

    public function updateAttributeStatus(array $attributes, $id)
    {
        $data['is_active'] = $attributes['value'] == '1' ? 1 : 0;
        return $this->categoryRepository->updateAttributeStatus($data, $id);
    }
}
