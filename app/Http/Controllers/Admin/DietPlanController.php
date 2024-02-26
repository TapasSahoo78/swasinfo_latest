<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
//use App\Services\Role\RoleService;
//use App\Services\User\UserService;
use App\Models\Breakfast;
use App\Models\Lunch;
use App\Models\Dinner;
use App\Models\Diet;
use App\Models\Food;
use App\Models\FoodItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\UploadAble;

class DietPlanController extends BaseController
{

    protected $roleService;

    protected $userService;
    use UploadAble;

    public function __construct(
        //UserService $userService,
        //RoleService $roleService
    ) {
        //$this->userService = $userService;
        //$this->roleService = $roleService;
    }
    public function dietPlanList()
    {
        $this->setPageTitle('Diet List');
        $diets = Diet::all();
        return view('admin.diet.list', compact('diets'));
    }
    public function addDiet(Request $request)
    {

        $this->setPageTitle('Diet Plan Add');
        if ($request->isMethod('post')) {
            $request->validate([
                'gender' => 'required',
                'age_from' => 'required',
                'age_to' => 'required',
                'height_from' => 'required',
                'height_to' => 'required',
                'weight_from' => 'required',
                'weight_to' => 'required',
                'bmi_from' => 'required',
                'diet' => 'required',
                'goal' => 'required',
                'medical_condition' => 'required',
                'allergy' => 'required',
                //"food_details_image" => 'required|file|mimes:jpg,png,gif,jpeg'
            ]);
            //dd($request->all());
            //dd($request->all());
            DB::beginTransaction();
            //try {
                $DietCreated = Diet::create([
                    'gender' => $request['gender'],
                    'age_from' => $request['age_from'],
                    'age_to' => $request['age_to'],
                    'height_from' => $request['height_from'],
                    'height_to' => $request['height_to'],
                    'weight_from' => $request['weight_from'],
                    'weight_to' => $request['weight_to'],
                    'bmi_from' => $request['bmi_from'],
                    'diet' => $request['diet'],
                    'goal' => $request['goal'],
                    'medical_condition' => $request['medical_condition'],
                    'allergy' => $request['allergy']
                ]);
                if ($DietCreated) {
                    // $courseId = Course::whereIn('id',$request->course)->value('id');
                    //dd($request->course);
                    $isAttributeWithCategory = $DietCreated->breakfasts()->attach($request->breakfast);
                    $isAttributeWithCategory = $DietCreated->dietAnyBreakfasts()->attach($request->optionalbreakfast);
                    $isAttributeWithCategory = $DietCreated->lunches()->attach($request->lunch);
                    $isAttributeWithCategory = $DietCreated->dietAnyLunches()->attach($request->optionallunch);
                    $isAttributeWithCategory = $DietCreated->dinners()->attach($request->dinner);
                    $isAttributeWithCategory = $DietCreated->dietAnyDinners()->attach($request->optionaldinner);
                    $isAttributeWithCategory = $DietCreated->snacks()->attach($request->snack);
                    $isAttributeWithCategory = $DietCreated->dietAnySnacks()->attach($request->optionalsnack);
                }

                if ($DietCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.diet.plan.list', 'Diet Plan Added successfully', 'success', false);
                }
            //} //catch (\Exception $e) {
                //DB::rollback();
                //logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                //return $this->responseRedirectBack('Something went wrong', 'error', true);
            //}
        } else {
            $fromAgeRange = range(18, 40);
            $toAgeRange = range(41, 70);
            $fromWeightRange = range(40, 60);
            $toWeightRange = range(41, 70);
            $fromHeightRange = [
                1.35,
                1.36,
                1.37,
                1.38,
                1.39,
                1.40,
                1.41,
                1.42,
                1.43,
                1.44,
                1.45,
                1.46,
                1.47,
                1.48,
                1.49,
                1.50,
                1.51

            ];
            //dd($fromHeightRange);
            $toHeightRange =  [
                1.52,
                1.53,
                1.54,
                1.55,
                1.56,
                1.57,
                1.58,
                1.59,
                1.60,
                1.61,
                1.62,
                1.63,
                1.64,
                1.65,
                1.66,
                1.67,
                1.68,
                1.69,
                1.70

            ];
            $breakfast = Food::where('status', 1)->where('food_type', '=', 'breakfast')->where('is_optional', '=', 0)->get();
            $breakfast = $breakfast->chunk(ceil($breakfast->count() / 4));
            $breakfastOptional = Food::where('status', 1)->where('food_type', '=', 'breakfast')->where('is_optional', '=', 1)->get();
            $breakfastOptional = $breakfastOptional->chunk(ceil($breakfastOptional->count() / 4));
            $lunch = Food::where('status', 1)->where('food_type', '=', 'lunch')->where('is_optional', '=', 0)->get();
            $lunch = $lunch->chunk(ceil($lunch->count() / 3));
            $lunchOptional = Food::where('status', 1)->where('food_type', '=', 'lunch')->where('is_optional', '=', 1)->get();
            $lunchOptional = $lunchOptional->chunk(ceil($lunchOptional->count() / 4));
            $dinner = Food::where('status', 1)->where('food_type', '=', 'dinner')->where('is_optional', '=', 0)->get();
            $dinner = $dinner->chunk(ceil($dinner->count() / 3));
            $dinnerOptional = Food::where('status', 1)->where('food_type', '=', 'dinner')->where('is_optional', '=', 1)->get();
            $dinnerOptional = $dinnerOptional->chunk(ceil($dinnerOptional->count() / 4));
            $snack = Food::where('status', 1)->where('food_type', '=', 'snack')->where('is_optional', '=', 0)->get();
            $snack = $snack->chunk(ceil($snack->count() / 4));
            $snackOptional = Food::where('status', 1)->where('food_type', '=', 'snack')->where('is_optional', '=', 1)->get();
            $snackOptional = $snackOptional->chunk(ceil($snackOptional->count() / 4));
            return view('admin.diet.add', compact('breakfast', 'lunch', 'dinner', 'snack', 'fromAgeRange', 'toAgeRange', 'fromHeightRange', 'toHeightRange', 'fromWeightRange', 'toWeightRange','breakfastOptional','lunchOptional','dinnerOptional','snackOptional'));
        }
    }


