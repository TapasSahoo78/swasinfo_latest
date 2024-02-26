<?php

namespace App\Contracts\Category;

/**
 * Interface AdsContract
 * @package App\Contracts
 */
interface CategoryContract
{
    public function findCategories(array $filterConditions,string $orderBy='id',$sortBy='asc',$limit= null,$inRandomOrder= false);

    public function listMasterCategories(array $filterConditions,string $orderBy='id',$sortBy='asc',$limit= null,$inRandomOrder= false);

    public function getCategories();

    public function findCategoryById(int $id);

    public function createCategory(array $attributes);

    public function updateCategory(array $attributes,int $id);

    public function deleteCategory(int $id);

    public function setCategoryStatus(array $data,int $id);
    public function updateCategoryStatus(array $data,int $id);

    public function updateAttributeStatus(array $data,int $id);

}
