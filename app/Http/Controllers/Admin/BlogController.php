<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Services\Blog\BlogService;
use App\Http\Controllers\BaseController;

class BlogController extends BaseController
{

    protected $blogService;

    public function __construct(BlogService $blogService) {
        $this->blogService = $blogService;
    }


    public function index() {
        $this->setPageTitle('All Blogs');
        $filterConditions = [];
        $listBlogs = $this->blogService->listBlogs($filterConditions, 'id', 'asc', 15);
        return view('admin.blog.index' , compact('listBlogs'));
    }

    public function addBlog(Request $request) {
        $this->setPageTitle('Add Blog');
        if ($request->post()) {
           $request->validate([
                'title'         =>  'required|string|unique:blogs,title',
                "description"   => 'required',
                "order"         => 'required|numeric|unique:blogs,order',
                'is_featured'   => 'required',
                "blog_image"    => 'required|file|mimes:jpg,png,gif,jpeg',
            ]);
            DB::beginTransaction();
            try{
                $isBannerCreated= $this->blogService->createOrUpdateBlog($request->except('_token'));
                if($isBannerCreated){
                    DB::commit();
                    return $this->responseRedirect('admin.blog.list','Blog created successfully','success',false);
                }
            }catch(\Exception $e){
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong','error',true);
            }
        }
        return view('admin.blog.add');
    }

    public function editBlog(Request $request, $uuid){
        $this->setPageTitle('Edit Blog');
        $blogId= uuidtoid($uuid,'blogs');
        $blogData= $this->blogService->findBlogById($blogId);
        if($request->post()){
            $request->validate([
                'title'         =>  'required|string|unique:blogs,title,'. $blogId,
                "description"   => 'required',
                "order"         => 'required|numeric|unique:blogs,order,'.$blogData->id,
                'is_featured'   => 'required',
                "blog_image"    => 'sometimes|file|mimes:jpg,png,gif,jpeg',
            ]);
            DB::beginTransaction();
            try{
                $isBlogUpdated= $this->blogService->createOrUpdateBlog($request->except('_token'),$blogId);
                if($isBlogUpdated){
                    DB::commit();
                    return $this->responseRedirect('admin.blog.list','Blog updated successfully','success',false);
                }
            }catch(\Exception $e){
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong','error',true);
            }

        }
        return view('admin.blog.edit' ,compact('blogData'));
    }



}
