<?php

namespace App\Services\Menu;

use App\Contracts\Menu\MenuContract;

class MenuService
{

    protected $menuRepository;

    public function __construct(MenuContract $menuRepository){
        $this->menuRepository = $menuRepository;
    }

    public function listMenus(array $filterConditions,string $orderBy='id',$sortBy='asc',$limit= null,$inRandomOrder= false){
        return $this->menuRepository->findMenus($filterConditions,$orderBy,$sortBy,$limit,$inRandomOrder);
    }

    public function findMenu($id){
        return $this->menuRepository->find($id);
    }

    public function createOrUpdateMenu($attributes,$id= null){
        $attributes['is_header']= $attributes['menu_position']== 'header' ? true : false;
        $attributes['is_footer']= $attributes['menu_position']== 'footer' ? true : false;
        if($attributes['page_id']){
            $attributes['page_id']= uuidtoid($attributes['page_id'],'pages');
            $attributes['url']= route('frontend.pages.any.pages',$attributes['url']);
        }else{
            $attributes['url'] = $attributes['external_url'];
        }
        if(is_null($id)){
            return $this->menuRepository->create($attributes);
        }else{
            $attributes['position']= $attributes['position'] ?? null;
            return $this->menuRepository->update($attributes,$id);
        }
    }

    public function updateMenu($attributes,$id){
        if(isset($attributes['value'])){
            $attributes['status']= $attributes['value']==1 ? 1 : 0;
        }
        return $this->menuRepository->update($attributes,$id);
    }
    public function deleteMenu($id){
        return $this->menuRepository->delete($id);
    }
}
