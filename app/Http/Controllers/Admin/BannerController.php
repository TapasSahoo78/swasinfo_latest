<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Services\Banner\BannerService;

class BannerController extends BaseController
{

    protected $bannerService;

    public function __construct(BannerService $bannerService) {
        $this->bannerService = $bannerService;
    }


    public function viewBanners() {
        $this->setPageTitle('All Banners');
        $filterConditions = [
            'is_active' => true
        ];
        $listBanners = $this->bannerService->listBanners($filterConditions, 'id', 'asc', 15);
        return view('admin.banner.list', compact('listBanners'));
    }

    public function addBanner(Request $request) {
        $this->setPageTitle('Add Banner');
        if ($request->post()) {
           $request->validate([
                'name' => 'required',
                "description" => 'required',
                "order" => 'required|numeric|unique:banners,order',
                "banner_image" => 'required|file|mimes:jpg,png,gif,jpeg',
            ]);
            \DB::beginTransaction();
            try{
                $isBannerCreated= $this->bannerService->createOrUpdateBanner($request->except('_token'));
                if($isBannerCreated){
                    \DB::commit();
                    return $this->responseRedirect('admin.banner.list','Banner created successfully','success',false);
                }
            }catch(\Exception $e){
                \DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong','error',true);
            }
        }
        return view('admin.banner.add-banner');
    }

    public function editBanner(Request $request, $uuid){
        $this->setPageTitle('Edit Banner');
        $bannerId= uuidtoid($uuid,'banners');
        $bannerData= $this->bannerService->findBannerById($bannerId);
        if($request->post()){
            $request->validate([
                'name' => 'required',
                "description" => 'required',
                "order" => 'required|numeric|unique:banners,order,'.$bannerData->id,
                "banner_image" => 'sometimes|file|mimes:jpg,png,gif,jpeg',
            ]);
            \DB::beginTransaction();
            try{
                $isBannerUpdated= $this->bannerService->createOrUpdateBanner($request->except('_token'),$bannerId);
                if($isBannerUpdated){
                    \DB::commit();
                    return $this->responseRedirect('admin.banner.list','Banner updated successfully','success',false);
                }
            }catch(\Exception $e){
                \DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong','error',true);
            }

        }
        return view('admin.banner.edit-banner',compact('bannerData'));
    }


    public function deleteBanner($id)  {
        $bannerId =uuidtoid($id,'banners');
        \DB::beginTransaction();
        try{
            $isBannerDeleted= $this->bannerService->deleteBanner($bannerId);
            if($isBannerDeleted){
                \DB::commit();
                return $this->responseRedirect('admin.banner.list','Banner deleted successfully','success',false);
            }
        }catch(\Exception $e){
            \DB::rollback();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseRedirectBack('Something went wrong','error',true);
        }
    }
}
