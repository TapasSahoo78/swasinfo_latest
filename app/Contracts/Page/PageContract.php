<?php

namespace App\Contracts\Page;

/**
 * Interface PageContract
 * @package App\Contracts
 */
interface PageContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listPages(array $filterConditions,string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */

    public function findPageById(int $id);

    /**
     * @param $slug
     * @return mixed
     */
    public function findPageBySlug($slug);

    /**
     * @param array $params
     * @return mixed
     */
    public function createPage(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updatePage(array $params,string $id);

    /**
     * @param $id
     * @return bool
     */
    public function deletePage($id);

    /**
     * @param array $params
     * @return mixed
     */
    public function updatePageStatus(array $params);

    public function findPage(array $params);
}
