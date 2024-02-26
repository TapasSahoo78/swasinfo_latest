<?php

namespace App\Repositories\Menu;

use App\Contracts\Menu\MenuContract;
use App\Models\Menu;
use App\Repositories\BaseRepository;

/**
 * Class MeuRepository
 *
 * @package \App\Repositories
 */

class MenuRepository extends BaseRepository implements MenuContract
{
    protected $model;

    /**
     * MenuRepository constructor.
     * @param Menu $model
     */

    public function __construct(Menu $model){
        parent::__construct($model);
    }

    public function findMenus(array $filterConditions,string $orderBy='id',$sortBy='asc',$limit= null,$inRandomOrder= false){
        $query = $this->model;
        if(!is_null($filterConditions)){
            $query = $query->where($filterConditions);
        }
        if($inRandomOrder){
            $query = $query->inRandomOrder();
        }else{
            //$query = $query->orderBy('autoboost_time', 'desc');
            //$query = $query->orderBy('membership_plan', 'desc');
            $query = $query->orderBy($orderBy, $sortBy);
        }
        if(!is_null($limit)){
            return $query->paginate($limit);
        }
        return $query->get();
    }

}
