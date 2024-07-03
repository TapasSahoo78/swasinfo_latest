<?php

namespace App\Http\Controllers\Api\Customer;

use Auth;

use App\Models\Faq;
use App\Models\Diet;
use App\Models\Page;
use App\Models\Plan;
use App\Models\User;
use App\Models\Reward;
use App\Models\Workout;
use App\Models\FitnessGoal;
use App\Models\TrainerDetail;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Services\User\UserService;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\TrainerCustomerRequest;

use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Models\UserPhysicallyActiveConditions;
use App\Http\Resources\Api\Agent\UserApiCollection;
use App\Http\Resources\Api\Customer\DietApiCollection;
use App\Http\Resources\Api\Customer\UpdateDietApiCollection;
use App\Http\Resources\Api\Customer\FaqDetailApiCollection;
use App\Http\Resources\Api\Customer\UserDetailApiCollection;
use App\Http\Resources\Api\Customer\WorkoutPlanApiCollection;
use App\Http\Resources\Api\Customer\RewardDetailApiCollection;
use App\Http\Resources\Api\Customer\SubscriptionApiCollection;
use App\Http\Resources\Api\Customer\UserHealthDetailApiCollection;
use App\Http\Resources\Api\Customer\FitnessGoalDetailApiCollection;
use App\Http\Resources\Api\Customer\UserTrainerDetailApiCollection;
use App\Http\Resources\Api\Customer\UserCartDetailApiCollection;
use App\Http\Resources\Api\Customer\PrivacyPolicyDetailApiCollection;
use App\Http\Resources\Api\Customer\UserProfileImageDetailApiCollection;
use App\Http\Resources\Api\Customer\PhysicallyConditionDetailApiCollection;
use App\Models\Notification;
use App\Models\PaymentDetail;
use App\Models\UserFoodItemDetail;
use App\Models\Food;
use Carbon\Carbon;
use App\Models\UserTrack;
use Illuminate\Support\Facades\Mail;
use App\Models\VersionControl;
use App\Models\Log;
use App\Models\UserFootitem;
use App\Models\UserWorkoutItem;
use App\Http\Resources\Api\Customer\WorkoutUpdatePlanApiCollection;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Pincode;
use App\Models\State;
use App\Models\District;
use App\Models\UserAddress;
use App\Models\ShippingMethod;
use App\Models\Favorite;
use App\Models\Order;
use App\Models\ProfileOtherInformation;
use App\Models\Coupon;
use App\Models\Rating;
use App\Services\Payment\PhonePeService as PaymentPhonePeService;
use Exception;
use Razorpay\Api\Api;

class UserApiControllers extends BaseController
{
    //

    protected $userService;
    protected $phonePeService;

