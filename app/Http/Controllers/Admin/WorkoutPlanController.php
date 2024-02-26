<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
//use App\Services\Role\RoleService;
//use App\Services\User\UserService;
use App\Models\Breakfast;
use App\Models\Lunch;
use App\Models\Dinner;
use App\Models\Diet;
use App\Models\Workout;
use App\Models\WorkoutDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\UploadAble;

class WorkoutPlanController extends BaseController
{

    protected $roleService;

    protected $userService;
    use UploadAble;

    public function __construct(
        //UserService $userService,
        //RoleService $roleService
    )
    {
        //$this->userService = $userService;
        //$this->roleService = $roleService;
    }
    public function WorkoutPlanList()
    {
        $this->setPageTitle('Workout List');
        $workouts = Workout::orderBy('id', 'DESC')->get();
        return view('admin.workout.list', compact('workouts'));
    }
    public function addWorkout(Request $request)
    {
      
        $this->setPageTitle('Workout Add');
        if ($request->post()) {
            //dd($request->all());
            $request->validate([
                'name' => 'required',
                'workout_type' => 'required',
                'workout_sub_type' => 'required',
                "workout_image" => 'required|file|mimes:jpg,png,gif,jpeg'
            ]);
            DB::beginTransaction();
            //try {
            $isBrandCreated = Workout::create([
                'name' => $request->name,
                'workout_type' => $request->workout_type,
                'workout_sub_type' => $request->workout_sub_type
            ]);
            if ($isBrandCreated) {
                if ($isBrandCreated->workout_type == 'yoga') {
                    $type = 'yoga';
                } elseif ($isBrandCreated->workout_type == 'meditation') {
                    $type = 'meditation';
                } elseif ($isBrandCreated->workout_type == 'exercises') {
                    $type = 'exercises';
                } else {
                    $type = '';
                }
                // if (isset($request['food_image'])) {
                // foreach ($request['food_image'] as $image) {
                $fileName = uniqid() . '.' . $request['workout_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($request['workout_image'], config('constants.SITE_WORKOUT_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                // dd($fileName);
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $isBrandCreated->workout()->create([
                        'workout_id' => $isBrandCreated->id,
                        'mediaable_type' => get_class($isBrandCreated),
                        'mediaable_id' => $isBrandCreated->id,
                        'media_type' =>  $type,
                        'file' => $fileName
                    ]);
                }
                // }
                // }
            }
            if ($isBrandCreated) {
                DB::commit();
                return $this->responseRedirect('admin.workout.list', 'Workout created successfully', 'success', false);
            }
            // } catch (\Exception $e) {
            // DB::rollback();
            //logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            //return $this->responseRedirectBack('Something went wrong', 'error', true);
            //}
        } else {

            return view('admin.workout.add');
        }
    }