    public function viewFoodDetails(Request $request, $uuid)
    {
        $this->setPageTitle('Food Details');
        $id = uuidtoid($uuid, 'food');
        $foodDetails = FoodItems::where('food_id', $id)->get();
        // $data['id'] = $uuid;
        //dd($data);
        return view('admin.diet.food.view', compact('foodDetails', 'uuid'));
    }

    public function createFoodDetails(Request $request, $uuid)
    {
        $this->setPageTitle('Food Details');
        if ($request->isMethod('post')) {
            $request->validate([
                'food_name' => 'required',
                //"food_details_image" => 'required|file|mimes:jpg,png,gif,jpeg'
            ]);
            DB::beginTransaction();
            try {
                $id = uuidtoid($uuid, 'food');
                $foodDetails = Food::find($id);
                if ($foodDetails) {
                    $foodDetails->foodDetails()->create([
                        'food_id' => $id,
                        'food_name' => $request['food_name']
                    ]);
                    // if (isset($request['food_image'])) {
                    // foreach ($request['food_image'] as $image) {

                    // }
                    // }
                }
                if ($foodDetails) {
                    DB::commit();
                    return $this->responseRedirect('admin.diet.food.list', 'Food Details created successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        } else {
            return view('admin.diet.food.create', compact('uuid'));
        }
    }

    public function editDiet(Request $request, $id)
    {
        $this->setPageTitle('Diet Plan Edit');
        if ($request->isMethod('post')) {
            $request->validate([
                'gender' => 'required',
                'age_from' => 'required',
                'age_to' => 'required',
                'height_from' => 'required',
                'height_to' => 'required',
                'weight_from' => 'required',
                'weight_to' => 'required',
                'bmi_from' => 'required',
                'diet' => 'required',
                'goal' => 'required',
                'medical_condition' => 'required',
                'allergy' => 'required',
                //"food_details_image" => 'required|file|mimes:jpg,png,gif,jpeg'
            ]);
            DB::beginTransaction();
            // try {
                $isAttribute = Diet::where('uuid', $id)->first();
                $isAttributeCreated = Diet::where('uuid', $id)->update([
                    'gender' => $request['gender'],
                    'age_from' => $request['age_from'],
                    'age_to' => $request['age_to'],
                    'height_from' => $request['height_from'],
                    'height_to' => $request['height_to'],
                    'weight_from' => $request['weight_from'],
                    'weight_to' => $request['weight_to'],
                    'bmi_from' => $request['bmi_from'],
                    'diet' => $request['diet'],
                    'goal' => $request['goal'],
                    'medical_condition' => $request['medical_condition'],
                    'allergy' => $request['allergy']
                ]);

                if ($isAttribute->id) {
                    // $breakfastOptional = [];
                    // $lunchOptional = [];
                    // $dinnerOptional = [];
                    // $snackOptional = [];
                    $breakfast = Food::whereIn('id', $request['breakfast'])->get();
                    if(!is_null($request['optionalbreakfast'])){
                    $breakfastOptional = Food::whereIn('id', $request['optionalbreakfast'])->get();
                    }
                    $lunch = Food::whereIn('id', $request['lunch'])->get();
                    if(!is_null($request['optionallunch'])){
                        $lunchOptional = Food::whereIn('id', $request['optionallunch'])->get();
                    }


                    $dinner = Food::whereIn('id', $request['dinner'])->get();
                    if(!is_null($request['optionaldinner'])){
                    $dinnerOptional = Food::whereIn('id', $request['optionaldinner'])->get();
                    }

                    $snack = Food::whereIn('id', $request['snack'])->get();
                    if(!is_null($request['optionalsnack'])){
                    $snackOptional = Food::whereIn('id', $request['optionalsnack'])->get();
                    }

                    $isAttribute->breakfasts()->detach();
                    $isAttribute->breakfasts()->attach($breakfast);
                    $isAttribute->dietAnyBreakfasts()->detach();
                    $isAttribute->dietAnyBreakfasts()->attach($breakfastOptional);
                    $isAttribute->lunches()->detach();
                    $isAttribute->lunches()->attach($lunch);
                    if(!is_null($request['optionallunch'])){
                    $isAttribute->dietAnyLunches()->detach();
                    $isAttribute->dietAnyLunches()->attach($lunchOptional);
                    }
                    $isAttribute->dinners()->detach();
                    $isAttribute->dinners()->attach($dinner);
                    if(!is_null($request['optionaldinner'])){
                    $isAttribute->dietAnyDinners()->detach();
                    $isAttribute->dietAnyDinners()->attach($dinnerOptional);
                    }
                    $isAttribute->snacks()->detach();
                    $isAttribute->snacks()->attach($snack);
                    if(!is_null($request['optionalsnack'])){
                    $isAttribute->dietAnySnacks()->detach();
                    $isAttribute->dietAnySnacks()->attach($snackOptional);
                    }
                }

                if ($isAttributeCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.diet.plan.list', 'Diet updated successfully', 'success', false);
                }
            // } catch (\Exception $e) {
            //     DB::rollback();
            //     logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            //     return $this->responseRedirectBack('Something went wrong', 'error', true);
            // }
        } else {
            $fromAgeRange = range(18, 40);
            $toAgeRange = range(41, 70);
            $fromWeightRange = range(40, 60);
            $toWeightRange = range(41, 70);
            $fromHeightRange = [
                1.35,
                1.36,
                1.37,
                1.38,
                1.39,
                1.40,
                1.41,
                1.42,
                1.43,
                1.44,
                1.45,
                1.46,
                1.47,
                1.48,
                1.49,
                1.50,
                1.51

            ];
            //dd($fromHeightRange);
            $toHeightRange =  [
                1.52,
                1.53,
                1.54,
                1.55,
                1.56,
                1.57,
                1.58,
                1.59,
                1.60,
                1.61,
                1.62,
                1.63,
                1.64,
                1.65,
                1.66,
                1.67,
                1.68,
                1.69,
                1.70

            ];
            $breakfast = Food::where('status', 1)->where('food_type', '=', 'breakfast')->where('is_optional', '=', 0)->get();
            $breakfast = $breakfast->chunk(ceil($breakfast->count() / 4));
            $breakfastOptional = Food::where('status', 1)->where('food_type', '=', 'breakfast')->where('is_optional', '=', 1)->get();
            $breakfastOptional = $breakfastOptional->chunk(ceil($breakfastOptional->count() / 4));
            $lunch = Food::where('status', 1)->where('food_type', '=', 'lunch')->where('is_optional', '=', 0)->get();
            $lunch = $lunch->chunk(ceil($lunch->count() / 4));
            $lunchOptional = Food::where('status', 1)->where('food_type', '=', 'lunch')->where('is_optional', '=', 1)->get();
            $lunchOptional = $lunchOptional->chunk(ceil($lunchOptional->count() / 4));
            $dinner = Food::where('status', 1)->where('food_type', '=', 'dinner')->where('is_optional', '=', 0)->get();
            $dinner = $dinner->chunk(ceil($dinner->count() / 4));
            $dinnerOptional = Food::where('status', 1)->where('food_type', '=', 'dinner')->where('is_optional', '=', 1)->get();
            $dinnerOptional = $dinnerOptional->chunk(ceil($dinnerOptional->count() / 4));
            $snack = Food::where('status', 1)->where('food_type', '=', 'snack')->where('is_optional', '=', 0)->get();
            $snack = $snack->chunk(ceil($snack->count() / 3));
            $snackOptional = Food::where('status', 1)->where('food_type', '=', 'snack')->where('is_optional', '=', 1)->get();
            $snackOptional = $snackOptional->chunk(ceil($snackOptional->count() / 4));
            $data = Diet::where('uuid', $id)->first();
            return view('admin.diet.edit', compact('data', 'breakfast','breakfastOptional', 'lunch','lunchOptional','dinnerOptional', 'dinner', 'snack','snackOptional', 'fromAgeRange', 'toAgeRange', 'fromHeightRange', 'toHeightRange', 'fromWeightRange', 'toWeightRange'));
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
                'is_optional' => 'required',
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
                'food_type_option' => $request->food_type_option,
                'is_optional' => $request->is_optional,
                'quantity' => $request->quantity,
                'food_suffix' => $request->food_suffix,
                'food_make' => $request->food_make,
                'breakfast_callories' => $request->breakfast_callories,
                'lunch_callories' => $request->lunch_callories,
                'dinner_callories' => $request->dinner_callories,
                'snack_callories' => $request->snack_callories,
                'carbs' => $request->carbs,
                'proteins' => $request->proteins,
                'fats' => $request->fats,
                'fibre' => $request->fibre,
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
                'is_optional' => 'required',
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
                    'is_optional' => $request->is_optional,
                    'breakfast_callories' => $request->breakfast_callories,
                    'lunch_callories' => $request->lunch_callories,
                    'dinner_callories' => $request->dinner_callories,
                    'snack_callories' => $request->snack_callories,
                    'carbs' => $request->carbs,
                    'proteins' => $request->proteins,
                    'fats' => $request->fats,
                    'fibre' => $request->fibre,
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
        $foods = Food::orderBy('id', 'DESC')->get();
        return view('admin.diet.food.list', compact('foods'));
    }
}
