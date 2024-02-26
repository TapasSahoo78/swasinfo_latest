<?php

namespace App\Contracts\Blog;

/**
 * Interface PageContract
 * @package App\Contracts
 */
interface BlogContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listBlogs(array $filterConditions,string $orderBy = 'id', string $sortBy = 'desc', $limit= null,$inRandomOrder= false);

    /**
     * @param array $attributes
     * @return mixed
     */


    public function createBlog(array $attributes);

    /**
     * @param array $attributes
     * @param int $id
     * @return mixed
     */

    public function updateBlog(array $attributes, int $id);

    /**
     * @param int $id
     * @return mixed
     */

    public function deleteBlog(int $id);
}