    public function editWorkout(Request $request, $id)
    {
        $this->setPageTitle('Workout Edit');
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required',
                'workout_type' => 'required',
                'workout_sub_type' => 'required',
               // "workout_image" => 'required|file|mimes:jpg,png,gif,jpeg'
            ]);
            DB::beginTransaction();
            try {
                $isAttribute = Workout::where('uuid', $id)->first();
                $isAttributeCreated = Workout::where('uuid', $id)->update([
                    'name' => $request->name,
                'workout_type' => $request->workout_type,
                'workout_sub_type' => $request->workout_sub_type
                ]);

                if ($isAttributeCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.workout.list', 'Workout updated successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        } else {

            $data = Workout::where('uuid', $id)->first();
            return view('admin.workout.edit', compact('data'));
        }
    }


    public function viewWorkoutDetails(Request $request, $uuid)
    {
        $this->setPageTitle('Workout Details');
        $id = uuidtoid($uuid, 'workouts');
        $workoutDetails = WorkoutDetails::where('workout_id', $id)->get();
        // $data['id'] = $uuid;
        //dd($data);
        return view('admin.workout.view', compact('workoutDetails', 'uuid'));
    }

    public function createWorkoutDetails(Request $request, $uuid)
    {
        $this->setPageTitle('Workout Details');
        if ($request->isMethod('post')) {
            $request->validate([
                'workout_name' => 'required',
                'sets' => 'required|numeric',
                'reps' => 'required|numeric',
                "workout_details_image" => 'required|file|mimes:jpg,png,gif,jpeg'
            ]);
            DB::beginTransaction();
            try {
                $id = uuidtoid($uuid, 'workouts');
                $workoutDetails = Workout::find($id);
                if ($workoutDetails) {
                    $workoutDetails->workoutDetails()->create([
                        'workout_id' => $id,
                        'workout_name' => $request['workout_name'],
                        'sets' => $request['sets'],
                        'reps' => $request['reps'],
                        'calorie' => $request['calorie']
                    ]);
                    // if (isset($request['food_image'])) {
                    // foreach ($request['food_image'] as $image) {
                    $fileName = uniqid() . '.' . $request['workout_details_image']->getClientOriginalExtension();
                    $isFileUploaded = $this->uploadOne($request['workout_details_image'], config('constants.SITE_WORKOUT_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                    // dd($fileName);
                    if ($isFileUploaded) {
                        $isFileRelatedMediaCreated = $workoutDetails->workoutDetailsImage()->create([
                            'workout_id' => $workoutDetails->id,
                            'workoutable_type' => get_class($workoutDetails),
                            'workoutable_id' => $workoutDetails->id,
                            'workout_type' =>  '',
                            'file' => $fileName
                        ]);
                    }
                    // }
                    // }
                }
                if ($workoutDetails) {
                    DB::commit();
                    return $this->responseRedirect('admin.workout.list', 'Workout Details created successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        } else {
            return view('admin.workout.create', compact('uuid'));
        }
    }
    public function dietBreakfastList()
    {
        $this->setPageTitle('Breakfast Diet');
        $breakfasts = Breakfast::all();
        return view('admin.diet.breakfast.list', compact('breakfasts'));
    }

    public function addBreakfast(Request $request)
    {
        $this->setPageTitle('Add Diet Breakfast');
        if ($request->post()) {
            $request->validate([
                'name' => 'required',
            ]);
            DB::beginTransaction();
            try {
                $isBrandCreated = Breakfast::create([
                    'name' => $request->name
                ]);
                if ($isBrandCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.diet.breakfast.list', 'Breakfast created successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.diet.breakfast.add');
    }


    public function addFood(Request $request)
    {
        $this->setPageTitle('Add Diet Food');
        if ($request->post()) {
            //dd($request->all());
            $request->validate([
                'name' => 'required',
                'food_type' => 'required',
                "food_image" => 'required|file|mimes:jpg,png,gif,jpeg',
                'breakfast_callories' => 'required_if:food_type,breakfast|nullable|numeric',
                'lunch_callories' => 'required_if:food_type,lunch|nullable|numeric',
                'dinner_callories' => 'required_if:food_type,dinner|nullable|numeric',
                'snack_callories' => 'required_if:food_type,snack|nullable|numeric'
            ]);
            DB::beginTransaction();
            //try {
            $isBrandCreated = Food::create([
                'name' => $request->name,
                'food_type' => $request->food_type,
                'breakfast_callories' => $request->breakfast_callories,
                'lunch_callories' => $request->lunch_callories,
                'dinner_callories' => $request->dinner_callories,
                'snack_callories' => $request->snack_callories,
            ]);
            if ($isBrandCreated) {
                if ($isBrandCreated->food_type == 'breakfast') {
                    $type = 'breakfast';
                } elseif ($isBrandCreated->food_type == 'lunch') {
                    $type = 'lunch';
                } elseif ($isBrandCreated->food_type == 'dinner') {
                    $type = 'dinner';
                } elseif ($isBrandCreated->food_type == 'snack') {
                    $type = 'snack';
                } else {
                    $type = '';
                }
                // if (isset($request['food_image'])) {
                // foreach ($request['food_image'] as $image) {
                $fileName = uniqid() . '.' . $request['food_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($request['food_image'], config('constants.SITE_FOOD_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                // dd($fileName);
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $isBrandCreated->food()->create([
                        'food_id' => $isBrandCreated->id,
                        'mediaable_type' => get_class($isBrandCreated),
                        'mediaable_id' => $isBrandCreated->id,
                        'media_type' =>  $type,
                        'file' => $fileName
                    ]);
                }
                // }
                // }
            }
            if ($isBrandCreated) {
                DB::commit();
                return $this->responseRedirect('admin.diet.food.list', 'Food created successfully', 'success', false);
            }
            // } catch (\Exception $e) {
            // DB::rollback();
            //logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            //return $this->responseRedirectBack('Something went wrong', 'error', true);
            //}
        }
        return view('admin.diet.food.add');
    }
    public function editFood(Request $request, $uuid)
    {
        $this->setPageTitle('Edit Food');
        $filterConditions = [
            'is_active' => true
        ];
        $courseId = uuidtoid($uuid, 'food');
        $courseData = Food::find($courseId);
        if ($request->post()) {
            $request->validate([
                'name' => 'required',
                'food_type' => 'required',
                "food_image" => 'required|sometimes|file|mimes:jpg,png,gif,jpeg',
                'breakfast_callories' => 'required_if:food_type,breakfast|nullable|numeric',
                'lunch_callories' => 'required_if:food_type,lunch|nullable|numeric',
                'dinner_callories' => 'required_if:food_type,dinner|nullable|numeric',
                'snack_callories' => 'required_if:food_type,snack|nullable|numeric'
            ]);
            DB::beginTransaction();
            try {
                $isCourseUpdated = Food::where('id', $courseId)->update([
                    'name' => $request->name,
                    'food_type' => $request->food_type,
                    'breakfast_callories' => $request->breakfast_callories,
                    'lunch_callories' => $request->lunch_callories,
                    'dinner_callories' => $request->dinner_callories,
                    'snack_callories' => $request->snack_callories,
                ]);
                if ($isCourseUpdated) {
                    DB::commit();
                    return $this->responseRedirect('admin.diet.food.list', 'Food updated successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.diet.food.edit', compact('courseData'));
    }

    public function dietLunchList()
    {
        $this->setPageTitle('Breakfast Diet');
        $lunches = Lunch::all();
        return view('admin.diet.lunch.list', compact('lunches'));
    }

    public function dietDinnerList()
    {
        $this->setPageTitle('Dinner Diet');
        $dinners = Dinner::all();
        return view('admin.diet.dinner.list', compact('dinners'));
    }

    public function dietFoodList()
    {
        $this->setPageTitle('Food Diet');
        $foods = Food::all();
        return view('admin.diet.food.list', compact('foods'));
    }
}
