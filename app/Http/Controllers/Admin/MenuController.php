<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\Menu\MenuService;
use App\Services\Page\PageService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;

class MenuController extends BaseController
{

    public function __construct(MenuService $menuService,PageService $pageService)
    {
        $this->menuService = $menuService;
        $this->pageService = $pageService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filterConditions= [

        ];
        $listMenus=$this->menuService->listMenus($filterConditions,'id','asc',15);

        $this->setPageTitle('All Menus');
        return view('admin.menu.index',compact('listMenus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $filterConditions= [
            'status' => true
        ];
        $this->setPageTitle('Add Menu');
        $pages= $this->pageService->listPages($filterConditions);
        return view('admin.menu.add',compact('pages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required|unique:menus',
            'menu_position' => 'required',
            'position' => 'required_if:menu_position,footer',
            'is_external' =>'required|in:0,1',
            'url' => 'required_if:is_external,0|string',
            'external_url' => 'required_if:is_external,1|url'
        ]);
        // dd($request->all());
        DB::beginTransaction();
        try{

            $isMenuCreated= $this->menuService->createOrUpdateMenu($request->except('_token'));
            if($isMenuCreated){
                DB::commit();
                return $this->responseRedirect('admin.menu.list','Menu Created Successfully','success');
            }
        }catch(\Exception $e){
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            DB::rollBack();
            return $this->responseRedirectBack('Something Went Wrong','error',true);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id= uuidtoid($id,'menus');
        $filterConditions= [
            'status' => true
        ];
        $pages= $this->pageService->listPages($filterConditions);
        $menuData= $this->menuService->findMenu($id);
        $this->setPageTitle('Edit Menu');
        return view('admin.menu.edit',compact('pages','menuData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id= uuidtoid($id,'menus');
        $request->validate([
            'name'=> 'required|unique:menus,name,'.$id,
            'menu_position' => 'required',
            'position' => 'required_if:menu_position,footer',
            'url' => 'required_if:is_external,0|string',
            'external_url' => 'required_if:is_external,1|url'
        ]);
        // dd($request->all());
        DB::beginTransaction();
        // try{
            $isMenuUpdated= $this->menuService->createOrUpdateMenu($request->except('_token'),$id);
            if($isMenuUpdated){
                DB::commit();
                return $this->responseRedirect('admin.menu.list','Menu Updated Successfully','success');
            }
        // }catch(\Exception $e){
        //     logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
        //     DB::rollBack();
        //     return $this->responseRedirectBack('Something Went Wrong','error',true);
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menuId = uuidtoid($id, 'menus');
        DB::beginTransaction();
        try {
            $isMenuDeleted = $this->menuService->deleteMenu($menuId);
            if ($isMenuDeleted) {
                DB::commit();
                return $this->responseRedirect('admin.menu.list', 'Menu deleted successfully', 'success', false);
            }
        } catch (\Exception $e) {
            DB::rollback();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseRedirectBack('Something went wrong', 'error', true);
        }
    }
}
