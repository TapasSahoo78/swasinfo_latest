<?php

namespace App\Repositories;

use App\Contracts\BaseContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class BaseRepository implements BaseContract
{
    /**
     * model property on class instances
     *
     * @var Model
     */
    protected $model;

    /**
     * Constructor to bind model to repo
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * To Create a record
     *
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * @param array $attributes
     * @param int $id
     * @return Model
     */
    public function update(array $attributes, int $id)
    {
        return $this->find($id)->update($attributes);
    }

    /**
     * To get a record
     *
     * @param integer $id
     * @return Model
     */
    public function find(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * To get a record
     *
     * @param integer $id
     * @return Model || @throws ModelNotFoundException
     */
    public function findOrFail(int $id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function findOneBy(array $data)
    {
        return $this->model->where($data)->first();
    }

    /**
     * @param array $attributes
     * @return Model || @throws ModelNotFoundException
     */
    public function findOneByOrFail(array $data)
    {
        return $this->model->where($data)->firstOrFail();
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function findBy(array $data)
    {
        return $this->model->where($data)->get();
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function findByWithTrashed(array $data)
    {
        return $this->model->where($data)->withTrashed()->get();
    }

    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return Model
     */
    public function all($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc')
    {
        return $this->model->orderBy($orderBy, $sortBy)->get($columns);
    }

     /**
     * To get a record with relations
     *
     * @param mixed $relations
     * @return Model
     */
    public function with($relations)
    {
        return $this->model->with($relations);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id) : bool
    {
        return $this->model->find($id)->delete();
    }
    /**
     * To Update Or Create a record
     *
     * @param array $attributes
     * @return Model
     */
    public function updateOrCreate(array $findAttributes ,array $attributes)
    {
        return $this->model->updateOrCreate($findAttributes,$attributes);
    }
}
