<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use App\Services\Brand\BrandService;
use App\Http\Controllers\BaseController;

class CourseController extends BaseController
{
    protected $brandService;
    public function __construct(BrandService $brandService)
    {
        $this->brandService= $brandService;

    }
    public function courseList()
    {
        $this->setPageTitle('All Courses');
        $filterConditions = [];
        $listCourses= Course::all();
        //dd($listCourses);
        return view('admin.courses.list', compact('listCourses'));
    }

   public function addCourse(Request $request) {
        $this->setPageTitle('Add Course');
        if ($request->post()) {
           $request->validate([
                'name' => 'required',
            ]);
            DB::beginTransaction();
            try{
                $isBrandCreated= Course::create([
                    'name'=> $request->name
                ]);
                if($isBrandCreated){
                    DB::commit();
                    return $this->responseRedirect('admin.subscription.course.list','Course created successfully','success',false);
                }
            }catch(\Exception $e){
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong','error',true);
            }
        }
        return view('admin.courses.add');
    }
    public function editCourse(Request $request, $uuid)
    {
        $this->setPageTitle('Edit Course');
        $filterConditions = [
            'is_active' => true
        ];
        $courseId = uuidtoid($uuid, 'courses');
        $courseData = Course::find($courseId);
        if ($request->post()) {
            $request->validate([
                'name' => 'required',
            ]);
            DB::beginTransaction();
            try {
                $isCourseUpdated = Course::where('id', $courseId)->update([
                    'name' => $request->name
                ]);
                if ($isCourseUpdated) {
                    DB::commit();
                    return $this->responseRedirect('admin.subscription.course.list', 'Course updated successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.courses.edit', compact('courseData'));
    }

    public function deleteBrand(Request $request, $uuid)
    {
         $brandId = uuidtoid($uuid, 'brands');
        DB::beginTransaction();
        try {
            $isBrandDeleted = $this->brandService->deleteBrand($brandId);
            if ($isBrandDeleted) {
                DB::commit();
                return $this->responseRedirect('admin.catalog.brand.list', 'Brand deleted successfully', 'success', false);
            }
        } catch (\Exception $e) {
            DB::rollback();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseRedirectBack('Something went wrong', 'error', true);
        }
    }
}