    public function __construct(UserService $userService, PaymentPhonePeService $phonePeService)
    {
        $this->userService = $userService;
        $this->phonePeService = $phonePeService;
    }
    /**
     * @OA\post(
     *      path="api/customers/login-send-otp",
     *      tags={"customersLogin"},
     *      operationId="customersLogin",
     *      summary="customers send otp",
     *      description="Customer Send otp email and mobile",
     *      @OA\Parameter(
     *          name="mobile_number",
     *          description="Mobile Number",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="is_signup",
     *          description="this request is for singup true or false",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="boolean"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="email",
     *          description="Email",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function loginSendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'is_signup' => 'required|boolean',
            'password' => 'required|string|min:6',
            'mobile_number' => Rule::requiredIf($request->email == "") . '|nullable|string|min:10',
            'email' => Rule::requiredIf($request->mobile == "") . '|nullable|string|email',
        ]);

        if ($request->is_signup) {
            $validator = Validator::make($request->all(), [
                'is_signup' => 'required|boolean',
                'otp' => 'required|min:6',
                'mobile_number' => Rule::requiredIf($request->email == "") . '|nullable|unique:users,mobile_number|string|min:10',
                'email' => Rule::requiredIf($request->mobile == "") . '|nullable|unique:users,email|string|email',
            ]);
        }
        if ($validator->fails()) {
            $error = ['error' => $validator->errors()->all()];
            return $this->responseJson(false, 200, $validator->errors()->all(), "");
        }
        if ($request->is_signup == 0) {
            if ($request->email) {
                $userExist = $this->userService->findUserByEmail($request->email);
            } else if ($request->mobile_number) {
                $userExist = $this->userService->findUserByMobile($request->mobile_number);
            }
        } else {
            // echo "in";
            $userExist = $this->userService->createOrUpdateCustomer($request->except('_token'));
            $userData = new UserApiCollection($userExist);
            $message = "User    ged in successfully";
            return $this->responseJson(true, 200, $message, $userData);
        }
        // return $userExist;
        if ($userExist) {
            $userData = ['otp' => genrateOtp(), 'user_details' => $userExist];
            $message = "User Logged in successfully";
            return $this->responseJson(true, 200, $message, $userData);
        } else {
            $message = "Unauthorised";
            return $this->responseJson(false, 401, $message, "");
            // return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function getGuidanceList()
    {
        $toReturn = [
            'guidances' => getGuidance(),

        ];
        return $this->responseJson(true, 200, "", $toReturn);
    }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'sometimes|string|min:6',
            'username' => 'required|nullable|string',
            'is_email' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            $error = ['error' => $validator->errors()->all()];
            return $this->responseJson(false, 200, $validator->errors()->first(), "");
        }
        $otp = genrateOtp(4);
        if ($request->is_email) {
            $request->merge(['email' => $request->username]);
            $userFound = $this->userService->findUserByEmail($request->username);
            $data = [
                'otp' => $otp,
            ];
            $user = $request->username;
        } else {
            $request->merge(['mobile_number' => $request->username]);
            $userFound = $this->userService->findUserByMobile($request->username);
        }

        if (!empty($userFound) && $userFound->otp_verify == "1") {
            return $this->responseJson(false, 200, "You are already Registered", "");
        }


        $request->merge(['verification_code' => $otp]);
        // $request->merge(['password' => $request->password]);
        $request->merge(['password' => "password"]);

        $userExist = $this->userService->createOrUpdateCustomer($request->except('_token'), $userFound?->id ?? NULL);

        if ($userExist) {
            $userData = ['otp' => $otp];
            $message = "OTP send successfully !!";
            return $this->responseJson(true, 200, $message, $userData);
        } else {
            $message = "user not found";
            return $this->responseJson(false, 401, $message, "");
        }
    }

    public function flogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|min:6',
        ]);
        if ($request->page == "signup") {
            $userFound = $this->userService->findUserByEmail($request->username);
            if (!empty($userFound)) {
                return $this->responseJson(false, 200, "You are already Registered", "");
            }
        }
        if ($request->facebook_id) {
            $userFound = $this->userService->findUserByFacebook($request->facebook_id);
        } else if ($request->googleplus_id) {
            $userFound = $this->userService->findUserByGoogle($request->googleplus_id);
        }
        if (empty($userFound)) {
            if ($validator->fails()) {
                $error = ['error' => $validator->errors()->all()];
                return $this->responseJson(false, 200, $validator->errors()->first(), "");
            }
            $request->merge(['email' => $request->username]);

            $userFound = $this->userService->createOrUpdatefaceCustomer($request->except('_token'), $userFound?->id ?? NULL);
            $id = $userFound->id;
            $userFound->access_token = $userFound->createToken('LaravelAuthApp')->accessToken;
        } else {
            $request->merge(['email' => $request->username]);
            $userFound = $this->userService->findUserByEmail($request->username);
            $id = $userFound->id;
            $userFound->access_token = $userFound->createToken('LaravelAuthApp')->accessToken;
        }

        UserTrack::firstOrCreate(
            ['imiei' => $request->imei_no],
            ['user_id' => $id]
        );

        //return $userFound;


        $userData = [
            'otp_matched' => true,
            'user_details' => $userFound
        ];

        $message = "Login Sucessfully!";
        return $this->responseJson(true, 200, $message, $userData);
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|numeric|digits:4',
            'username' => 'required|nullable|string',
            'is_email' => 'required|boolean'
        ]);
        if ($validator->fails()) {
            $error = ['error' => $validator->errors()->all()];
            return $this->responseJson(false, 200, $validator->errors()->first(), "");
        }
        if ($request->is_email) {
            $request->merge(['email' => $request->username]);
            $userFound = $this->userService->findUserByEmail($request->username);
        } else {
            $request->merge(['mobile_number' => $request->username]);
            $userFound = $this->userService->findUserByMobile($request->username);
        }
        if (is_null($userFound)) {
            return $this->responseJson(false, 200, "User Not Found", "");
        }


        $otpupdate = User::where('id', $userFound->id)->update([
            'fcm_token' => $request->fcm_token,
            'otp_verify' => 1
        ]);

        UserTrack::firstOrCreate(
            ['imiei' => $request->imei_no],
            ['user_id' => $userFound->id]
        );

        //return $userFound;
        if ($request->otp != $userFound->verification_code) {
            return $this->responseJson(false, 200, "OTP not matched", "");
        } else {
            $userFound->access_token = $userFound->createToken('LaravelAuthApp')->accessToken;
            $userData = [
                'otp_matched' => true,
                'user_details' => $userFound
            ];

            $message = "OTP  Validated !!";
            return $this->responseJson(true, 200, $message, $userData);
        }
    }

    public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            /* 'otp'=>'required|numeric|digits:4', */
            'username' => 'required|nullable|string',
            'is_email' => 'required|boolean'
        ]);
        if ($validator->fails()) {
            $error = ['error' => $validator->errors()->all()];
            return $this->responseJson(false, 200, $validator->errors()->first(), "");
        }
        if ($request->is_email) {
            $request->merge(['email' => $request->username]);
            $userFound = $this->userService->findUserByEmail($request->username);
        } else {
            $request->merge(['mobile_number' => $request->username]);
            $userFound = $this->userService->findUserByMobile($request->username);
        }
        if (is_null($userFound)) {
            return $this->responseJson(false, 200, "User Not Found", "");
        }

        $otp = genrateOtp(4);
        $otpupdate = User::where('id', $userFound->id)->update([
            'verification_code' => $otp
        ]);
        if ($otpupdate) {
            $userData = [
                'otp' => $otp
            ];
            $message = "OTP  Sent Successfully !!";
            return $this->responseJson(true, 200, $message, $userData);
        } else {
            return $this->responseJson(false, 200, "Something Went Wrong", "");
        }
        //return $userFound;
        /* if($request->otp!=$userFound->verification_code)
        {
            return $this->responseJson(false,200,"OTP not matched","");
        }else{
            $userFound->access_token = $userFound->createToken('LaravelAuthApp')->accessToken;
            $userData=['otp_matched'=>true,
            'user_details'=>$userFound
        ];
            $message = "OTP  Validated !!";
            return $this->responseJson(true, 200,$message,$userData);
        } */
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'password' => 'required|string|min:6',
            'username' => 'required|nullable|string',
            'is_email' => 'required|boolean'
        ]);
        $otp = genrateOtp(4);
        if ($validator->fails()) {
            $error = ['error' => $validator->errors()->all()];
            return $this->responseJson(false, 200, $validator->errors()->first(), "");
        }
        if ($request->is_email) {
            $loginParam = ['email' => $request->username];
            $data = [
                'otp' => $otp,
            ];
            $user = $request->username;
        } else {
            $loginParam = ['mobile_number' => $request->username];
        }
        // $loginParam['password'] = $request->password;
        if ($request->is_email) {
            $request->merge(['email' => $request->username]);
            $userFound = $this->userService->findUserByEmail($request->username);
        } else {
            $request->merge(['mobile_number' => $request->username]);
            $userFound = $this->userService->findUserByMobile($request->username);
        }
        if (is_null($userFound)) {
            return $this->responseJson(false, 200, "User Not Found", "");
        }
        $user = User::where('email', $request->username)
            ->orWhere('mobile_number', $request->username)
            ->first();
        // if (auth()->attempt($loginParam)) {
        if ($user) {
            $otp = genrateOtp(4);
            // $user = auth()->user();
            auth()->login($user);
            $userStatus = $user->is_active;

            if ($userStatus == 1) {
                $otpupdate = $user->update([
                    'verification_code' => $otp
                ]);
                if ($otpupdate) {
                    $userData = [
                        'otp' => $otp
                    ];
                    $message = "OTP  Sent Successfully !!";
                    return $this->responseJson(true, 200, $message, $userData);
                }
            } else {
                return $this->responseJson(false, 200, "User In Active", "");
            }
        } else {
            return $this->responseJson(false, 200, "Wrong login details", "");
        }
    }

    public function loginVerify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|numeric|digits:4',
            'username' => 'required|nullable|string',
            'is_email' => 'required|boolean'
        ]);
        if ($validator->fails()) {
            $error = ['error' => $validator->errors()->all()];
            return $this->responseJson(false, 200, $validator->errors()->first(), "");
        }
        if ($request->is_email) {
            $request->merge(['email' => $request->username]);
            $userFound = $this->userService->findUserByEmail($request->username);
        } else {
            $request->merge(['mobile_number' => $request->username]);
            $userFound = $this->userService->findUserByMobile($request->username);
        }
        if (is_null($userFound)) {
            return $this->responseJson(false, 200, "User Not Found", "");
        }



        $otpupdate = User::where('id', $userFound->id)->update([
            'fcm_token' => $request->fcm_token
        ]);


        UserTrack::firstOrCreate(
            ['imiei' => $request->imei_no],
            ['user_id' => $userFound->id]
        );
        //return $userFound;
        if ($request->otp != $userFound->verification_code) {
            return $this->responseJson(false, 200, "OTP not matched", "");
        } else {
            $userFound->access_token = $userFound->createToken('LaravelAuthApp')->accessToken;
            $userData = [
                'otp_matched' => true,
                'user_details' => $userFound
            ];

            $requestparam = (object)array(
                'body' => 'Your Otp Verify Sucessfully',
                'title' => 'Swasthfit'
            );
            //$fcm =  auth()->user()->fcm_token;
            //$this->sendNotificationtest($requestparam, $request->fcm_token);
            $message = "LoggedIn Successfully !!";
            return $this->responseJson(true, 200, $message, $userData);
        }
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            /*  'otp'=>'required|numeric|digits:4', */
            'username' => 'required|nullable|string',
            'is_email' => 'required|boolean'
        ]);
        if ($validator->fails()) {
            $error = ['error' => $validator->errors()->all()];
            return $this->responseJson(false, 200, $validator->errors()->first(), "");
        }
        if ($request->is_email) {
            $request->merge(['email' => $request->username]);
            $userFound = $this->userService->findUserByEmail($request->username);
        } else {
            $request->merge(['mobile_number' => $request->username]);
            $userFound = $this->userService->findUserByMobile($request->username);
        }
        if (is_null($userFound)) {
            return $this->responseJson(false, 200, "User Not Found", "");
        }
        //return $userFound;
        $otp = genrateOtp(4);
        $otpupdate = User::where('id', $userFound->id)->update([
            'verification_code' => $otp
        ]);
        if ($otpupdate) {
            $userData = [
                'otp' => $otp
            ];
            $message = "OTP  Sent Successfully !!";
            return $this->responseJson(true, 200, $message, $userData);
        } else {
            return $this->responseJson(false, 200, "Something Went Wrong", "");
        }
    }

    public function createPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'new_password' => 'required|min:8|string',
            'confirm_password' => 'required|same:new_password',
            'username'              => 'required|string',
            'is_email'              => 'required|boolean'
        ]);
        if ($validator->fails()) {
            $error = ['error' => $validator->errors()->all()];
            return $this->responseJson(false, 200, $validator->errors()->first(), "");
        }
        if ($request->is_email) {
            $request->merge(['email' => $request->username]);
            $userFound = $this->userService->findUserByEmail($request->username);
        } else {
            $request->merge(['mobile_number' => $request->username]);
            $userFound = $this->userService->findUserByMobile($request->username);
        }
        if (is_null($userFound)) {
            return $this->responseJson(false, 200, "User Not Found", "");
        }

        /* $otp = genrateOtp(4); */
        $otpupdate =  $this->userService->saveUserProfileDetails([
            'password' => $request->new_password,
            'is_password_changed' => 1,
        ], $userFound->id);

        if ($otpupdate) {
            /* $userData=[
        'otp'=>$otp
    ]; */
            $message = "Password  Created Successfully !!";
            return $this->responseJson(true, 200, $message, "");
        } else {
            return $this->responseJson(false, 200, "Something Went Wrong", "");
        }
    }
    public function createProfile(Request $request)
    {
        $userId = auth()->user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string',
            'gender' => 'nullable|string',
            'age' => 'nullable|string',
            'height' => 'nullable|string',
            'weight' => 'nullable|string',
            'target_weight' => 'nullable|string',
            'guidance' => 'nullable|string',
            'bmi' => 'nullable|string',
            'do_you_have_any_allergies' => 'nullable|string',
            'do_you_have_any_medical_condition' => 'nullable|string',
            'diet_type' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            $error = ['error' => $validator->errors()->all()];
            return $this->responseJson(false, 200, $validator->errors()->first(), "");
        }
        $guidance = is_array($request->guidance) ? $request->guidance : explode(",", $request->guidance);
        $request->merge(['guidance' => $guidance]);
        //\DB::beginTransaction();
        /* try{ */
        $userData =  $this->userService->updateOrCreateProfile($request->all(), $userId);
        if ($userData) {
            return $this->responseJson(true, 200, "", new UserDetailApiCollection($userData));
        }


        /* }catch(\Exception $e){
                \DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseJson(false,200,"Something went wrong","");
            } */
    }

    public function updateProfile(Request $request)
    {
        $userId = auth()->user()->id;
        //  return $request->all();
        // if ($request->post()) {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string',
            'gender' => 'nullable|string',
            'age' => 'nullable|string',
            'height' => 'nullable|string',
            'weight' => 'nullable|string',
            'target_weight' => 'nullable|string',
            'guidance' => 'nullable|string',
            'bmi' => 'required|nullable|string',
            'do_you_have_any_allergies' => 'nullable|string',
            'do_you_have_any_medical_condition' => 'nullable|string',
            'diet_type' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            $error = ['error' => $validator->errors()->all()];
            return $this->responseJson(false, 200, $validator->errors()->first(), "");
        }
        $guidance = is_array($request->guidance) ? $request->guidance : explode(",", $request->guidance);
        $request->merge(['guidance' => $guidance]);
        //\DB::beginTransaction();
        /* try{ */
        $userData =  $this->userService->updateOrCreateProfile($request->all(), $userId);
        if ($userData) {
            return $this->responseJson(true, 200, "Profile Updated Successfully !!", new UserDetailApiCollection($userData));
        }
        /* }catch(\Exception $e){
                \DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseJson(false,200,"Something went wrong","");
            } */
    }
    /**
     * @OA\Get(
     *      path="/agent/user",
     *      tags={"getAgentDetail"},
     *      operationId="getAgentDetail",
     *      summary="Get Agent information",
     *      description="Get Agent information",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function userDetails(Request $request)
    {
        $user = auth()->user()->id;

        $users = User::where('id', $user)->with('userItemFoodDetails')->first();
        $fids[] = "";

        foreach ($users->userItemFoodDetails as $foodids) {
            $today = Carbon::today();
            if ($foodids->updated_at->isSameDay($today)) {
                $fids[] = $foodids->food_ids;
            } else {
                $fids[] = "";
            }
        }

        if (isset($fids['1'])) {

            $fooditems = explode(',', $fids['1']);

            $calories = [];
            $food = Food::whereIn('id', $fooditems)->get();

            foreach ($food as $foods) {

                if ($foods->food_type == "breakfast") {
                    $calories[] = $foods->breakfast_callories;
                }
                if ($foods->food_type == "lunch") {
                    $calories[] = $foods->lunch_callories;
                }
                if ($foods->food_type == "dinner") {
                    $calories[] = $foods->dinner_callories;
                }

                if ($foods->food_type == "snack") {
                    $calories[] = $foods->snack_callories;
                }
            }

            $totalcatelory = array_sum($calories);

            $users['total_calorie'] = $totalcatelory;
        } else {
            $users['total_calorie'] = 0;
        }

        // $userItem = UserFoodItemDetail::where('user_id')->first();




        $message = "User Details Fetched Successfully !!";
        $userData = new UserDetailApiCollection($users);
        return $this->responseJson(true, 200, $message, $userData);
    }
    public function userWorkoutDetails(Request $request)
    {
        $user = auth()->user();
        $message = "User Workout Details Fetched Successfully !!";
        $userData = new UserHealthDetailApiCollection($user);
        return $this->responseJson(true, 200, $message, $userData);
    }
    public function userHealthWorkoutSave(Request $request)
    {

        $userId = auth()->user()->id;
        $validator = Validator::make($request->all(), [
            'sleep_schedule' => 'sometimes|nullable',
            'total_sleep_hours' => 'sometimes|nullable',
            'is_followed_diet_plan' => 'sometimes|nullable',
            'diet_plan_last_time' => 'sometimes|nullable',
            'is_followed_exercise_plan' => 'sometimes|nullable',
            'exercise_plan_last_time' => 'sometimes|nullable',

            'any_physical_movement' => 'sometimes|nullable',
            'physical_movement_last_time' => 'sometimes|nullable',
            'water_intake_last_time' => 'sometimes|nullable',

            'do_you_get_tired_during_the_day' => 'sometimes|nullable',
            'feel_drizzing_when_you_wakeup' => 'sometimes|nullable',

            'how_much_do_you_smoke_in_a_day' => 'sometimes|nullable',
            'how_often_do_you_drink' => 'sometimes|nullable',
            'what_do_you_usually_drink' => 'sometimes|nullable',

            'do_you_take_any_medication' => 'sometimes|nullable',
            'have_you_been_recently_hospitalized' => 'sometimes|nullable',
            'do_you_suffer_from_asthma' => 'sometimes|nullable',
            'do_you_have_high_uric_acid' => 'sometimes|nullable',
            'do_you_have_diabities' => 'sometimes|nullable',
            'do_you_have_high_cholesterol' => 'sometimes|nullable',
            'do_you_suffer_from_high_or_low_blood_pressure' => 'sometimes|nullable'
        ]);

        if ($validator->fails()) {
            $error = ['error' => $validator->errors()->all()];
            return $this->responseJson(false, 200, $validator->errors()->first(), "");
        }



        $userStgPersonalDetails = $this->userService->updateOrCreateHealthWorkout($request->all(), $userId);
        //return $userStgPersonalDetails;
        if ($userStgPersonalDetails) {
            DB::commit();
            return $this->responseJson(true, 200, "", new UserHealthDetailApiCollection($userStgPersonalDetails));
        }
    }
    public function userAdvanceUpdateDetails(Request $request)
    {
        //return $request->all();
        $userId = auth()->user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'gender' => 'nullable|string',
            'age' => 'nullable|string',
            'height' => 'nullable|string',
            'weight' => 'nullable|string',
            'target_weight' => 'nullable|string',
            'guidance' => 'nullable|string',
            'bmi' => 'required|nullable|string',
            'do_you_have_any_allergies' => 'nullable|string',
            'do_you_have_any_medical_condition' => 'nullable|string',
            'diet_type' => 'nullable|string',
            'fitness_id' => 'nullable|numeric',
            'user_physically_conditions_id' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            $error = ['error' => $validator->errors()->all()];
            return $this->responseJson(false, 200, $validator->errors()->first(), "");
        }
        $userStgPersonalDetails = $this->userService->updateOrCreateAdvanceUserDetails($request->all(), $userId);
        $requestparam = (object)array(
            'body' => 'Complete Questionnaire to get your personalised plan.',
            'title' => 'Swasthfit'
        );
        $fcm = $request->fcm_token;
        $this->sendNotificationtest($requestparam, $fcm);
        //return $userStgPersonalDetails;
        if ($userStgPersonalDetails) {
            DB::commit();

            return $this->responseJson(true, 200, "", new UserDetailApiCollection($userStgPersonalDetails));
        }
    }

    public function userFoodItemSave(Request $request)
    {
        //return $request->all();
        $userId = auth()->user()->id;
        // $validator = Validator::make($request->all(), [
        //     'food_id' => 'required|numeric',
        //     'food_item_id' => 'required|numeric',
        //     'type' => 'required|string',
        // ]);
        // if ($validator->fails()) {
        //     $error = ['error' => $validator->errors()->all()];
        //     return $this->responseJson(false, 200, $validator->errors()->first(), "");
        // }

        $userStgPersonalDetails = $this->userService->updateOrCreateUserFoodItems($request->all(), $userId);
        //return $userStgPersonalDetails;
        if ($userStgPersonalDetails) {
            DB::commit();
            return $this->responseJson(true, 200, "Food Added Successfully !!", "");
        }
    }

    public function rewardList(Request $request)
    {
        /* $filterConditionsUsers = [
            'mfi_id' => auth()->user()->mfi_id,
        ]; */
        // $if($request->page){

        // }
        $rewardList = Reward::where('is_active', 1)->get();
        //$listCustomers = $this->userService->listCustomers($filterConditionsUsers, 'id', 'asc');
        // return json_encode($listCustomers[0]->mediaImage);
        return $this->responseJson(true, 200, "", RewardDetailApiCollection::collection($rewardList));
    }

    public function rewardDetails(Request $request, $id)
    {
        /* $filterConditionsUsers = [
            'mfi_id' => auth()->user()->mfi_id,
        ]; */
        // $if($request->page){

        // }

        $rewardList = Reward::where('is_active', 1)->where('id', $id)->first();


        $rewardList['images'] = url('storage/images/reward/' . $rewardList->images);

        //$listCustomers = $this->userService->listCustomers($filterConditionsUsers, 'id', 'asc');
        // return json_encode($listCustomers[0]->mediaImage);
        return $this->responseJson(true, 200, "", $data = $rewardList);
    }

    public function findRating(Request $request, $id)
    {
        $rewardList = Reward::where('is_active', 1)->where('id', $id)->first();

        if ($rewardList != "") {
            $rewardList->rating = $request->rating;
            $rewardList->save();
        } else {
            return $this->responseJson(false, 400, "No data found", "");
        }

        return $this->responseJson(true, 200, "", $data = $rewardList);
    }

    public function trainerList(Request $request)
    {
        /* $filterConditionsUsers = [
            'mfi_id' => auth()->user()->mfi_id,
        ]; */
        // $if($request->page){

        // }
        //$trainerList = User::where('is_active', 1)->get();
        //$listCustomers = $this->userService->listCustomers($filterConditionsUsers, 'id', 'asc');
        // return json_encode($listCustomers[0]->mediaImage);
        $filterConditions = [
            'is_active' => 1,
            'type' => '0'
        ];
        $filterConditionss = [
            'is_active' => 1,
            'type' => '1'
        ];
        $users = $this->userService->getCustomers('trainer', $filterConditions);
        $userss = $this->userService->getCustomers('trainer', $filterConditionss);
        $data['trainer'] = UserTrainerDetailApiCollection::collection($users);
        $data['Dietitian'] = UserTrainerDetailApiCollection::collection($userss);
        return $this->responseJson(true, 200, "", $data);
    }

    public function trainerDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "user_id" => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            $error = ['error' => $validator->errors()->all()];
            return $this->responseJson(false, 400, $validator->errors()->first(), "");
        }
        $filterConditions = [
            'is_active' => 1
        ];
        $users = $this->userService->getCustomers('trainer', $filterConditions);
        $users = $users->where('id', $request->user_id)->first();

        return $this->responseJson(true, 200, "", new UserTrainerDetailApiCollection($users));
    }

    public function trainerCustomerRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "trainer_id" => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            $error = ['error' => $validator->errors()->all()];
            return $this->responseJson(false, 400, $validator->errors()->first(), "");
        }
        $trainRequestExist = TrainerCustomerRequest::where('trainer_id', $request->trainer_id)->where('user_id', auth()->user()->id)->first();
        if (!empty($trainRequestExist)) {
            return $this->responseJson(false, 200, "Sorry you can't request a same trainer again !!", "");
        }
        $customerRequest = TrainerCustomerRequest::create([
            "trainer_id" => $request->trainer_id,
            "user_id" => auth()->user()->id,
            "details" => "Customer Request",
        ]);
        if ($customerRequest) {
            return $this->responseJson(true, 200, "Request Sent Successfully !!", "");
        }
    }
    public function subscriptionPlanList(Request $request)
    {
        if (auth()->user()->payment_type == "0") {
            $plans = Plan::where('status', 1)->with('courses')->get();
        } else {
            $id = auth()->user()->payment_type;
            $plans = Plan::where('status', 1)
                ->where('id', '!=', $id)
                ->with('courses')
                ->get();
        }
        return $this->responseJson(true, 200, "", SubscriptionApiCollection::collection($plans));
    }

    public function dietPlanList(Request $request)
    {
        // $planss = Diet::where('status', 1)->where('age_from',auth()->user()?->profile?->age)
        // ->where('height',auth()->user()?->profile?->height)->where('weight',auth()->user()?->profile?->weight) ->first();

        if (auth()->user()?->profile?->age != "" && auth()->user()?->profile?->height != "" && auth()->user()?->profile?->weight) {
            $info =  ProfileOtherInformation::where('user_id', auth()->user()->id)->first();
            $planss = Diet::where('status', 1)->first();

            $q = $info->diet_type;
            $planss['food_type_optionsend'] = $q;
            // $planss = Diet::whereHas('foods', function($q){
            //     $q->where('food_type_option','non_veg');
            // })->first();
            // $planss = Diet::all();
            // dd($planss->foods);

            if ($planss) {
                $today = Carbon::today();
                $fooditem = UserFoodItemDetail::where('user_id', auth()->user()->id)->whereDate('updated_at', $today)->first();


                if ($fooditem) {
                    $fooditems = explode(',', $fooditem->food_ids);




                    $food = Food::whereIn('id', $fooditems)->get();

                    $bkcl = [];
                    $bkprotien = [];
                    $bkfats = [];
                    $bkfibre = [];
                    $bkcarbs = [];
                    foreach ($food as $foods) {

                        if ($foods->food_type == "breakfast") {

                            $bkcl[] = $foods->breakfast_callories;
                            $bkprotien[] = $foods->proteins;
                            $bkfats[] = $foods->fats;
                            $bkfibre[] = $foods->fibre;
                            $bkcarbs[] =  $foods->carbs;
                        }
                        if ($foods->food_type == "lunch") {
                            $bkcl[] = $foods->lunch_callories;
                            $bkprotien[] = $foods->proteins;
                            $bkfats[] = $foods->fats;
                            $bkfibre[] = $foods->fibre;
                            $bkcarbs[] =  $foods->carbs;
                        }
                        if ($foods->food_type == "dinner") {
                            $bkcl[] = $foods->dinner_callories;
                            $bkprotien[] = $foods->proteins;
                            $bkfats[] = $foods->fats;
                            $bkfibre[] = $foods->fibre;
                            $bkcarbs[] =  $foods->carbs;
                        }
                        if ($foods->food_type == "snack") {
                            $bkcl[] = $foods->snack_callories;
                            $bkprotien[] = $foods->proteins;
                            $bkfats[] = $foods->fats;
                            $bkfibre[] = $foods->fibre;
                            $bkcarbs[] =  $foods->carbs;
                        }
                    }

                    $totalprotien = array_sum($bkprotien);
                    $totalfats = array_sum($bkfats);
                    $totalfibre = array_sum($bkfibre);
                    $totalcal = array_sum($bkcl);
                    $totalcarbs = array_sum($bkcarbs);
                } else {
                    $totalprotien = 0;
                    $totalfats = 0;
                    $totalfibre = 0;
                    $totalcal = 0;
                    $totalcarbs = 0;
                }









                //    if($planss){
                //     $bkfast = [];
                //     $bkprotien = [];
                //     $bkfats = [];
                //     $bkfibre = [];

                //     foreach ($food->breakfasts as $breakfasts) {
                //         $bkfast[] = $breakfasts->breakfast_callories;
                //         $bkprotien[] = $breakfasts->proteins;
                //         $bkfats[] = $breakfasts->fats;
                //         $bkfibre[] = $breakfasts->fibre;
                //     }
                //     $breaksum = array_sum($bkfast);
                //     $protiensum = array_sum($bkprotien);
                //     $fatssum = array_sum($bkfats);
                //     $fibressum = array_sum($bkfibre);

                //     $lunch = [];
                //     $bkprotiens = [];
                //     $bkfatss = [];
                //     $bkfibres = [];
                //     foreach ($planss->lunches as $lunches) {
                //         $lunch[] = $lunches->lunch_callories;
                //         $bkprotiens[] = $lunches->proteins;
                //         $bkfatss[] = $lunches->fats;
                //         $bkfibres[] = $lunches->fibre;
                //     }
                //     $lunchsum = array_sum($lunch);
                //     $protiensums = array_sum($bkprotiens);
                //     $fatssums = array_sum($bkfatss);
                //     $fibressums = array_sum($bkfibres);


                //     $dinner = [];
                //     $bkprotienss = [];
                //     $bkfatsss = [];
                //     $bkfibress = [];
                //     //  echo "<pre>";
                //     //     print_r($plans->dinners);
                //     //     die();
                //     foreach ($planss->dinners as $dinners) {

                //         $dinner[] = $dinners->dinner_callories;
                //         $bkprotienss[] = $dinners->proteins;
                //         $bkfatsss[] = $dinners->fats;
                //         $bkfibress[] = $dinners->fibre;
                //     }

                //     $dinnersum = array_sum($dinner);
                //     $protiensumss = array_sum($bkprotienss);
                //     $fatssumss = array_sum($bkfatsss);
                //     $fibressumss = array_sum($bkfibress);

                //     $snack = [];
                //     $bkprotiensss = [];
                //     $bkfatssss = [];
                //     $bkfibresss = [];
                //     foreach ($planss->snacks as $snacks) {
                //         $snack[] = $snacks->snack_callories;
                //         $bkprotiensss[] = $snacks->proteins;
                //         $bkfatssss[] = $snacks->fats;
                //         $bkfibresss[] = $snacks->fibre;
                //     }
                //     $snackssum = array_sum($snack);
                //     $protiensumsss = array_sum($bkprotiensss);
                //     $fatssumsss = array_sum($bkfatssss);
                //     $fibressumsss = array_sum($bkfibresss);



                // if (empty($breaksum) || empty($lunchsum) || empty($dinnersum) || empty($snackssum) || empty($protiensum) || empty($protiensums) || empty($protiensumss) || empty($protiensumsss) || empty($fatssum) || empty($fatssums) || empty($fatssumss) || empty($fatssumsss) || empty($fibressum) || empty($fibressums) || empty($fibressumss) || empty($fibressumsss)) {
                //     return response()->json(['message' => 'Error in fetching data.'], 400);
                // }

                // $total = $breaksum + $lunchsum + $dinnersum + $snackssum;
                // $totalprotiens = $protiensum + $protiensums + $protiensumss + $protiensumsss;
                // $totalfat = $fatssum + $fatssums + $fatssumss + $fatssumsss;
                // $totalfibre = $fibressum + $fibressums + $fibressumss + $fibressumsss;

                $plans = $planss;

                if (!empty($plans)) {
                    $keys = ["calorie", "protiens", "fats", "fibre", "carbs"];
                    $values = [$totalcal, $totalprotien, $totalfats, $totalfibre, $totalcarbs];

                    for ($i = 0; $i < count($keys); $i++) {

                        $plans[$keys[$i]] += $values[$i];
                    }


                    // $info =  ProfileOtherInformation::where('user_id', auth()->user()->id)->first();

                    // $breakfasts = $planss->when(!empty($planss), function ($query) use ($info) {
                    //     $query->whereHas('breakfasts', function ($subquery) use ($info) {
                    //         $subquery->where('your_column_name', $info->your_value); // Replace with your actual column name and value
                    //     });
                    // })->breakfasts;
















                    if (auth()->user()->is_subscribed == 1) {

                        $updatefood = UserFootitem::where('user_id', auth()->user()->id)->where('trainer_id', auth()->user()->dietitian_id)->get();

                        $foodids = []; // Initialize the $foodids array outside the loop
                        $optionids = [];
                        $breakfastwater = [];
                        $breakfastremark = [];
                        $breakfastlunch = [];
                        $lunchremark = [];
                        $breakfastdinner = [];
                        $dinnerremark = [];
                        $breakfastsnack = [];
                        $snackremark = [];

                        foreach ($updatefood as $updatefoods) {


                            $food = json_decode($updatefoods->food, true);

                            $option_food = json_decode($updatefoods->option_food, true);
                            foreach ($food as $foodid) {
                                $foodids[] = $foodid['id'];
                            }

                            foreach ($option_food as $option_foods) {
                                $optionids[] = $option_foods['id'];
                            }

                            if ($updatefoods->foot_type == "breakfast") {
                                $breakfastwater[] = $updatefoods->water;
                                $breakfastremark[] = $updatefoods->remarks;
                            } elseif ($updatefoods->foot_type == "lunch") {
                                $breakfastlunch[] = $updatefoods->water;

                                $lunchremark[] = $updatefoods->remarks;
                            } elseif ($updatefoods->foot_type == "dinner") {
                                $breakfastdinner[] = $updatefoods->water;
                                $dinnerremark[] = $updatefoods->remarks;
                            } elseif ($updatefoods->foot_type == "snack") {
                                $breakfastsnack[] = $updatefoods->water;
                                $snackremark[] = $updatefoods->remarks;
                            }
                        }


                        if ($breakfastwater) {
                            $breakfastwaters = $breakfastwater[0];
                        } else {
                            $breakfastwaters = "";
                        }
                        if ($breakfastlunch) {
                            $breakfastlunchs = $breakfastlunch[0];
                        } else {
                            $breakfastlunchs = "";
                        }
                        if ($breakfastdinner) {
                            $breakfastdinners = $breakfastdinner[0];
                        } else {
                            $breakfastdinners = "";
                        }
                        if ($breakfastsnack) {
                            $breakfastsnacks = $breakfastsnack[0];
                        } else {
                            $breakfastsnacks = "";
                        }


                        if ($breakfastremark) {
                            $breakfastremarks = $breakfastremark[0];
                        } else {
                            $breakfastremarks = "";
                        }
                        if ($lunchremark) {
                            $lunchremarks = $lunchremark[0];
                        } else {
                            $lunchremarks = "";
                        }
                        if ($dinnerremark) {
                            $dinnerremarks = $dinnerremark[0];
                        } else {
                            $dinnerremarks = "";
                        }
                        if ($snackremark) {
                            $snackremarks = $snackremark[0];
                        } else {
                            $snackremarks = "";
                        }








                        $getfood = Food::whereIn('id', $foodids)->orderBy('created_at', 'desc')->get();
                        $breakfast = [];
                        $lunch = [];
                        $dinner = [];
                        $snack = [];

                        foreach ($getfood as $data) {
                            if ($data->food_type == "breakfast") {
                                $breakfast[] = $data;
                            } elseif ($data->food_type == "lunch") {
                                $lunch[] = $data;
                            } elseif ($data->food_type == "dinner") {
                                $dinner[] = $data;
                            } elseif ($data->food_type == "snack") {
                                $snack[] = $data;
                            }
                        }





                        $keys = ["breakfast", "lunch", "dinner", "snack", "breakfastwater", "breakremark", "breakfastlunch", "lunchremark", "breakfastdinner", "dinnerremarks", "breakfastsnack", "snackremarks"];
                        $values = [$breakfast, $lunch, $dinner, $snack, $breakfastwaters, $breakfastremarks, $breakfastlunchs, $lunchremarks, $breakfastdinners, $dinnerremarks, $breakfastsnacks, $snackremarks];


                        for ($i = 0; $i < count($keys); $i++) {
                            $plans[$keys[$i]] = $values[$i];
                        }

                        $getfoods = Food::whereIn('id', $optionids)->orderBy('created_at', 'desc')->get();

                        $breakfasts = [];
                        $lunchs = [];
                        $dinners = [];
                        $snacks = [];

                        foreach ($getfoods as $datas) {
                            if ($datas->food_type == "breakfast") {
                                $breakfasts[] = $datas;
                            } elseif ($datas->food_type == "lunch") {
                                $lunchs[] = $datas;
                            } elseif ($datas->food_type == "dinner") {
                                $dinners[] = $datas;
                            } elseif ($datas->food_type == "snack") {
                                $snacks[] = $datas;
                            }
                        }


                        $keyss = ["breakfasts", "lunchs", "dinners", "snacks"];
                        $valuess = [$breakfasts, $lunchs, $dinners, $snacks];


                        for ($i = 0; $i < count($keyss); $i++) {
                            $plans[$keyss[$i]] = $valuess[$i];
                        }



                        $plans = new UpdateDietApiCollection($plans);
                    } else {

                        $plans = new DietApiCollection($plans);
                    }
                } else {
                    return response()->json(['message' => 'No diet plans found.'], 404);
                }
                return $this->responseJson(true, 200, "", $plans);
            } else {
                return response()->json(['status' => false, 'message' => 'please update your profile in proper height and weight.'], 200);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'please update your profile in proper height and weight.'], 200);
        }
    }

    public function physicallyConditionList(Request $request)
    {
        /* $filterConditionsUsers = [
            'mfi_id' => auth()->user()->mfi_id,
        ]; */
        // $if($request->page){

        // }
        $rewardList = UserPhysicallyActiveConditions::where('status', 1)->get();
        //$listCustomers = $this->userService->listCustomers($filterConditionsUsers, 'id', 'asc');
        // return json_encode($listCustomers[0]->mediaImage);
        return $this->responseJson(true, 200, "", PhysicallyConditionDetailApiCollection::collection($rewardList));
    }

    public function fitnessGoalList(Request $request)
    {
        /* $filterConditionsUsers = [
            'mfi_id' => auth()->user()->mfi_id,
        ]; */
        // $if($request->page){

        // }
        $rewardList = FitnessGoal::where('status', 1)->get();
        //$listCustomers = $this->userService->listCustomers($filterConditionsUsers, 'id', 'asc');
        // return json_encode($listCustomers[0]->mediaImage);
        return $this->responseJson(true, 200, "", FitnessGoalDetailApiCollection::collection($rewardList));
    }
    public function faqList(Request $request)
    {
        $rewardList = Faq::where('is_active', 1)->get();
        //$listCustomers = $this->userService->listCustomers($filterConditionsUsers, 'id', 'asc');
        // return json_encode($listCustomers[0]->mediaImage);
        return $this->responseJson(true, 200, "", FaqDetailApiCollection::collection($rewardList));
    }

    public function privacyPolicy(Request $request)
    {
        $rewardList = Page::where('slug', 'privacy-policy')->first();
        //dd($rewardList);
        //$listCustomers = $this->userService->listCustomers($filterConditionsUsers, 'id', 'asc');
        // return json_encode($listCustomers[0]->mediaImage);
        return $this->responseJson(true, 200, "", $rewardList);
    }

    /**
     * @OA\Post(
     *      path="/agent/logout",
     *      tags={"Agentlogout"},
     *      operationId="AgentLogout",
     *      summary="Agent Logout",
     *      description="Agent Logout",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function logout(Request $request)
    {
        $user = auth()->user();
        $message = "User Logged Out successfully";

        return $this->responseJson([
            'status'        =>  true,
            'response_code' =>  200,
            'message'       =>  $message,
            'data'          =>  $user
        ]);
    }
    /**
     * @OA\post(
     *      path="api/agent/change-password",
     *      tags={"agentChangePassword"},
     *      operationId="agentChangePassword",
     *      summary="ChangePassword",
     *      description="ChangePassword information",
     *      @OA\Parameter(
     *          name="new_password",
     *          description="new_password",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="confirm_password",
     *          description="confirm_password",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function changePassword(Request $request)
    {
        $userId = auth()->user()->id;
        // if ($request->post()) {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string',
            'new_password' => 'required|min:6|string'
        ]);
        if ($validator->fails()) {
            // If validation failed, prepare the response with the errors
            $errors = $validator->errors()->all();
            $responseData = ['errors' => $errors];

            // Return the JSON response with the prepared response data
            // return response()->json([
            //     'success' => false,
            //     'status' => 200,
            //     'data' => 'The new password must be at least 8 characters',
            // ]);
        }
        /*  $user = auth()->user(); */
        $userDetails = User::where('id', $userId)->first();
        if (!Hash::check($request->input('old_password'), $userDetails->password)) :
            $message = "Old Password Does Not Match!";
            // return $this->responseJson([
            //     'status'        =>  false,
            //     'response_code' =>  200,
            //     'message'       =>  $message,
            //     'data'          =>  ""
            // ]);
            return response()->json([
                'status' => false,
                'response_code' => 200,
                'message' => $message,
            ]);
        /* return response()->json([
                        'status'    => FALSE,
                        'message'   =>'Old Password Does Not Match!',
                        'data'      => $this->object
                    ],403); */
        else :
            User::where('id', $userId)
                ->update([
                    'password' => Hash::make($request->input('new_password')),
                    'is_password_changed' => 1
                ]);
            $message = "Password Updated successfully";
            // return $this->responseJson([
            //     'status'        =>  true,
            //     'response_code' =>  200,
            //     'message'       =>  $message,
            //     'data'          =>  ""
            // ]);
            return response()->json([
                'status' => true,
                'response_code' => 200,
                'message' => $message,
            ]);
        endif;
        /* $userData = new UserApiCollection($user);
                $isProcessed = $this->userService->saveUserProfileDetails([
                    'password' => $request->new_password,
                    'is_password_changed' => 1,
                ], $userId);
                if ($isProcessed) {
                    $message = "Password changed in successfully";
                return $this->responseJson([
                        'status'        =>  true,
                        'response_code' =>  200,
                        'message'       =>  $message,
                        'data'          =>  $userData
                    ]);

            } else {
                $message = "Something went wrong please try again";
                return $this->responseJson([
                    'status'        =>  false,
                    'response_code' =>  200,
                    'message'       =>  $message,
                    'data'          =>  ""
                ]);
            } */
    }

    public function profileImageupdate(Request $request)
    {
        $userId = auth()->user()->id;
        $validator = Validator::make($request->all(), [
            "customer_image" => 'required|file|mimes:jpg,png,gif,jpeg'
        ]);
        if ($validator->fails()) {
            $error = ['error' => $validator->errors()->all()];
            return $this->responseJson(false, 200, $validator->errors()->first(), "");
        }
        //\DB::beginTransaction();
        /* try{ */
        $userData =  $this->userService->updateOrCreateProfileImage($request->all(), $userId);

        if ($userData) {
            return $this->responseJson(true, 200, "Profile Image Updated Successfully", new UserProfileImageDetailApiCollection($userData));
        }
    }

    public function cms($id)
    {
        $data = Page::where('id', $id)->where('status', 1)->first();
        return response()->json(['status' => true, 'message' => 'Cms Listing.', 'data' => $data], 200);
    }
    public function faq($id)
    {
        $data = Faq::where('id', $id)->first();
        return response()->json(['status' => true, 'message' => 'Faq Listing.', 'data' => $data], 200);
    }

    public function notification(Request $request)
    {
        $userId = auth()->user()->id;

        $data = Notification::where('user_id', $userId)->get();
        return response()->json(['status' => true, 'message' => 'Notification Listing.', 'data' => $data], 200);
    }

    public function rechargeWallet(Request $request)
    {
        $validator = Validator::make($request->all(), ["amount" => "required|numeric"]);
        if ($validator->fails()) {
            return $this->apiResponseJson(false, 422, $validator->errors()->first(), (object) []);
        }
        // $plans = Plan::where('id', $id)->where('status', 1)->with('courses')->get();
        $amount = $request->amount * 100;
        $receiptId = uniqid('recharge_');

        $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));

        $orderData = [
            'amount' => $amount,
            'currency' => 'INR',
            'receipt' => $receiptId,
            'payment_capture' => 1
            // 'description' => 'Wallet Recharge',
        ];

        try {
            $razorpayOrder = $api->order->create($orderData);
            // Transaction::create([
            //     "user_id" => Auth::id(),
            //     "razorpayOrderId" => $razorpayOrder?->id,
            //     "paidAmount" => $razorpayOrder?->amount / 100,
            //     "remark" => "Wallet Recharge",
            //     // "paymentDate" => ,
            //     "paymentStatus" => "Pending",
            // ]);

            // if ($transactionCreated) {
            //     $transactionLogCreated = [];
            // }
            return $this->apiResponseJson(true, 200, 'Intent created successfully in Razorpay Server', (object)[
                "amount" => $razorpayOrder?->amount,
                "orderId" => $razorpayOrder?->id
            ]);
        } catch (\Exception $e) {
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->apiResponseJson(false, 500, $e->getMessage(), (object) []);
        }
    }

    public function transaction(Request $request, $id)
    {
        $plans = Plan::where('id', $id)->where('status', 1)->with('courses')->get();
        return $this->responseJson(true, 200, "", SubscriptionApiCollection::collection($plans));
        //return response()->json(['status' => true, 'message' => 'Transaction Details.', 'data' => $data], 200);
    }

    public function profileQuestionStore(Request $request)
    {
        $userId = auth()->user()->id;

        $validator = Validator::make($request->all(), [
            "start_pause_date" => 'required|date',
            "type" => 'in:0,1' //0-pause,1-start
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 200, $validator->errors()->first(), (object)[]);
        }
        try {
            // echo "Start Pause Subscription";
            return response()->json(['status' => true, 'message' => 'Success', 'data' => (object)[]], 200);
        } catch (Exception $e) {
            logger($e->getMessage());
            return response()->json(['status' => false, 'message' => 'Something went wrong!', 'data' => (object)[]], 500);
        }
    }

    public function paymentIntent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $amount = $request->input('amount');
        $callbackUrl = route('payment.callback');
        // $orderId = uniqid('order_');

        // $response = $this->phonePeService->initiatePayment($amount, $callbackUrl, $orderId);

        // if ($response && $response['success']) {
        //     return response()->json(['paymentUrl' => $response['data']['instrumentResponse']['redirectUrl']], 200);
        // }


        // $isTransactionAdded = Transaction::create([
        //     'user_id' => auth()->user()->id,
        //     'quiz_id' => $id,
        //     'transaction_no' => $transactionId,
        //     'transaction_type' => 'PhonePay',
        //     'amount' => $amount,
        // ]);
        // "mobileNumber" => (string) auth()->user()->phone ?? '8918906608',
        $transactionId = 'MT' . uniqid();
        $userId = 'MUID' . rand(100, 999);
        $data = [
            // "merchantId" => "M22LJ4MP063NS",
            "merchantId" => "M22IQQIMAPRZY",
            "merchantTransactionId" => $transactionId,
            "merchantUserId" => $userId,
            "amount" => $amount * 100,
            "redirectUrl" => $callbackUrl,
            "redirectMode" => "POST",
            "callbackUrl" => $callbackUrl,
            "mobileNumber" => '8918906608',
            "paymentInstrument" => [
                "type" => "PAY_PAGE"
            ]
        ];
        $encode = base64_encode(json_encode($data));
        $saltKey = '14907035-1007-46a0-9853-8dbd2edc5dfa';
        $saltIndex = 1;
        $string = $encode . "/pg/v1/pay" . $saltKey;
        $sha256 = hash('sha256', $string);
        $finalXHeader = $sha256 . '###' . $saltIndex;
        $merchant_id = "M22IQQIMAPRZY";
        $finalXHeadercheckStatus = hash('sha256', '/pg/v1/status/' . $merchant_id . '/' . $transactionId . $saltKey) . '###' . $saltIndex;

        return $this->responseJson(true, 200, "Payment Initiated", ['encoded_data' => $encode, 'sha256' => $sha256, 'checksum' => $finalXHeader, 'entry_fee' => $amount * 100, 'order_id' => $transactionId, "status_check_encoded_data" => $finalXHeadercheckStatus]);
    }

    public function savetransaction(Request $request)
    {
        $userId = auth()->user()->id;

        $validator = Validator::make($request->all(), [
            "transaction_id" => 'required'
        ]);
        if ($validator->fails()) {
            $error = ['error' => $validator->errors()->all()];
            return $this->responseJson(false, 200, $validator->errors()->first(), "");
        }

        $plan = plan::where('id', $request->payment_type)->first();
        $days = $plan->expiry_date;

        $today = Carbon::today();
        $expireDate = Carbon::parse($today)->addDays($days);


        $payment_date = Carbon::today()->toDateString();
        $otpupdate = User::where('id', $userId)->update([
            'payment_type' => $request->payment_type,
            'is_subscribed' => "1",
            'transaction_id' => $request->transaction_id,
            'dietitian_id' => $request->dietitian_id,
            'trainer_id' => $request->trainer_id,
            'plan_expire' => $expireDate,
            'payment_date' => $payment_date
        ]);
        $requestparam = (object)array(
            'body' => 'Congratulations! You are pro mem ber now.
            Thank you for making us part of your fitness journey.',
            'title' => 'Swasthfit'
        );
        $fcm =  auth()->user()->fcm_token;

        $this->sendNotificationtest($requestparam, $fcm);
        $fcmusertrainer = User::where('id', $request->trainer_id)->first();
        $this->sendNotificationtesttrainer($requestparam, $fcmusertrainer->fcm_token);
        $fcmuserdietitian = User::where('id', $request->dietitian_id)->first();
        $this->sendNotificationtesttrainer($requestparam, $fcmuserdietitian->fcm_token);
        return response()->json(['status' => true, 'message' => 'Transaction Store successfully.'], 200);
    }

    public function startPauseSubscription(Request $request)
    {
        $userId = auth()->user()->id;

        $validator = Validator::make($request->all(), [
            "start_pause_date" => 'required|date',
            "type" => 'in:0,1' //0-pause,1-start
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 200, $validator->errors()->first(), (object)[]);
        }
        try {
            // echo "Start Pause Subscription";
            return response()->json(['status' => true, 'message' => 'Success', 'data' => (object)[]], 200);
        } catch (Exception $e) {
            logger($e->getMessage());
            return response()->json(['status' => false, 'message' => 'Something went wrong!', 'data' => (object)[]], 500);
        }
    }

    public function getscriptiondetails(Request $request)
    {
        $userId = auth()->user();
        $users = User::where('id', $userId->dietitian_id)->get();
        $userss = User::where('id', $userId->trainer_id)->get();

        $data['trainer'] = UserTrainerDetailApiCollection::collection($userss);
        $data['Dietitian'] = UserTrainerDetailApiCollection::collection($users);
        return $this->responseJson(true, 200, "", $data);
        //return response()->json(['status' => true, 'message' => 'Transaction Details.', 'data' => $data], 200);
    }

    public function userDeleteAccount(Request $request)
    {
        $userId = auth()->user()->id;
        $user = User::find($userId);

        if (!$user) {
            return $this->responseJson(false, 404, "User not found.");
        }

        if ($request->status == 0) {
            $user->is_active = 0;
            $user->save();
            return $this->responseJson(true, 200, "User set as inactive.");
        } else if ($request->status == 1) {
            $user->delete();
            return $this->responseJson(true, 200, "User deleted successfully.");
        } else {
            return $this->responseJson(false, 400, "Invalid status provided.");
        }
    }

    public function postAppVersion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "version" => 'required|unique:version_controls|max:10'
        ]);

        if ($validator->fails()) {
            $error = ['error' => $validator->errors()->all()];
            return $this->responseJson(false, 200, $validator->errors()->first(), "");
        }

        VersionControl::updateOrCreate(
            ['id' => '1'],
            ['version' => $request->version], // Check based on version
        );
        // Attempting to create a new record or update an existing one
        return response()->json(['status' => 'true', 'message' => 'Version updated successfully', 'data' => $request->version]);
    }

    public function getAppVersion(Request $request)
    {
        $data = VersionControl::select('version')->where('id', '1')->first();
        return response()->json(['status' => 'true', 'message' => 'Version updated successfully', 'data' => $data]);
    }

    public function screenTime(Request $request)
    {
        $userId = auth()->user()->id; // Get the authenticated user's ID

        // Retrieve the required data from the request
        $screenName = $request->input('screen_name');
        $timeSpend = $request->input('time_spend');
        $deviceId = $request->input('device_id');

        // Create a new log instance

        $log = new Log();
        $log->screen_name = $screenName;
        $log->time_spend = $timeSpend;
        $log->device_id = $deviceId;
        $log->user_id = $userId; // Set the user_id to associate the log with the correct user

        // Save the log entry
        $log->save();

        //return response()->json(['message' => 'Screen time logged successfully']);
        return response()->json(['status' => 'true', 'message' => 'Screen time logged successfully', 'data' => []]);
    }

    public function workoutList(Request $request)
    {
        $workoutType  = ["exercises", "meditation", "yoga"];
        if (auth()->user()->is_subscribed == 1) {
            $return = [];
            foreach ($workoutType  as $key => $value) {
                $return[$value] = WorkoutUpdatePlanApiCollection::collection($updatefood = UserWorkoutItem::where('user_id', auth()->user()->id)->where('trainer_id', auth()->user()->trainer_id)->where('workout_type', $value)->get());
            }
        } else {

            $return = [];
            foreach ($workoutType  as $key => $value) {
                $return[$value] = WorkoutPlanApiCollection::collection(Workout::where('status', 1)->where('workout_type', $value)
                    ->get());
            }
        }
        // ret
        return $this->responseJson(true, 200, "", $return);
        // return $plans;

    }

    public function sendNotification(Request $request)
    {
        $userId = auth()->user()->id;
        if (auth()->user()->is_subscribed == 1) {
            $fooditem = UserFootitem::where('user_id', $userId)->where('status', '0')->get();
            if ($fooditem) {
                $requestparam = (object)array(
                    'body' => 'Complete Questionnaire to get your personalised plan.',
                    'title' => 'Swasthfit'
                );
                $fcm = auth()->user()->fcm_token;
                $this->sendNotificationtest($requestparam, $fcm);
            }
        } else if (auth()->user()->is_subscribed == 0) {
        }
    }

    public function sendNotificationtest($requestparam, $fcm)
    {
        $SERVER_API_KEY = env('FIREBASE_KEY', '');
        $data = [
            "to" => $fcm,
            "notification" => [
                "title" => $requestparam->title,
                "body" => $requestparam->body,
            ],
            'priority' => 'high'
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=AAAA0_NYakU:APA91bFwWPAETORsMD1nKJp6j4qsJVFmOQXTQntpfdZe0Y6jBD5LSRD3NeaPweYzDkgn_MVm7UONE-24GizS6E9UhT9oMwCOur8O_pjtVD7YPJzl5jXaJm6rbf2MZfvrBW2rA0P33-Wi',
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
        if ($response === FALSE) {

            die('FCM Send Error: ' . curl_error($ch));
        }
        return $response;
        //dd($response);
    }

    public function sendNotificationtesttrainer($requestparam, $fcm)
    {
        $SERVER_API_KEY = env('FIREBASE_KEY', '');
        $data = [
            "to" => $fcm,
            "notification" => [
                "title" => $requestparam->title,
                "body" => $requestparam->body,
            ],
            'priority' => 'high'
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=AAAAxBaUZmo:APA91bHcb5DBBQTfAy7WH2AJl6n4vFD4O7w_g3lTSsRI6eaCPy1XAufwr6DaL-4Tqxq_Q6ZUIMbNYDFCNMVJDYqUa4x07VThDk1qBsa9soPw0aOcs37ZaN_kBeNGsk_ySyfXM9WxMCLP',
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
        if ($response === FALSE) {

            die('FCM Send Error: ' . curl_error($ch));
        }
        return $response;
        //dd($response);
    }

    public function notificationUpdate(Request $request)
    {
        $userId = auth()->user()->id;
        $fooditem = UserFootitem::where('user_id', $userId)->update([
            'status' => $request->status,
            // add more columns as needed
        ]);

        if ($fooditem > 0) {
            // Update was successful
            return response()->json(['message' => 'Update successful'], 200);
        } else {
            // No records were updated
            return response()->json(['message' => 'No records were updated'], 404);
        }
    }

    public function getEcommerceHome(Request $request)
    {
        $userId = auth()->user()->id;
        $cartItemscount = Cart::where('user_id', $userId)->where('is_active', '0')->count();
        $lastWeek = Carbon::now()->subDays(7)->toDateTimeString();
        $data['new-product'] = Product::where('created_at', '>=', $lastWeek)
            ->get();
        $data['banner'] = Banner::where('is_active', '1')->get();
        $data['brand'] = Category::where('is_active', '1')->get();

        $data['best-deal'] = Product::where('is_deal', '1')->get();
        $data['best-sale'] = Product::where('is_sales', '1')->get();

        $formattedResponse = [
            "status" => true,
            "data" => [
                [
                    "type" => "sliderbanner",
                    "label" => "Banner",
                    "view_type" => "0",
                    "banner" => $this->formatBannerItems($data['banner'])
                ],
                [
                    "type" => "category",
                    "label" => "Category",
                    "view_type" => "1",
                    "brand" => $this->formatBrandItems($data['brand'])
                ],
                [
                    "type" => "new_products",
                    "label" => "New Products",
                    "view_type" => "2",
                    "items" => $this->formatProductItems($data['new-product'])
                ],
                [
                    "type" => "best_deals",
                    "label" => "Best Deals",
                    "view_type" => "3",
                    "items" => $this->formatProductItems($data['best-deal'])
                ],
                [
                    "type" => "best_sales",
                    "label" => "Best Selling Products",
                    "view_type" => "4",
                    "items" => $this->formatProductItems($data['best-deal'])
                ],

            ],
            "totalcart" => $cartItemscount
        ];

        return response()->json($formattedResponse);
    }

    private function formatBannerItems($banners)
    {
        // Format your banner items here
        return $banners->map(function ($banner) {
            return [
                "id" => $banner->id,
                "title" => $banner->title,
                "link" => $banner->link,
                "description" => $banner->description,
                "images" => asset('images/' . $banner->banner_img_file),
            ];
        });
    }

    private function formatBrandItems($brands)
    {
        // Format your brand items here
        return $brands->map(function ($brand) {
            return [
                "id" => $brand->id,
                "name" => $brand->name,
                "icon" =>  asset('images/' . $brand->category_image), // replace 'icon_url' with the actual attribute name for the icon
            ];
        });
    }

    private function formatProductItems($products)
    {
        // Format your product items here
        return $products->map(function ($product) {
            $images = explode(', ', $product->product_image);
            $productimages = asset('images/' . $images[0]);

            $discountvalue = $product->price * $product->discount / 100;
            $actual_price = $product->price - $discountvalue;

            $ratings = Rating::where('product_id', $product->id)->get();
            $averageRating = $ratings->avg('rating');

            if ($averageRating === null) {
                $averageRating = 0;
            }

            // Modify this according to your duct model attributes
            return [
                "id" => $product->id,
                "name" => $product->name,
                "actual_price" => $product->price,
                "price" => $actual_price,
                "discount" => $product->discount,
                "images" => $productimages,
                'rating' => $averageRating
                // Add more attributediscountvalue;s as needed
            ];
        });
    }

    public function getProductList(Request $request)
    {
        $userId = auth()->user()->id;
        $cartItemscount = Cart::where('user_id', $userId)->where('is_active', '0')->count();
        $sortDirection = $request->input('sort');
        $searchTerm = $request->input('search_term');
        $type = $request->input('type');
        $category = $request->input('category');
        $productQuery = Product::where('is_active', '1');
        if ($searchTerm) {
            $productQuery->where('name', 'LIKE', '%' . $searchTerm . '%');
            // Store recent search
        } elseif ($type == "new_products") {
            $lastWeek = Carbon::now()->subDays(7)->toDateTimeString();
            $productQuery->where('created_at', '>=', $lastWeek);
            if ($sortDirection == "discount") {
                $productQuery->orderBy('discount', 'desc');
            } elseif ($sortDirection == "lth") {
                $productQuery->orderBy('price', 'asc');
            } elseif ($sortDirection == "htl") {
                $productQuery->orderBy('price', 'desc');
            }
        } elseif ($type == "best_deals") {
            $productQuery->where('is_deal', '1');
            if ($sortDirection == "discount") {
                $productQuery->orderBy('discount', 'desc');
            } elseif ($sortDirection == "lth") {
                $productQuery->orderBy('price', 'asc');
            } elseif ($sortDirection == "htl") {
                $productQuery->orderBy('price', 'desc');
            }
        } elseif ($type == "best_sales") {
            $productQuery->where('is_sales', '1');
            if ($sortDirection == "discount") {
                $productQuery->orderBy('discount', 'desc');
            } elseif ($sortDirection == "lth") {
                $productQuery->orderBy('price', 'asc');
            } elseif ($sortDirection == "htl") {
                $productQuery->orderBy('price', 'desc');
            }
        } elseif (isset($category)) {
            $productQuery->where('category_id', $category);
            if ($sortDirection == "discount") {
                $productQuery->orderBy('discount', 'desc');
            } elseif ($sortDirection == "lth") {
                $productQuery->orderBy('price', 'asc');
            } elseif ($sortDirection == "htl") {
                $productQuery->orderBy('price', 'desc');
            }
        }

        // Order the products
        $products = $productQuery->get();

        foreach ($products as &$product) {
            $images = explode(', ', $product->product_image);
            $productimages = asset('images/' . $images[0]);
            $product['product_image'] =  $productimages;
        }

        $formattedResponse = [
            "status" => true,
            "data" => $products,
            "totalcart" => $cartItemscount
        ];

        return response()->json($formattedResponse);

        //return response()->json(['status' => true, 'message' => 'Product Listing.', 'data' => $products], 200);
    }


    public function productDetails($id)
    {
        $product = Product::where('id', $id)->first();
        $userId = auth()->user()->id;
        $cartItemscount = Cart::where('user_id', $userId)->where('is_active', '0')->count();
        if (!$product) {
            return response()->json(['status' => false, 'message' => 'Product not found.', 'data' => null], 404);
        }

        $images = explode(', ', $product->product_image);

        $product->product_image = asset('images/' . $images[0]);

        $ratings = Rating::where('product_id', $product->id)->get();
        $averageRating = $ratings->avg('rating');

        if ($averageRating === null) {
            $averageRating = 0;
        }

        $product->rating = $averageRating;


        $formattedResponse = [
            "status" => true,
            "data" => $product,
            "totalcart" => $cartItemscount
        ];

        return response()->json($formattedResponse);

        // return response()->json(['status' => true, 'message' => 'Product Details.', 'data' => $product, "totalcart"=>$cartItemscount], 200);
    }

    public function getCategoryList(Request $request)
    {
        $sortDirection = $request->input('sort', 'asc');
        $searchTerm = $request->input('search_term');

        $productQuery = Category::where('is_active', '1');

        if ($searchTerm) {
            $productQuery->where('name', 'LIKE', '%' . $searchTerm . '%');

            // Store recent search

        }

        // Order the products
        $products = $productQuery->orderBy('name', $sortDirection)->get();

        foreach ($products as &$product) {

            $productimages = asset('images/' . $product->category_image);
            $product['category_image'] =  $productimages;
        }

        return response()->json(['status' => true, 'message' => 'Categories Listing.', 'data' => $products], 200);
    }

    public function reletedProduct($id)
    {
        $product = Product::where('id', $id)->first();
        $products = Product::where('category_id', $product->category_id)->where('is_active', '1')->get();
        foreach ($products as &$product) {
            $images = explode(', ', $product->product_image);
            $productimages = asset('images/' . $images[0]);
            $product['product_image'] =  $productimages;
        }
        return response()->json(['status' => true, 'message' => 'Categories Listing.', 'data' => $products], 200);
    }

    public function cartInsert(Request $request)
    {
        $userId = auth()->user()->id;
        $products = Product::where('id', $request->id)->where('is_active', '1')->first();
        if ($products->stock >= $request->qty) {
            Cart::updateOrCreate(
                ['product_id' => $request->id, 'user_id' => $userId, 'is_active' => '0'],
                ['quantity' => $request->qty]
            );

            $totalcart = Cart::where('user_id', $userId)->where('is_active', '0')->count();

            return response()->json(['status' => true, 'message' => 'Cart Instead Successfully..', 'data' => (object)[], 'totalcart' => $totalcart], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Currently, stock is not available.', 'data' => (object)[]], 200);
        }
    }

    public function getLocation($pinCode)
    {
        // Query the database to get location data based on the provided $pinCode.
        $pincode = Pincode::where('pin', $pinCode)->first();

        if ($pincode) {
            $state = State::where('id', $pincode->state_id)->first();
            $district = District::where('state_id', $pincode->state_id)->first();
            $data = [
                'country' => 'India',
                'state' =>  $state->name,
                'city' => $district->district,
            ];
            return response()->json(['status' => true, 'message' => 'Get Location.', 'data' => $data], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Please Enter Correct Pincode.', 'data' => (object)[]], 200);
        }
    }

    public function addAddress(Request $request)
    {
        $userId = auth()->user()->id;
        $log = new UserAddress();
        $log->user_id = $userId;
        $log->name = $request->name;
        $log->mobile_number = $request->mobile_number;
        $log->email = $request->email;
        $log->address = $request->address;
        $log->option_address = $request->option_address;
        $log->pin_code = $request->pin_code;
        $log->county = $request->county;
        $log->state = $request->state;
        $log->city = $request->city;
        // Save the log entry
        $log->save();
        $log->id;
        if ($log) {
            return response()->json(['status' => true, 'message' => 'Your Address Added Sucessfully.', 'id' => $log->id], 200);
        } else {
            return response()->json(["error" => "Error in adding address"], 406);
        }
    }

    public function editAddress(Request $request)
    {
        $userId = auth()->user()->id;
        $log = UserAddress::where('id', $request->id)->first();
        $log->user_id = $userId;
        $log->name = $request->name;
        $log->mobile_number = $request->mobile_number;
        $log->email = $request->email;
        $log->address = $request->address;
        $log->option_address = $request->option_address;
        $log->pin_code = $request->pin_code;
        $log->county = $request->county;
        $log->state = $request->state;
        $log->city = $request->city;
        // Save the log entry
        $log->save();
        if ($log) {
            return response()->json(['status' => true, 'message' => 'Your Address Updated Sucessfully.'], 200);
        } else {
            return response()->json(["error" => "Error in adding address"], 406);
        }
    }

    public function deleteAddress(Request $request, $id)
    {
        $delete = UserAddress::where('id', $id)->delete();
        if ($delete) {
            return response()->json(['status' => true, 'message' => 'User Address Deleted Sucessfully.', 'data' => (object)[]], 200);
        }
    }

    public function getAddress(Request $request)
    {
        $userId = auth()->user()->id;
        if ($request->id == "") {
            $data = UserAddress::where('user_id', $userId)->get();
        } else {
            $data = UserAddress::where('user_id', $userId)->where('id', $request->id)->get();
        }
        if ($data) {
            return response()->json(['status' => true, 'message' => 'User Address List.', 'data' => $data], 200);
        } else {
            $data = [];
            return response()->json(['status' => true, 'message' => 'user Not Found.', 'data' => (object)[]], 200);
        }
    }

    public function getCartData(Request $request)
    {
        $userId = auth()->user()->id;
        $cartItems = Cart::where('user_id', $userId)->where('is_active', '0')->get();
        $cartItemscount = Cart::where('user_id', $userId)->where('is_active', '0')->count();
        $totalAmount = 0;
        $actual_price = 0;
        $totaldiscount = 0;
        foreach ($cartItems as $cartItem) {
            $pricePerQuantity = $cartItem->product->price * $cartItem->quantity;
            $cartItem->price_per_quantity = $pricePerQuantity;
            //$totalItemAmount = $cartItem->product->price * $cartItem->quantity;
            //$totalAmount += $totalItemAmount;
            $discountvalue = $cartItem->product->price * $cartItem->product->discount / 100;
            $actual_price = $cartItem->product->price - $discountvalue;
            $discountvalue = $discountvalue * $cartItem->quantity;
            $totaldiscount += $discountvalue;
            $totalItemAmount = $actual_price * $cartItem->quantity;
            $totalAmount += $totalItemAmount;

            if ($cartItem->product->product_image != "") {
                $images = explode(',', $cartItem->product->product_image);

                $productimages = asset('images/' . $images[0]);
                $cartItem->image =  $productimages;
            } else {
                $cartItem->image =  "";
            }
        }


        $item = $this->formatCartItems($cartItems);

        // $cartItemss= UserCartDetailApiCollection::collection($cartItems);
        return response()->json(['status' => true, 'message' => 'User Address List.', 'item' => $item, 'total_price' => $totalAmount, 'save_price' => $totaldiscount, 'totalcart' => $cartItemscount], 200);
    }

    public function getShippingInfo(Request $request)
    {

        $address = UserAddress::where('id', $request->addressid)->first();
        $userId = auth()->user()->id;
        $cartItems = Cart::where('user_id', $userId)->where('is_active', '0')->get();
        $cartItemscount = Cart::where('user_id', $userId)->where('is_active', '0')->count();
        $totalAmount = 0;
        $actual_price = 0;
        $totaldiscount = 0;
        foreach ($cartItems as $cartItem) {
            $pricePerQuantity = $cartItem->product->price * $cartItem->quantity;
            $cartItem->price_per_quantity = $pricePerQuantity;
            //$totalItemAmount = $cartItem->product->price * $cartItem->quantity;
            //$totalAmount += $totalItemAmount;
            $discountvalue = $cartItem->product->price * $cartItem->product->discount / 100;
            $actual_price = $cartItem->product->price - $discountvalue;
            $discountvalue = $discountvalue * $cartItem->quantity;
            $totaldiscount += $discountvalue;
            $totalItemAmount = $actual_price * $cartItem->quantity;
            $totalAmount += $totalItemAmount;



            if ($cartItem->product->product_image != "") {
                $images = explode(', ', $cartItem->product->product_image);

                $productimages = asset('images/' . $images[0]);
                $cartItem->image =  $productimages;
            } else {
                $cartItem->image =  "";
            }
        }
        $superadmin = User::where('id', '1')->first();
        $tax = $superadmin->igst + $superadmin->cgst;
        $item = $this->formatCartItems($cartItems);
        $shipping_method = ShippingMethod::where('is_active', '1')->get();
        return response()->json(['status' => true, 'message' => 'Shipping Data.', 'address' => $address, 'shipping_method' => $shipping_method, 'item' => $item, 'total_price' => $totalAmount, 'save_price' => $totaldiscount, 'delivery_charge' => '0', 'tax' =>  $tax, 'discount' => '0'], 200);
    }

    private function formatCartItems($products)
    {
        // Format your product items here
        return $products->map(function ($product) {
            $discountvalue = $product->product->price * $product->product->discount / 100;
            $actual_price = $product->product->price - $discountvalue;
            // Modify this according to your duct model attributes
            return [
                "id" => $product->product->id,
                'qty' => $product->quantity,
                "name" => $product->product->name,
                "images" => $product->image,
                "discount" => $product->product->discount,
                'actual_price' => $product->product->price,
                "price" => $actual_price,
                "stock" => $product->product->stock,

                // Add more attributediscountvalue;s as needed
            ];
        });
    }

    public function cartRemove(Request $request, $id)
    {
        $userId = auth()->user()->id;

        $delete = Cart::where('product_id', $id)->where('user_id', $userId)->delete();
        if ($delete) {
            return response()->json(['status' => true, 'message' => 'Cart Remove Sucessfully.', 'data' => (object)[]], 200);
        }
    }

    public function addFevorite(Request $request)
    {
        $userId = auth()->user()->id;
        Favorite::updateOrCreate(
            ['product_id' => $request->id, 'user_id' => $userId],
        );
        return response()->json(['status' => true, 'message' => 'Fevorite Inseted Listing.', 'data' => (object)[]], 200);
    }

    public function getFevoriteList(Request $request)
    {
        $userId = auth()->user()->id;
        $cartItems = Favorite::where('user_id', $userId)->get();
        $cartItemscount = Favorite::where('user_id', $userId)->count();
        $item = $this->formatFevoriteItems($cartItems);
        return response()->json(['status' => true, 'message' => 'Fevorite List', 'item' => $item, 'totalcart' => $cartItemscount], 200);
    }

    private function formatFevoriteItems($products)
    {
        // Format your product items here
        return $products->map(function ($product) {
            $images = explode(', ', $product->product->product_image);
            $productimages = asset('images/' . $images[0]);

            $discountvalue = $product->product->price * $product->product->discount / 100;
            $actual_price = $product->product->price - $discountvalue;


            // Modify this according to your duct model attributes
            return [
                "id" => $product->product->id,
                "name" => $product->product->name,
                "actual_price" => $product->product->price,
                "price" => $actual_price,
                "discount" => $product->product->discount,
                "images" => $productimages,
                // Add more attributediscountvalue;s as needed
            ];
        });
    }

    public function placeOrder(Request $request)
    {
        $userId = auth()->user()->id;
        $cart = Cart::where('user_id', $userId)->where('is_active', '0')->get();
        $product_id = [];
        $cart_id = [];
        $totalAmount = 0;
        foreach ($cart as $carts) {
            $totalItemAmount = $carts->product->price * $carts->quantity;
            $totalAmount += $totalItemAmount;
            $product = product::where('id', $carts->product_id)->first();
            $product->stock = $product->stock - $carts->quantity;
            $product->save();

            $product_id[] = $carts->product_id;
            $cart_id[] = $carts->id;
        }


        $productid = json_encode($product_id);
        $cart_ids = json_encode($cart_id);

        $randomNumber = mt_rand(10000000, 99999999);

        $order = new Order();
        $order->order_id = $randomNumber;
        $order->user_id = $userId;
        $order->product_details = $productid; // Replace with actual product details
        $order->payment_type =  $request->method;
        $order->item =  $request->item;
        $order->discount =  $request->discount;
        $order->coupon =  $request->coupon;
        $order->gst =  $request->gst;
        $order->address_id =  $request->address_id;
        $order->total_amount =  $request->total;
        $order->cart_id =  $cart_ids;
        $order->delivery_status =  $request->status;
        $order->save();
        if ($order) {
            $updatedRows = Cart::whereIn('id', $cart_id)->update(['is_active' => '1']);
        }
        return response()->json(['status' => true, 'message' => 'Order Place Sucessfully', 'orderid' => $randomNumber], 200);
    }

    public function fevoritelistRemove(Request $request, $id)
    {
        $userId = auth()->user()->id;
        $delete = Favorite::where('product_id', $id)->where('user_id', $userId)->delete();
        if ($delete) {
            return response()->json(['status' => true, 'message' => 'Favorite Item Remove Sucessfully.', 'data' => (object)[]], 200);
        }
    }

    public function couponValidate(Request $request)
    {
        $userId = auth()->user()->id;
        $currentDateTime = Carbon::now();
        $coupon = Coupon::where('coupon_code', $request->coupons)
            ->where('ended_at', '>=', $currentDateTime)
            ->first();
        if ($coupon) {
            $count = Order::where('user_id', $userId)->where('coupon', $request->coupons)->count();
            if ($count == 0) {
                return response()->json(['status' => true, 'message' => 'Coupon Validate Successfully.', 'discount' => $coupon->coupon_discount, 'coupon' => $request->coupons, 'type' => $coupon->type], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Coupon is already Use', 'data' => (object)[]], 200);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Invalid Coupon.', 'data' => (object)[]], 200);
        }
    }

    public function orderList(Request $request)
    {
        $user = User::where('id', '1')->first();
        $gst = $user->igst + $user->cgst;
        $userId = auth()->user()->id;
        if ($request->id == "") {
            $orders = Order::where('user_id', $userId)->get();
            $data = [];

            foreach ($orders as $order) {
                $address = UserAddress::where('id', $order->address_id)->first();
                $shipping_method = ShippingMethod::where('id', $order->payment_type)->where('is_active', '1')->first();
                $cartid = json_decode($order->cart_id);
                $cartdata = Cart::whereIn('id', $cartid)->where('is_active', '1')->get();

                foreach ($cartdata as $cartItem) {
                    if ($cartItem->product->product_image != "") {
                        $images = explode(',', $cartItem->product->product_image);
                        $productimages = asset('images/' . $images[0]);
                        $cartItem->image = $productimages;
                    } else {
                        $cartItem->image = "";
                    }
                }

                $item = $this->formatCartItems($cartdata);
                $coupon = Coupon::where('coupon_code', $order->coupon)->first();
                $type = ($coupon) ? $coupon->type : "";

                $status = ($order->delivery_status == 0) ? "Pending" : "Delivered";

                $data[] = [
                    'address' => $address,
                    'shipping_method' => $shipping_method ? $shipping_method->type : null,
                    'item' => $item,
                    'total_price' => $order->total_amount,
                    'item_price' => $order->item,
                    'delivery_charge' => '0',
                    'gst' => $order->gst,
                    'discount' => $order->discount,
                    'order_id' => $order->order_id,
                    'coupon' => $order->coupon,
                    'type' => $type,
                    'delivery_status' => $status,
                    'id' => $order->id,
                    'gst_per' => $gst
                ];
            }

            $response = [
                'status' => true,
                'message' => 'Order List.',
                'data' => $data
            ];

            return response()->json($response, 200);
        } else {

            $order = Order::where('id', $request->id)->first();
            $address = UserAddress::where('id', $order->address_id)->first();
            $shipping_method = ShippingMethod::where('id', $order->payment_type)->where('is_active', '1')->first();
            $cartid = json_decode($order->cart_id);

            $cartdata = Cart::whereIn('id', $cartid)->where('is_active', '1')->get();
            foreach ($cartdata as $cartItem) {
                if ($cartItem->product->product_image != "") {
                    $images = explode(',', $cartItem->product->product_image);

                    $productimages = asset('images/' . $images[0]);
                    $cartItem->image =  $productimages;
                } else {
                    $cartItem->image =  "";
                }
            }




            $item = $this->formatCartItems($cartdata);
            $coupon = Coupon::where('coupon_code', $order->coupon)->first();
            if ($coupon) {
                $type = $coupon->type;
            } else {
                $type = "";
            }


            if ($order->delivery_status  == 0) {
                $status = "Pending";
            } else if ($order->delivery_status  == 1) {
                $status = "delivered";
            }






            // return response()->json(['status' => true, 'message' => 'Shipping Data.', 'address' => $address, 'shipping_method' => $shipping_method->type, 'item' => $item, 'total_price' =>  $order->total_amount,  'delivery_charge' => '0', 'gst' =>  $order->gst, 'discount' => $order->discount], 200);
            $data = ['id' => $order->id, 'address' => $address, 'shipping_method' => $shipping_method->type, 'item' => $item, 'total_price' =>  $order->total_amount, 'item_price' => $order->item, 'delivery_charge' => '0', 'gst' =>  $order->gst, 'discount' => $order->discount, 'order_id' => $order->order_id, 'coupon' => $order->coupon, 'type' => $type, 'delivery_status' => $status, 'gst_per' => $gst];
            return response()->json(['status' => true, 'message' => 'Order Data.', 'data' => $data], 200);
        }
    }

    public function addRating(Request $request)
    {
        $userId = auth()->user()->id;
        $request->validate([
            'product_id' => 'required|numeric',
            'rating' => 'required|numeric|min:1|max:5', // Assuming ratings are between 1 and 5
        ]);

        // Create a new rating record
        $rating = Rating::create([
            'user_id' => $userId,
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'description' => $request->description,
        ]);
        // You can return a response or redirect as needed
        return response()->json(['status' => true, 'message' => 'Rating inserted successfully', 'data' => $rating], 200);
    }
}
