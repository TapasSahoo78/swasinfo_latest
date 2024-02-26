<?php

namespace App\Services\Blog;
use App\Contracts\Blog\BlogContract;

class BlogService
{
    /**
     * @var BlogContract
     */
    protected $blogRepository;

	/**
     * BlogService constructor
     */
    public function __construct(BlogContract $blogRepository){
        $this->blogRepository= $blogRepository;
    }
    public function listBlogs(array $filterConditions,string $orderBy='id',$sortBy='asc',$limit= null,$inRandomOrder= false){
        return $this->blogRepository->listBlogs($filterConditions,$orderBy,$sortBy,$limit,$inRandomOrder);
    }

    public function findBlogById($id){
        return $this->blogRepository->find($id);
    }

    public function createOrUpdateBlog(array $attributes, $id = null){
        if (is_null($id)) {
            return $this->blogRepository->createBlog($attributes);
        } else {
            return $this->blogRepository->updateBlog($attributes, $id);
        }
    }
    public function updateBlogStatus($attributes,$id){
        $attributes['is_active']= $attributes['value'] == '1' ? 1 : 0;
        return $this->blogRepository->update($attributes, $id);
    }

    public function deleteBlog(int $id){
        return $this->blogRepository->deleteBlog($id);
    }
}
