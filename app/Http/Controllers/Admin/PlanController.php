<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Course;
use App\Models\Category;
use App\Models\PlanCategory;
use App\Models\CategoryAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanController extends BaseController
{
    public function planList()
    {
        $this->setPageTitle('Plan List');
        $data = Plan::with('courses')->get();

        return view('admin.plans.index', compact('data'));
    }

    public function addPlan(Request $request)
    {
        $this->setPageTitle('Plan Add');
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|string',
                'title' => 'required|string',
                'day_validity' => 'required|string',
                'expiry_date' => 'required',
            ]);
            // dd($request->course);

            //$request->validate([
               // 'name' => 'required|unique:plan',
                //'category' => 'required',
            //]);
            DB::beginTransaction();
            //try {
                $isAttributeCreated = Plan::create([
                    'name' => $request['name'],
                    'frequently_purchased_title' => $request['title'],
                    'expiry_date' => $request['expiry_date'],
                    'day_validity' => $request['day_validity']
                ]);
                if ($isAttributeCreated) {
                    // $courseId = Course::whereIn('id',$request->course)->value('id');
                    //dd($request->course);
                    $isAttributeWithCategory = $isAttributeCreated->courses()->attach($request->course);
                }

                if ($isAttributeCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.subscription.plan.list', 'Plan created successfully', 'success', false);
                }
            //} catch (\Exception $e) {
                //DB::rollback();
               // logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
               // return $this->responseRedirectBack('Something went wrong', 'error', true);
            //}
        } else {
            $listCourses = Course::where('status',1)->get();
            $listPlanCategories = PlanCategory::all();
            $listCourses = $listCourses->chunk(ceil($listCourses->count() / 3));
            return view('admin.plans.add', compact('listCourses','listPlanCategories'));
        }
    }

    public function editPlan(Request $request, $id)
    {
        $this->setPageTitle('Plan Edit');

        if ($request->isMethod('post')) {

            $request->validate([
                'name' => 'required|string',
                'frequently_purchased_title' => 'required|string',
                'day_validity' => 'required|string',
                'expiry_date' => 'required',
            ]);
            DB::beginTransaction();
            // try {
                $isAttribute = Plan::where('uuid', $id)->first();
                $isAttributeCreated = Plan::where('uuid', $id)->update([
                    'name' => $request['name'],
                    'frequently_purchased_title' => $request['frequently_purchased_title'],
                    'expiry_date' => $request['expiry_date'],
                    'day_validity' => $request['day_validity']
                ]);

                if ($isAttribute->id) {
                    // $breakfastOptional = [];
                    // $lunchOptional = [];
                    // $dinnerOptional = [];
                    // $snackOptional = [];
                    if(!is_null($request['course'])){
                        $listCourses = Course::whereIn('id', $request['course'])->get();
                    }
                    // if(!is_null($request['optionalbreakfast'])){
                    // $breakfastOptional = Food::whereIn('id', $request['optionalbreakfast'])->get();
                    // }
                    if(!is_null($request['course'])){
                        $isAttribute->courses()->detach();
                        $isAttribute->courses()->attach($listCourses);
                    }
                }

                if ($isAttributeCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.subscription.plan.list', 'Plan updated successfully', 'success', false);
                }
            // } catch (\Exception $e) {
            //     DB::rollback();
            //     logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            //     return $this->responseRedirectBack('Something went wrong', 'error', true);
            // }
        } else {

            $listCourses = Course::where('status',1)->get();
            $listCourses = $listCourses->chunk(ceil($listCourses->count() / 3));
            $data = Plan::where('uuid', $id)->first();
            return view('admin.plans.edit', compact('data', 'listCourses'));
        }


    }

    public function deleteCategory()
    {
    }
}
