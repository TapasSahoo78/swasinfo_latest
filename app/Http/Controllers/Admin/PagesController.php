<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;

use Illuminate\Http\Request;
use App\Services\Page\PageService;
use App\Models\Page;

class PagesController extends BaseController
{
    protected $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    public function viewPage()
    {
        $this->setPageTitle('All Pages');
        $filterConditions = [
        ];
        $listPages = $this->pageService->listPages($filterConditions, 'id', 'asc', 15);
        return view('admin.page.list', compact('listPages'));
    }

    public function addPage(Request $request)
    {
        $this->setPageTitle('Add Page');
        /* $filterConditions = [
            'is_active' => true
        ];
 */
        if ($request->post()) {
            $request->validate([
                'title' => 'required',
                "description" => 'required',
            ]);
            \DB::beginTransaction();
            /* try { */
                $ispageCreated = $this->pageService->createOrUpdatePage($request->except('_token'));
                if ($ispageCreated) {
                    \DB::commit();
                    return $this->responseRedirect('admin.page.list', 'Page created successfully', 'success', false);
                }
            /* } catch (\Exception $e) {
                \DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            } */
        }
        return view('admin.page.add-page');
    }
    public function editPage(Request $request,$uuid){
        $this->setPageTitle('Edit Page');
        /* $filterConditions= [
            'status'=> true
        ]; */
        $pageId= uuidtoid($uuid,'pages');
        $pageData= $this->pageService->findPageById($pageId);
        if($request->post()){
            \DB::beginTransaction();
          /*    try{ */
                $ispageUpdated= $this->pageService->createOrUpdatePage($request->except('_token'),$pageId);
                if($ispageUpdated){
                    \DB::commit();
                    return $this->responseRedirect('admin.page.list','Page updated successfully','success',false);
                }
           /*  }catch(\Exception $e){
                \DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong','error',true);
            } */
        }
        return view('admin.page.edit-page',compact('pageData'));
    }

    public function deletePage(Request $request,$id){
        $pageId =uuidtoid($id,'pages');
        \DB::beginTransaction();
        try{
           $isPageDeleted= $this->pageService->deletePage($pageId);
            if($isPageDeleted){
                \DB::commit();
                return $this->responseRedirect('admin.page.list','Page deleted successfully','success',false);
            }
        }catch(\Exception $e){
            \DB::rollback();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseRedirectBack('Something went wrong','error',true);
        }
    }

}
