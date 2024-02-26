<?php

namespace App\Services\Content;

use Str;
use Illuminate\Support\Carbon;
use App\Contracts\Content\ContentContract;

class ContentService
{
    /**
     * @var ContentContract
     */
    protected $contentRepository;

	/**
     * UserService constructor
     */
    public function __construct(ContentContract $contentRepository){
        $this->contentRepository= $contentRepository;
    }

    public function listContents(array $filterConditions,string $orderBy='id',$sortBy='asc',$limit= null,$inRandomOrder= false){
        return $this->contentRepository->findContents($filterConditions,$orderBy,$sortBy,$limit);
    }
    // public function updateCategories(array $filterConditions,string $orderBy='id',$sortBy='asc',$limit= null,$inRandomOrder= false){
    //     return $this->categoryRepository->findCategories($filterConditions,$orderBy,$sortBy,$limit);
    // }
    // public function getContents(){
    //     return $this->contentRepository->getContents();
    // }
    // public function findByIdContents($id){
    //     return $this->contentRepository->findByIdContents($id);
    // }
}
