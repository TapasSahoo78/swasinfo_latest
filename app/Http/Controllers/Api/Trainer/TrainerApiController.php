<?php

namespace App\Http\Controllers\Api\Trainer;

use App\Models\TrainerCustomerRequest;
use random;
use App\Models\Workout;
// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrainerDetail;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\BaseController;
use App\Services\Trainer\TrainerService;
use App\Services\Role\RoleService;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Api\Trainer\TrainerDetailApiCollection;
use Illuminate\Support\Facades\Mail;
use App\Services\User\UserService;
use App\Models\Diet;
use App\Models\User;
use App\Models\UserTrack;
use App\Models\Notification;
use App\Http\Resources\Api\Customer\UserDetailApiCollection;
use App\Http\Resources\Api\Customer\WorkoutPlanApiCollection;
use App\Http\Resources\Api\Customer\UserTrainerDetailApiCollection;
use App\Http\Resources\Api\Customer\FoodApiCollection;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use Carbon\Carbon;
use App\Models\UserFoodItemDetail;
use App\Http\Resources\Api\Customer\DietApiCollection;
use App\Models\Food;
use App\Models\UserFootitem;
use App\Models\UserWorkoutItem;
use App\Models\LiveSession;
use App\Models\ProfileQuestion;
use App\Models\WorkoutDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class TrainerApiController extends BaseController
{

    protected $trainerService;
    protected $roleService;
    protected $roleModel;
    protected $userService;
    public function __construct(TrainerService $trainerService, UserService $userService, RoleService $roleService, Role $roleModel)
    {
        $this->trainerService = $trainerService;
        $this->userService    = $userService;
        $this->roleService    = $roleService;
        $this->roleModel        = $roleModel;
    }

    public function signup(Request $request)
    {

        $validator = Validator::make($request->all(), [
            // 'first_name' => 'required|string|min:2|max:30',
            // 'last_name' => 'required|string|min:2|max:30',
            'email' => 'required|unique:users,email',
            'mobile_number' => 'required|unique:users,mobile_number',
            'password' => 'required|string|min:6',
            // 'username' => 'required|nullable|string',
            // 'is_email' => 'required|boolean'
            'role' => 'required|in:trainer,dietitian,gym-trainer'
        ]);

        if ($validator->fails()) {
            $error = ['error' => $validator->errors()->all()];
            return $this->responseJson(false, 200, $validator->errors()->first(), "");
        }
        try {
            $otp = genrateOtp(4);
            $request->merge(['is_email' => 0]);
            if ($request->is_email) {
                $request->merge(['email' => $request->email]);
                $userFound = $this->trainerService->findUserByEmail($request->email);
                $data = [
                    'otp' => $otp,
                ];
                $user = $request->email;
                Mail::send('email.otpverification', $data, function ($message) use ($user) {
                    $message->to($user);
                    $message->subject('Your OTP Verification Code');
                });
            } else {
                $request->merge(['mobile_number' => $request->mobile_number]);
                $userFound = $this->trainerService->findUserByMobile($request->mobile_number);
            }

            // if (!empty($userFound)) {
            //     return $this->responseJson(false, 200, "You have already registered", "");
            // };

            $request->merge(['verification_code' => $otp]);
            $request->merge(['password' => $request->password]);
            $request->merge(['username' => rand()]);

            $userExist = $this->trainerService->createOrUpdateCustomer($request->except('_token'), $userFound?->id ?? NULL);

            if ($userExist) {
                $userData = ['otp' => $otp];
                $message = "OTP send successfully !!";
                return $this->responseJson(true, 200, $message, $userData);
            } else {
                $message = "user not found";
                return $this->responseJson(false, 401, $message, "");
            }
        } catch (\Exception $e) {
            return $this->responseJson(false, 500, $e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
        }
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
            $userFound = $this->trainerService->findUserByEmail($request->username);
        } else {
            $request->merge(['mobile_number' => $request->username]);
            $userFound = $this->trainerService->findUserByMobile($request->username);
        }
        if (is_null($userFound)) {
            return $this->responseJson(false, 200, "User Not Found", "");
        }

        $otpupdate = User::where('id', $userFound->id)->update([
            'fcm_token' => $request->fcm_token,
            'otp_verify' => 1
        ]);
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

    public function customerRequestList(Request $request)
    {
        /* $filterConditionsUsers = [
            'mfi_id' => auth()->user()->mfi_id,
        ]; */
        // $if($request->page){

        // }
        //$trainerList = User::where('is_active', 1)->get();
        //$listCustomers = $this->userService->listCustomers($filterConditionsUsers, 'id', 'asc');
        // return json_encode($listCustomers[0]->mediaImage);

        $customers = TrainerCustomerRequest::where('trainer_id', auth()->user()->id)->with('customerRequest')->get();
        return $this->responseJson(true, 200, "", $customers);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6',
            'username' => 'required|nullable|string',
            'is_email' => 'required|boolean'
        ]);
        if ($validator->fails()) {
            $error = ['error' => $validator->errors()->all()];
            return $this->responseJson(false, 200, $validator->errors()->first(), "");
        }
        $otp = genrateOtp(4);
        if ($request->is_email) {
            $loginParam = ['email' => $request->username];
            $data = [
                'otp' => $otp,
            ];
            $user = $request->username;
            // Mail::send('email.otpverification', $data, function ($message) use ($user) {
            //     $message->to($user);
            //     $message->subject('Your OTP Verification Code');
            // });
        } else {
            $loginParam = ['mobile_number' => $request->username];
        }
        $loginParam['password'] = $request->password;
        if (auth()->attempt($loginParam)) {
            //$otp = genrateOtp(4);
            $user = auth()->user();
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
            $userFound = $this->trainerService->findUserByEmail($request->username);
        } else {
            $request->merge(['mobile_number' => $request->username]);
            $userFound = $this->trainerService->findUserByMobile($request->username);
        }
        if (is_null($userFound)) {
            return $this->responseJson(false, 200, "User Not Found", "");
        }
        //return $userFound;
        if ($request->otp != $userFound->verification_code) {
            return $this->responseJson(false, 200, "OTP not matched", "");
        } else {
            $userFound->access_token = $userFound->createToken('LaravelAuthApp')->accessToken;
            $userData = [
                'otp_matched' => true,
                'role' => User::where('id',$userFound?->id)->first()->roles->first(),
                'user_details' => $userFound
            ];
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
        $otp = genrateOtp(4);
        if ($request->is_email) {

            $request->merge(['email' => $request->username]);
            $userFound = $this->trainerService->findUserByEmail($request->username);
            $data = [
                'otp' => $otp,
            ];
            $user = $request->username;
            Mail::send('email.otpverification', $data, function ($message) use ($user) {
                $message->to($user);
                $message->subject('Your OTP Verification Code');
            });
        } else {
            $request->merge(['mobile_number' => $request->username]);
            $userFound = $this->trainerService->findUserByMobile($request->username);
        }
        if (is_null($userFound)) {
            return $this->responseJson(false, 200, "User Not Found", "");
        }
        //return $userFound;

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
            'verification_code' => 'required|min:4|string',
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
            $userFound = $this->trainerService->findUserByEmail($request->username);
        } else {
            $request->merge(['mobile_number' => $request->username]);
            $userFound = $this->trainerService->findUserByMobile($request->username);
        }
        if (is_null($userFound)) {
            return $this->responseJson(false, 200, "User Not Found", "");
        }

        if ($request->verification_code != $userFound->verification_code) {
            return $this->responseJson(false, 200, "OTP not matched", "");
        }

        /* $otp = genrateOtp(4); */
        $otpupdate =  $this->trainerService->saveUserProfileDetails([
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
            'age' => 'nullable|numeric|min:1',

            'preffered_language' => 'nullable|string',
            'expertise' => 'nullable',
            'qualification_name' => 'nullable|string',

            'intro' => 'nullable|string',
            'ac_no' => 'nullable|numeric|min:9999999',
            'reenter_ac_no' => 'nullable|numeric|min:9999999|same:ac_no',
            'ifsc_code' => 'nullable|string',
            'bank_name' => 'nullable|string',

        ]);
        if ($validator->fails()) {
            $error = ['error' => $validator->errors()->all()];
            return $this->responseJson(false, 200, $validator->errors()->first(), "");
        }
        $guidance = is_array($request->guidance) ? $request->guidance : explode(",", $request->guidance);
        $request->merge(['guidance' => $guidance]);
        $userData =  $this->trainerService->updateOrCreateProfile($request->all(), $userId);


        try {

            $base64Image_for_profile = "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";
            $base64Image_for_qualification = "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";
            $base64Image_for_bank_cheque = "iVBORw0KGgoAAAANSUhEUgAAAHgAAAB4CAMAAAAOusbgAAABBVBMVEVPk//////606ElJkcxbP/3vo9Qlf9Djv8jIT9IgNv/2qVKkf/4yJhhnf/L3f/O3//3+v/m7v+Wu/+hiXelxf88i/9/rv/b5///1ptSmf+91P9yp//h6//w9f+QuP+fwf/0sI0lZv8HE0EAADkiGzYWG0QAAD4bH0X/wYYAWv85dv8ADkBSSVbvyps3M033uYZEd8xLieszTolpW1/XtpDKq4rJsLbiwZaskny3m4HouJqIdWybpdrQsrC1q8aCnOXHucKrstaKpOTtzqv78OJWg/9ijP/61Lj85dJylf+Cov+Vsf8/bLkuQXQgESg4Wp4pMVscAA53ZmTjrYLdxrbAwNv4yaXfY6kbAAAH/UlEQVRogbWb60LiOhCAyy3VlgJFKLaICgpIFfGyruy6e3RXcVfFy3H3+P6PcpK2QNOmmamX+SMtMR8zmUynyUTJpBaz7NSqVtOwFcU2mla15pTN9L0oqVqvOVVDV6nouq54Qj9410bVWfsgcKu0blNIAIwK+8ZeL7XeG1wpW3YiNAS3rXLlHcHmhlEHoHN43dhAjTgC3LB0FUf1RdWtxjuAG02ssmG1myAaAJtWeqyPtgCDS8GV6uuwProqdTMZ2CGpxjYqKnFeBW5Z0PQBlVat5HmdCC69Td2Z0qW04Fr97Vgm9VoqcMV6Jy4lW2IfE4JN4x3MPBPVEE4sEbihvNGreNEVUTQRgMtv9eYYWS1jwKV3NPNM1Lhzx8DlD+BSckznKLjxIVxKjo5zBGy+r18tRFdMGbhiYLkkEO6OlGxUJGALY2hCbHJ4MJ1OD5YPFfrZttkdmxxIwYpqJYMxcZLYh9P77YdtJg8P27n7o8fH6ePj0dP2v1Nb+p989AyDSzCX2NOnh6Wl3EKWAqGfjuRgpV4Sg1tyU3nYg6ftMJUTEKyQlhAMDrB9eJ+MpeBHCBwe5gXYAbnTnASby21PQZOpThxcIfKZRMjjtgxLwYcgWCeVGLgqV5iQe4Cbyy1DpqYqV6NgU+7RxIa5S0sHMLluRsCW3NAILjM26F6KbvHghlxh+wjDpWRwRin1BgduShW2pzguJd9DZL0ZBssVJofSaZRS50BlBTHC5AgPhsc5GGUPbMq5yym4lAw8pRTdnIM3pHPYTqMwlScgkKgbM3DFkCp8mAqLMLaXEjBwWe5aB1iXngugcr0cgOWuZT+mszT8fPTci4Jb8mb2U1owqLLd8sBABk9SY0HHZvk9Ba9LwWjf6i4+QrZW1z2wLX8+4GZx7/S4s7h6AgbZZuA1IAFAgbvPmrYSIstzbEVfo2Ag5cGBO8NsVvvS78+uoRjiUDCUemDAuytalpJP93f966VlaZ8sEVEywFsLBtw5ZlyGPusFYMDUBgUDb0seuC/ldveyM9G+9DBgRc8oJpDVMnD/WYbu7A2zC/Kn/S4CrJoK9CLOwJ3xaXia8tI7DnEpeXjcR4DLCpTHe+AVbbi3K8T2OytZXti0gsGOUsOBs9p4vxOzd7+z90l7FbimVBHOxcBZLTve3+UM3t3dO4likWC9qgAJ9QJMu9ROznJbvU6XSqe3lTv7pMW5SLClyBNbDuyxhyfjlbOzs/HJUERFg5uKNO3xwd2tlRDD54mhPnirA4IpFnyZXl46+1pMxAik+GdlHwTbCtRCP/9TKITA2jCurZYdhu4VC4U/59DqEQHBRqHAgZ/3Y66sneztP3PgQgEcQcjU6udRGKw97+b63VMefNrt53aftTB49BkIDzbkXPqI13iLzt+tMaeyNvZu8hqPAFsb0HQiOzyYBc7eF15j74m0y4N3gOdiEwwgPJhq1+3tZSOy1+uGrOCD5b3SAAKETPUrrzENXuMoN5sdn4UczgN/lY8xDZnAQ0L/tsN7tSYMkxo/nQo73wB9auBjUf++w4FhoeCd78AA0sciuCKv/1MYpQOPCv9A8YMmAlDqwzKz84tVPHf14hxe9aapD5Tsec1+pAH/QCx663B66zVLB0Z0aMAJ/YeAvYQeXLWl4J8iMJuuIvBPBNiBX9o8sCHUWMjNrkI5jRK8tEGvqUzIJd7Ul+DicfCaCryY+y1TzKcLhKXXMUsRHlg4yEJZBYKlBy5hFl98MveaUtwsJlxQQcSFYPEFWqv2wNyEKm5uLi42OTBqFluoBTZfVE6r4pxW5LlZDRG25gts8iXF4Ffyo0x5m0UqmxEuZoQXS4rAImqgcsSxC5ue8FN59S+mpw3ksnEg5DLi2Uxj/k72ErMbG1o2xrgXDV9RclzAPF7hF8qhvZDgP5oAeYjh8lsDwGbIjGz8lZBXL3GdcJshOJUVPephYe6FjuFGt39Qo0xFPRebe/XyJ66qIbrhBW3xzYSQ+g8thl7V/qvDzyRPYlt8mEREIerEHTQyV0OeO7zKNAbuREWw45ua4DYu+7Vungpt+4tm2rOQSbPoX/QW+8YFrSbaxgVTIB/bnvjgsDDwpO2jwVXbOFi+Va+7Xs/59o0YfBN87Uq5wq16WXECqednci0GX88bSOydUJyQXI5BAnU9a9KGv0dh7ug3veXOG7TdJAWSyjGSClCIng/JgLkHrzFzzUGoiSt20+QCFPEwh8zsKVSLqOwpXGtzjUQ+Jiu5ERUZRbj5NhvkzMucPHph19c8WECWFxnFy6qiXGprJ0weMc/KOINoq+igAWVVsUIyokZ7pEPodXH1wrgvV97PdeOtIgpAhWSx0rl4jzSGBLPi6sr/25q0Bc14Llg6x+f3RKAKI3NmM4XcfHhWYYoFw+WRRNxlvt3eWDTfaCc0mjsYsjwyVBCqC3v00XeOWamYzl0ClsmsF2xB6KIEVmjoOdoXSRPf2ClKYGdFv3VZrxjxOklT9Jvxo6dMYZRQlVOWOWdYYXcsdLxC5fSF3XR2Gm+1dL5tvKKUnUot/yZ0O59kZgicad0OXo1uD26lJ3KgAxrXsfCPk8H1Ww5oMClN0mvdHkwSnQoNpugbaZiIY9s3IBZ57GjNcrFqtweuhTrqhTxo1XJu8rDetMWNgzzkhT9aZjo3riQ206/cGwd/qi7dYbpG7daNPhv8a/e2hjhd9Wowk0rDqd3dXk+8SO5Orm/vak4DeZAtJP8Dburae/Vw71QAAAAASUVORK5CYII=";
            $base64Image_for_id_proof = "iVBORw0KGgoAAAANSUhEUgAAAHgAAAB4CAMAAAAOusbgAAABBVBMVEVPk//////606ElJkcxbP/3vo9Qlf9Djv8jIT9IgNv/2qVKkf/4yJhhnf/L3f/O3//3+v/m7v+Wu/+hiXelxf88i/9/rv/b5///1ptSmf+91P9yp//h6//w9f+QuP+fwf/0sI0lZv8HE0EAADkiGzYWG0QAAD4bH0X/wYYAWv85dv8ADkBSSVbvyps3M033uYZEd8xLieszTolpW1/XtpDKq4rJsLbiwZaskny3m4HouJqIdWybpdrQsrC1q8aCnOXHucKrstaKpOTtzqv78OJWg/9ijP/61Lj85dJylf+Cov+Vsf8/bLkuQXQgESg4Wp4pMVscAA53ZmTjrYLdxrbAwNv4yaXfY6kbAAAH/UlEQVRogbWb60LiOhCAyy3VlgJFKLaICgpIFfGyruy6e3RXcVfFy3H3+P6PcpK2QNOmmamX+SMtMR8zmUynyUTJpBaz7NSqVtOwFcU2mla15pTN9L0oqVqvOVVDV6nouq54Qj9410bVWfsgcKu0blNIAIwK+8ZeL7XeG1wpW3YiNAS3rXLlHcHmhlEHoHN43dhAjTgC3LB0FUf1RdWtxjuAG02ssmG1myAaAJtWeqyPtgCDS8GV6uuwProqdTMZ2CGpxjYqKnFeBW5Z0PQBlVat5HmdCC69Td2Z0qW04Fr97Vgm9VoqcMV6Jy4lW2IfE4JN4x3MPBPVEE4sEbihvNGreNEVUTQRgMtv9eYYWS1jwKV3NPNM1Lhzx8DlD+BSckznKLjxIVxKjo5zBGy+r18tRFdMGbhiYLkkEO6OlGxUJGALY2hCbHJ4MJ1OD5YPFfrZttkdmxxIwYpqJYMxcZLYh9P77YdtJg8P27n7o8fH6ePj0dP2v1Nb+p989AyDSzCX2NOnh6Wl3EKWAqGfjuRgpV4Sg1tyU3nYg6ftMJUTEKyQlhAMDrB9eJ+MpeBHCBwe5gXYAbnTnASby21PQZOpThxcIfKZRMjjtgxLwYcgWCeVGLgqV5iQe4Cbyy1DpqYqV6NgU+7RxIa5S0sHMLluRsCW3NAILjM26F6KbvHghlxh+wjDpWRwRin1BgduShW2pzguJd9DZL0ZBssVJofSaZRS50BlBTHC5AgPhsc5GGUPbMq5yym4lAw8pRTdnIM3pHPYTqMwlScgkKgbM3DFkCp8mAqLMLaXEjBwWe5aB1iXngugcr0cgOWuZT+mszT8fPTci4Jb8mb2U1owqLLd8sBABk9SY0HHZvk9Ba9LwWjf6i4+QrZW1z2wLX8+4GZx7/S4s7h6AgbZZuA1IAFAgbvPmrYSIstzbEVfo2Ag5cGBO8NsVvvS78+uoRjiUDCUemDAuytalpJP93f966VlaZ8sEVEywFsLBtw5ZlyGPusFYMDUBgUDb0seuC/ldveyM9G+9DBgRc8oJpDVMnD/WYbu7A2zC/Kn/S4CrJoK9CLOwJ3xaXia8tI7DnEpeXjcR4DLCpTHe+AVbbi3K8T2OytZXti0gsGOUsOBs9p4vxOzd7+z90l7FbimVBHOxcBZLTve3+UM3t3dO4likWC9qgAJ9QJMu9ROznJbvU6XSqe3lTv7pMW5SLClyBNbDuyxhyfjlbOzs/HJUERFg5uKNO3xwd2tlRDD54mhPnirA4IpFnyZXl46+1pMxAik+GdlHwTbCtRCP/9TKITA2jCurZYdhu4VC4U/59DqEQHBRqHAgZ/3Y66sneztP3PgQgEcQcjU6udRGKw97+b63VMefNrt53aftTB49BkIDzbkXPqI13iLzt+tMaeyNvZu8hqPAFsb0HQiOzyYBc7eF15j74m0y4N3gOdiEwwgPJhq1+3tZSOy1+uGrOCD5b3SAAKETPUrrzENXuMoN5sdn4UczgN/lY8xDZnAQ0L/tsN7tSYMkxo/nQo73wB9auBjUf++w4FhoeCd78AA0sciuCKv/1MYpQOPCv9A8YMmAlDqwzKz84tVPHf14hxe9aapD5Tsec1+pAH/QCx663B66zVLB0Z0aMAJ/YeAvYQeXLWl4J8iMJuuIvBPBNiBX9o8sCHUWMjNrkI5jRK8tEGvqUzIJd7Ul+DicfCaCryY+y1TzKcLhKXXMUsRHlg4yEJZBYKlBy5hFl98MveaUtwsJlxQQcSFYPEFWqv2wNyEKm5uLi42OTBqFluoBTZfVE6r4pxW5LlZDRG25gts8iXF4Ffyo0x5m0UqmxEuZoQXS4rAImqgcsSxC5ue8FN59S+mpw3ksnEg5DLi2Uxj/k72ErMbG1o2xrgXDV9RclzAPF7hF8qhvZDgP5oAeYjh8lsDwGbIjGz8lZBXL3GdcJshOJUVPephYe6FjuFGt39Qo0xFPRebe/XyJ66qIbrhBW3xzYSQ+g8thl7V/qvDzyRPYlt8mEREIerEHTQyV0OeO7zKNAbuREWw45ua4DYu+7Vungpt+4tm2rOQSbPoX/QW+8YFrSbaxgVTIB/bnvjgsDDwpO2jwVXbOFi+Va+7Xs/59o0YfBN87Uq5wq16WXECqednci0GX88bSOydUJyQXI5BAnU9a9KGv0dh7ug3veXOG7TdJAWSyjGSClCIng/JgLkHrzFzzUGoiSt20+QCFPEwh8zsKVSLqOwpXGtzjUQ+Jiu5ERUZRbj5NhvkzMucPHph19c8WECWFxnFy6qiXGprJ0weMc/KOINoq+igAWVVsUIyokZ7pEPodXH1wrgvV97PdeOtIgpAhWSx0rl4jzSGBLPi6sr/25q0Bc14Llg6x+f3RKAKI3NmM4XcfHhWYYoFw+WRRNxlvt3eWDTfaCc0mjsYsjwyVBCqC3v00XeOWamYzl0ClsmsF2xB6KIEVmjoOdoXSRPf2ClKYGdFv3VZrxjxOklT9Jvxo6dMYZRQlVOWOWdYYXcsdLxC5fSF3XR2Gm+1dL5tvKKUnUot/yZ0O59kZgicad0OXo1uD26lJ3KgAxrXsfCPk8H1Ww5oMClN0mvdHkwSnQoNpugbaZiIY9s3IBZ57GjNcrFqtweuhTrqhTxo1XJu8rDetMWNgzzkhT9aZjo3riQ206/cGwd/qi7dYbpG7daNPhv8a/e2hjhd9Wowk0rDqd3dXk+8SO5Orm/vak4DeZAtJP8Dburae/Vw71QAAAAASUVORK5CYII=";

            //$base64Image_for_id_proof="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";


            $base64Image_for_profile = $request->base64Image_for_profile;
            $base64Image_for_qualification = $request->base64Image_for_qualification;
            $base64Image_for_bank_cheque = $request->base64Image_for_bank_cheque;
            $base64Image_for_id_proof = $request->base64Image_for_id_proof;

            $slot_selectjson = json_encode($request->slot_select);

            //dd($base64Image_for_id_proof);





            $decodedImage_for_profile = base64_decode($base64Image_for_profile);
            $decodedImage_for_qualification = base64_decode($base64Image_for_qualification);
            $decodedImage_for_bank_cheque = base64_decode($base64Image_for_bank_cheque);
            $decodedImage_for_id_proof = base64_decode($base64Image_for_id_proof);

            $fileName = uniqid() . '.jpeg';
            $fileNameQualification = uniqid() . '.jpeg';
            $fileNameBankCheque = uniqid() . '.jpeg';
            $fileNameIdProof = uniqid() . '.jpeg';


            file_put_contents(public_path('profile_picture/' . $fileName), $decodedImage_for_profile);
            file_put_contents(public_path('qualification/' . $fileNameQualification), $decodedImage_for_qualification);
            file_put_contents(public_path('bankcheque/' . $fileNameBankCheque), $decodedImage_for_bank_cheque);
            file_put_contents(public_path('id_proof/' . $fileNameIdProof), $decodedImage_for_id_proof);

            //$imageUrl = url('invoices/' . $fileName);

            $loggedInTrainer = auth()->user();
            //dd($loggedInTrainer->id);
            $count = TrainerDetail::where('user_id', $userId)->count();
            if ($count == "0") {
                $trainer_detail = new TrainerDetail;
                $trainer_detail->user_id = $loggedInTrainer->id;
                $trainer_detail->name = $request->name;
                $trainer_detail->gender = $request->gender;
                $trainer_detail->age = $request->age;

                $trainer_detail->preffered_language = $request->preffered_language;
                $trainer_detail->expertise = $request->expertise;
                $trainer_detail->qualification_name = $request->qualification_name;
                $trainer_detail->intro = $request->intro;
                $trainer_detail->ac_no = $request->ac_no;
                $trainer_detail->reenter_ac_no = $request->reenter_ac_no;
                $trainer_detail->slot_select = $request->slot_select;
                $trainer_detail->preffered_language = $request->preferred_language;
                $trainer_detail->experience = $request->experience;
                $trainer_detail->ifsc_code = $request->ifsc_code;
                $trainer_detail->bank_name = $request->bank_name;

                $trainer_detail->profile_picture_file = $fileName;
                $trainer_detail->qualification_file = $fileNameQualification;
                $trainer_detail->bank_check_file = $fileNameBankCheque;
                $trainer_detail->id_proof_file = $fileNameIdProof;
                //$trainer_detail->id_proof_file=$request->guidance;
                $trainer_detail->slot_select = $slot_selectjson;
                $trainer_detail->save();
            }
            $imageUrl = url('profile_picture/' . $fileName);
            $qualification_url = url('qualification/' . $fileNameQualification);
            $bank_cheque_url = url('bankcheque/' . $fileNameBankCheque);
            $id_proof_url = url('id_proof/' . $fileNameIdProof);

            //return response()->json(['id_proof_url' => $id_proof_url], 201);
            // $requestparam = (object)array(
            //     'body' => 'Your Otp Verify Sucessfully',
            //     'title' => 'Swasthfit'
            // );
            // $fcm =  auth()->user()->fcm_token;
            // $this->sendNotificationtest($requestparam, $fcm);

            //


            $notification = new Notification;
            $notification->trainer_id = $userId;
            $notification->massage = "Create Profile Add Successfully.";
            $notification->save();



            if ($userData) {
                $trainerdetails = TrainerDetail::where('user_id', $userId)->first();

                if ($userData) {
                    return $this->responseJson(true, 200, "Profile Data", ['name_prefix' => $userData->name_prefix, 'name' => $userData->first_name, 'gender' => $trainerdetails->gender, 'age' => $trainerdetails->age, 'preffered_language' => $trainerdetails->preffered_language, 'expertise' => $trainerdetails->expertise, 'qualification_name ' => $trainerdetails->qualification_name, 'intro ' => $trainerdetails->intro, 'type ' => $userData->type, 'experience ' => $trainerdetails->experience, 'ac_no ' => $trainerdetails->ac_no, 'reenter_ac_no ' => $trainerdetails->reenter_ac_no, 'slot' => !empty($trainerdetails->slot_select) ? json_decode($trainerdetails->slot_select, true) : [], 'bank_name' => $trainerdetails->bank_name, 'ifsc_code' => $trainerdetails->ifsc_code, 'profile_picture_url' => $imageUrl, 'qualification_url' => $qualification_url, 'bank_cheque_url' => $bank_cheque_url, 'id_proof_url' => $id_proof_url, 'is_profile_completed' => $userData->is_profile_completed]);
                }
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage() . '/' . $th->getLine() . '/' . $th->getFile(), 'data' => (object)[]], 500);
        }
    }

    public function getBankList()
    {
        $toReturn = [
            'banks' => getBank(),

        ];
        return $this->responseJson(true, 200, "", $toReturn);
    }

    public function customerCallRequestList(Request $request)
    {
        // $user = auth()->user();
        $message = "User Details Fetched Successfully !!";
        $userData = TrainerCustomerRequest::where('trainer_id', auth()->user()->id)->with('customerRequest')->get();
        return $this->responseJson(true, 200, $message, $userData);
    }


    public function flogin(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|min:6',
        ]);
        if ($request->facebook_id) {
            $userFound = $this->trainerService->findUserByFacebook($request->facebook_id);
        } else if ($request->googleplus_id) {
            $userFound = $this->trainerService->findUserByGoogle($request->googleplus_id);
        }
        if (empty($userFound)) {
            if ($validator->fails()) {
                $error = ['error' => $validator->errors()->all()];
                return $this->responseJson(false, 200, $validator->errors()->first(), "");
            }
            $request->merge(['email' => $request->username]);


            $userFound = $this->trainerService->createOrUpdatefaceCustomer($request->except('_token'), $userFound?->id ?? NULL);

            $id = $userFound->id;
            $userFound->access_token = $userFound->createToken('LaravelAuthApp')->accessToken;
        } else {
            $request->merge(['email' => $request->username]);
            $userFound = $this->trainerService->findUserByEmail($request->username);
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


    public function notification(Request $request)
    {
        $userId = auth()->user()->id;

        $data = Notification::where('trainer_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        return response()->json(['status' => true, 'message' => 'Notification Listing.', 'data' => $data], 200);
    }


    public function userDetails(Request $request)
    {
        $user = auth()->user()->id;
        $users = User::where('id', $user)->with('userItemFoodDetails')->first();
        $message = "Trainee Details Fetched Successfully !!";
        $userData = new UserDetailApiCollection($users);
        return $this->responseJson(true, 200, $message, $userData);
    }

    public function userDetailsv2(Request $request)
    {
        $user = auth()->user()->id;

        $userData = User::where('id', $user)->first();
        $trainerdetails = TrainerDetail::where('user_id', $user)->first();
        $fileName = $trainerdetails->profile_picture_file;
        $fileNameQualification = $trainerdetails->qualification_file;
        $fileNameBankCheque = $trainerdetails->bank_check_file;
        $fileNameIdProof = $trainerdetails->id_proof_file;
        $imageUrl = url('profile_picture/' . $fileName);
        $qualification_url = url('qualification/' . $fileNameQualification);
        $bank_cheque_url = url('bankcheque/' . $fileNameBankCheque);
        $id_proof_url = url('id_proof/' . $fileNameIdProof);

        $imageUrl =   url('uploads/' . $trainerdetails->profile_photo);
        $trans_photo_one = url('uploads/' . $trainerdetails->trans_photo_one);
        $trans_photo_two = url('uploads/' . $trainerdetails->trans_photo_two);
        $trans_photo_three = url('uploads/' . $trainerdetails->trans_photo_three);
        $trans_photo_four = url('uploads/' . $trainerdetails->trans_photo_four);
        $trans_photo_five = url('uploads/' . $trainerdetails->trans_photo_five);

        //return response()->json(['id_proof_url' => $id_proof_url], 201);

        if ($userData) {
            return $this->responseJson(true, 200, "Profile Data", [
                'first_name' => $userData->first_name,
                'last_name' => $userData->last_name,
                'expertise' => $trainerdetails->expertise,
                'experience ' => $trainerdetails->experience,
                'ac_no ' => $trainerdetails->ac_no,
                'reenter_ac_no ' => $trainerdetails->reenter_ac_no,
                // 'slot' => !empty($trainerdetails->slot_select) ? json_decode($trainerdetails->slot_select, true) : [],
                'bank_name' => $trainerdetails->bank_name,
                'ifsc_code' => $trainerdetails->ifsc_code,

                'gender' => $trainerdetails->gender,
                'age' => $trainerdetails->age,
                'preffered_language' => $trainerdetails->preffered_language,
                'qualification_name' => $trainerdetails->qualification_name,

                'profile_picture_url' => $imageUrl,

                'address' => $trainerdetails->address,
                'trans_photo_one' => $trans_photo_one,
                'trans_photo_two' => $trans_photo_two,
                'trans_photo_three' => $trans_photo_three,
                'trans_photo_four' => $trans_photo_four,
                'trans_photo_five' => $trans_photo_five,

                'slot_day' => $trainerdetails->slot_day,
                'from_time' => $trainerdetails->from_time,
                'to_time' => $trainerdetails->to_time,

                'is_profile_completed' => $userData->is_profile_completed
            ]);
        }
    }


    public function workoutList(Request $request)
    {
        $id = $request->input('customerid');

        // $workoutType  = ["exercises", "meditation", "yoga"];
        // $return = [];
        // foreach ($workoutType  as $key => $value) {
        //     $keyword = $request->input('keyword');
        //     $return[$value] = WorkoutPlanApiCollection::collection(
        //         Workout::with('workoutDetails')
        //             ->where('status', 1)
        //             ->where('workout_type', $value)
        //             ->where(function($query) use ($keyword) {
        //                 $query->where('name', 'like', '%'.$keyword.'%') // Example: Searching in the 'title' column
        //                       ; // Example: Searching in the 'description' column
        //             })
        //             ->get()
        //     );
        // }
        // ret
        $keyword = $request->input('keyword');
        $return = WorkoutPlanApiCollection::collection(
            Workout::with('workoutDetails')
                ->where('status', 1)
                ->where(function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%') // Example: Searching in the 'title' column
                    ; // Example: Searching in the 'description' column
                })
                ->get()
        );
        $userDetails = User::where('id', $id)->first();
        $data = new UserDetailApiCollection($userDetails);
        $response = [
            'status' => true,
            'response_code' => 200,
            'message' => "",
            'data' => $return, // Assuming $return contains the workout data
            'userdetails' => $data
        ];

        // Encode the combined response as JSON and return it
        return response()->json($response);
        // return $plans;

    }

    public function dietPlanList(Request $request)
    {
        // $planss = Diet::where('status', 1)->where('age_from',auth()->user()?->profile?->age)
        // ->where('height',auth()->user()?->profile?->height)->where('weight',auth()->user()?->profile?->weight) ->first();
        if (auth()->user()?->profile?->age != "" && auth()->user()?->profile?->height != "" && auth()->user()?->profile?->weight) {

            $planss = Diet::where('status', 1)->first();
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

                    $plans = new DietApiCollection($plans);
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

    public function updateProfile(Request $request)
    {
        $userId = auth()->user()->id;
        $validator = Validator::make($request->all(), [
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'expertise' => 'nullable',

            'ac_no' => 'nullable|numeric|min:9999999',
            'ifsc_code' => 'nullable|string',

            'gender' => 'nullable|string',
            'age' => 'nullable|numeric|min:1',
            'preffered_language' => 'nullable|string',
            'qualification_name' => 'nullable|string',
            'intro' => 'nullable|string',
            'reenter_ac_no' => 'nullable|numeric|min:9999999|same:ac_no',
            'bank_name' => 'nullable|string',

            'title' => 'sometimes|in:trainer,doctor',
        ]);
        if ($validator->fails()) {
            $error = ['error' => $validator->errors()->all()];
            return $this->responseJson(false, 200, $validator->errors()->first(), "");
        }
        $guidance = is_array($request->guidance) ? $request->guidance : explode(",", $request->guidance);
        $request->merge(['guidance' => $guidance]);
        // $userData =  $this->trainerService->updateOrCreateProfile($request->all(), $userId);
        $userData = User::where('id', $userId)->first();
        $userData->first_name = $request->first_name;
        $userData->last_name = $request->last_name;
        $userData->is_profile_completed = 1;
        $userData->save();

        if (empty($userData->roles)) {
            $isCustomerRole = $this->roleModel->where('slug', $request->title)->first();
            $userData->roles()->sync($isCustomerRole->id);
        }

        $trainerdetails = TrainerDetail::where('user_id', $userId)->first();

        try {
            if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                $fileName = rand() . time() . '.' . $file->getClientOriginalExtension();
                // Check if there is an existing image associated with the model
                if (File::exists(public_path('uploads/' . $trainerdetails?->profile_photo))) {
                    File::delete(public_path('uploads/' . $trainerdetails?->profile_photo));
                }
                $file->move(public_path('uploads'), $fileName);
            }
            if ($request->hasFile('trans_photo_one')) {
                $file = $request->file('trans_photo_one');
                $fileName2 = rand() . time() . '.' . $file->getClientOriginalExtension();
                // Check if there is an existing image associated with the model
                if (File::exists(public_path('uploads/' . $trainerdetails?->trans_photo_one))) {
                    File::delete(public_path('uploads/' . $trainerdetails?->trans_photo_one));
                }
                $file->move(public_path('uploads'), $fileName2);
            }
            if ($request->hasFile('trans_photo_two')) {
                $file = $request->file('trans_photo_two');
                $fileName3 = rand() . time() . '.' . $file->getClientOriginalExtension();
                // Check if there is an existing image associated with the model
                if (File::exists(public_path('uploads/' . $trainerdetails?->trans_photo_two))) {
                    File::delete(public_path('uploads/' . $trainerdetails?->trans_photo_two));
                }
                $file->move(public_path('uploads'), $fileName3);
            }
            if ($request->hasFile('trans_photo_three')) {
                $file = $request->file('trans_photo_three');
                $fileName4 = rand() . time() . '.' . $file->getClientOriginalExtension();
                // Check if there is an existing image associated with the model
                if (File::exists(public_path('uploads/' . $trainerdetails?->trans_photo_three))) {
                    File::delete(public_path('uploads/' . $trainerdetails?->trans_photo_three));
                }
                $file->move(public_path('uploads'), $fileName4);
            }
            if ($request->hasFile('trans_photo_four')) {
                $file = $request->file('trans_photo_four');
                $fileName5 = rand() . time() . '.' . $file->getClientOriginalExtension();
                // Check if there is an existing image associated with the model
                if (File::exists(public_path('uploads/' . $trainerdetails?->trans_photo_four))) {
                    File::delete(public_path('uploads/' . $trainerdetails?->trans_photo_four));
                }
                $file->move(public_path('uploads'), $fileName5);
            }
            if ($request->hasFile('trans_photo_five')) {
                $file = $request->file('trans_photo_five');
                $fileName6 = rand() . time() . '.' . $file->getClientOriginalExtension();
                // Check if there is an existing image associated with the model
                if (File::exists(public_path('uploads/' . $trainerdetails?->trans_photo_five))) {
                    File::delete(public_path('uploads/' . $trainerdetails?->trans_photo_five));
                }
                $file->move(public_path('uploads'), $fileName6);
            }

            $slot_selectjson = json_encode($request->slot_select);
            $loggedInTrainer = auth()->user();

            $trainer_detail = TrainerDetail::where('user_id', $userId)->first();
            if (empty($trainer_detail)) {
                $trainer_detail = new TrainerDetail();
            }
            $trainer_detail->user_id = $loggedInTrainer->id;
            $trainer_detail->name = $request->first_name . ' ' . $request->last_name;
            $trainer_detail->expertise = $request->expertise;
            $trainer_detail->experience = $request->experience;
            $trainer_detail->address = $request->address;
            $trainer_detail->ac_no = $request->ac_no;
            $trainer_detail->ifsc_code = $request->ifsc_code;

            $trainer_detail->slot_day = $request->slot_day;
            $trainer_detail->from_time = $request->from_time;
            $trainer_detail->to_time = $request->to_time;

            $trainer_detail->profile_photo = $fileName ?? $trainer_detail?->profile_photo;
            $trainer_detail->trans_photo_one = $fileName2 ?? $trainer_detail?->trans_photo_one;
            $trainer_detail->trans_photo_two = $fileName3 ?? $trainer_detail?->trans_photo_two;
            $trainer_detail->trans_photo_three = $fileName4 ?? $trainer_detail?->trans_photo_three;
            $trainer_detail->trans_photo_four = $fileName5 ?? $trainer_detail?->trans_photo_four;
            $trainer_detail->trans_photo_five = $fileName6 ?? $trainer_detail?->trans_photo_five;

            $trainer_detail->gender = $request->gender;
            $trainer_detail->age = $request->age;
            $trainer_detail->preffered_language = $request->preffered_language;
            $trainer_detail->qualification_name = $request->qualification_name;
            $trainer_detail->intro = $request->intro;
            $trainer_detail->reenter_ac_no = $request->reenter_ac_no;
            $trainer_detail->bank_name = $request->bank_name;

            // if ($request->base64Image_for_profile != "") {
            //     $trainer_detail->profile_picture_file = $fileName;
            // } else {
            //     $trainer_detail->profile_picture_file = $trainerdetails->profile_picture_file;;
            // }
            // if ($request->base64Image_for_qualification != "") {
            //     $trainer_detail->qualification_file = $fileNameQualification;
            // } else {
            //     $trainer_detail->qualification_file = $trainerdetails->qualification_file;
            // }
            // if ($request->base64Image_for_bank_cheque != "") {
            //     $trainer_detail->bank_check_file = $fileNameBankCheque;
            // } else {
            //     $trainer_detail->bank_check_file = $trainerdetails->bank_check_file;
            // }
            // if ($request->base64Image_for_id_proof != "") {
            //     $trainer_detail->id_proof_file = $fileNameIdProof;
            // } else {
            //     $trainer_detail->id_proof_file = $trainerdetails->id_proof_file;
            // }

            if (isset($request->slot_select) && $request->slot_select != "") {
                //$trainer_detail->id_proof_file=$request->guidance;
                $trainer_detail->slot_select = $slot_selectjson;
            } else {
                $trainer_detail->slot_select = $trainerdetails->slot_select ?? NULL;
            }
            $trainer_detail->save();

            $trainerdetails = TrainerDetail::where('user_id', $userId)->first();
            $imageUrl =   url('uploads/' . $trainerdetails->profile_photo);
            $trans_photo_one = url('uploads/' . $trainerdetails->trans_photo_one);
            $trans_photo_two = url('uploads/' . $trainerdetails->trans_photo_two);
            $trans_photo_three = url('uploads/' . $trainerdetails->trans_photo_three);
            $trans_photo_four = url('uploads/' . $trainerdetails->trans_photo_four);
            $trans_photo_five = url('uploads/' . $trainerdetails->trans_photo_five);
            // $imageUrl = url('profile_picture/' . $fileName);
            // $qualification_url = url('qualification/' . $fileNameQualification);
            // $bank_cheque_url = url('bankcheque/' . $fileNameBankCheque);
            // $id_proof_url = url('id_proof/' . $fileNameIdProof);

            //return response()->json(['id_proof_url' => $id_proof_url], 201);
            $notification = new Notification;
            $notification->trainer_id = $userId;
            $notification->massage = "Profile is update successfully.";
            $notification->save();

            if ($userData) {
                return $this->responseJson(true, 200, "Profile Data", [
                    'first_name' => $userData->first_name,
                    'last_name' => $userData->last_name,
                    'expertise' => $trainerdetails->expertise,
                    'experience ' => $trainerdetails->experience,
                    'ac_no ' => $trainerdetails->ac_no,
                    'reenter_ac_no ' => $trainerdetails->reenter_ac_no,
                    // 'slot' => !empty($trainerdetails->slot_select) ? json_decode($trainerdetails->slot_select, true) : [],
                    'bank_name' => $trainerdetails->bank_name,
                    'ifsc_code' => $trainerdetails->ifsc_code,

                    'gender' => $trainerdetails->gender,
                    'age' => $trainerdetails->age,
                    'preffered_language' => $trainerdetails->preffered_language,
                    'qualification_name' => $trainerdetails->qualification_name,

                    'profile_picture_url' => $imageUrl,

                    'address' => $trainerdetails->address,
                    'trans_photo_one' => $trans_photo_one,
                    'trans_photo_two' => $trans_photo_two,
                    'trans_photo_three' => $trans_photo_three,
                    'trans_photo_four' => $trans_photo_four,
                    'trans_photo_five' => $trans_photo_five,

                    'slot_day' => $trainerdetails->slot_day,
                    'from_time' => $trainerdetails->from_time,
                    'to_time' => $trainerdetails->to_time,

                    'is_profile_completed' => $userData->is_profile_completed
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage() . '/' . $th->getLine() . '/' . $th->getFile(), 'data' => (object)[]], 500);
        }
    }

    public function dasboardData(Request $request)
    {
        $lastWeek = Carbon::now()->subDays(7)->toDateTimeString();
        $newusers = User::where('is_subscribed', '1')->where('payment_date', '>=', $lastWeek)->count();

        $userId = auth()->user()->id;
        $callrequest = TrainerCustomerRequest::where('trainer_id', $userId)->count();
        $assgin_work = User::where('trainer_id', $userId)->count();
        $diet = User::where('dietitian_id', $userId)->count();
        return $this->responseJson(true, 200, "Dasbaord Data", ['call_queries' => '0', 'call_request' => $callrequest, 'assign_diet_plan' => $diet, 'assgin_work' => $assgin_work, 'webinars_hosted' => '0', 'people_reached' => '0', 'current_tranees' => '0', 'new_user' => $newusers]);
    }


    public function availibityProfile(Request $request)
    {

        $userId = auth()->user()->id;
        $validator = Validator::make($request->all(), [
            'no_of_hours' => 'nullable|string',
            'time_to' => 'nullable|string',
            'time_form' => 'nullable|string',
            'schedule' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            $error = ['error' => $validator->errors()->all()];
            return $this->responseJson(false, 200, $validator->errors()->first(), "");
        }

        try {
            $trainer_detail = TrainerDetail::where('user_id', $userId)->first();

            $trainer_detail->no_of_hours = $request->no_of_hours;
            $trainer_detail->time_to = $request->time_to;
            $trainer_detail->time_form = $request->time_form;
            $trainer_detail->schedule = $request->schedule;
            $trainer_detail->save();
            return $this->responseJson(true, 200, "Your availability Update Successcds.", ['no_of_hours' => $request->no_of_hours, 'time_to' => $request->time_to, 'time_form' => $request->time_form, 'schedule' => $request->schedule]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage() . '/' . $th->getLine() . '/' . $th->getFile(), 'data' => (object)[]], 500);
        }
    }


    public function customerList(Request $request)
    {

        $userId = auth()->user()->id;

        try {
            $filterConditions = [];
            // $users = $this->userService->getCustomers('customer', $filterConditions);
            $keyword = $request->input('keyword');
            if ($keyword == "workout") {
                $users = User::where('trainer_id', $userId)->get();
            } else if ($keyword == "diet") {
                $users = User::where('dietitian_id', $userId)->get();
            }
            $data = [];
            foreach ($users as $userss) {
                $data[] = new UserDetailApiCollection($userss);
            }
            return $this->responseJson(true, 200, "", $data);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage() . '/' . $th->getLine() . '/' . $th->getFile(), 'data' => (object)[]], 500);
        }
    }


    public function foodList(Request $request)
    {
        $id = $request->input('customerid');
        $userId = auth()->user()->id;
        try {
            $filterConditions = [];
            $keyword = $request->input('keyword');
            $foods = Food::where('status', '1')
                ->where(function ($query) use ($keyword) {
                    $query->where('food_type', 'like', '%' . $keyword . '%');
                })
                ->get();
            $datas = FoodApiCollection::collection($foods);
            $userDetails = User::where('id', $id)->first();
            $data = new UserDetailApiCollection($userDetails);
            $response = [
                'status' => true,
                'response_code' => 200,
                'message' => "",
                'data' => $datas, // Assuming $return contains the workout data
                'userdetails' => $data
            ];

            // Encode the combined response as JSON and return it
            return response()->json($response);

            // return $this->responseJson(true, 200, "", $data);

        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage() . '/' . $th->getLine() . '/' . $th->getFile(), 'data' => (object)[]], 500);
        }
    }


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


    public function slotUpdate(Request $request)
    {

        $userId = auth()->user()->id;
        $validator = Validator::make($request->all(), [
            'slot_select' => 'nullable',
        ]);
        if ($validator->fails()) {
            $error = ['error' => $validator->errors()->all()];
            return $this->responseJson(false, 200, $validator->errors()->first(), "");
        }

        try {
            $trainer_detail = TrainerDetail::where('user_id', $userId)->first();

            $trainer_detail->slot_select = $request->slot_select;

            $trainer_detail->save();
            return $this->responseJson(true, 200, "Your Slot Update Successcds.", ['slot_select' => $request->slot_select]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage() . '/' . $th->getLine() . '/' . $th->getFile(), 'data' => (object)[]], 500);
        }
    }

    public function updateCustomerFood(Request $request)
    {

        $userId = auth()->user()->id;
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable',
            'trainer_id' => 'nullable',
            'foot_type' => 'nullable',
            'food' => 'nullable',
        ]);
        if ($validator->fails()) {
            $error = ['error' => $validator->errors()->all()];
            return $this->responseJson(false, 200, $validator->errors()->first(), "");
        }

        try {

            foreach ($request->food as $foods) {
                $getfood = Food::where('id', $foods['id'])->first();
                $getfood->quantity = $foods['quantity'];
                $getfood->food_make = $foods['food_make'];
                $getfood->food_suffix = $foods['food_suffix'];
                $getfood->save();
            }

            foreach ($request->option_food as $foodss) {
                $getfoods = Food::where('id', $foodss['id'])->first();
                $getfoods->quantity = $foodss['quantity'];
                $getfoods->food_make = $foodss['food_make'];
                $getfoods->food_suffix = $foodss['food_suffix'];
                $getfoods->save();
            }

            UserFootitem::updateOrCreate(
                [
                    'user_id' => $request->user_id,
                    'trainer_id' => $userId,
                    'foot_type' => $request->food_type,
                    'water' => $request->water,
                    'remarks' => $request->remark,

                ],
                [
                    'food' => json_encode($request->food),
                    'option_food' => json_encode($request->option_food)
                ]
            );




            // $getfood = Food::whereIn('id', $request->food)->orderBy('created_at', 'desc')->get();
            // foreach($getfood as $getfoods){
            // $msg = "Your eating time " . $getfoods->food_type  . ". Please eat " . $getfoods->name . " on time.";

            // $notification = new Notification;
            // $notification->trainer_id=$userId;
            // $notification->user_id=$request->user_id;
            // $notification->massage=$msg;

            // $notification->save();


            // $userDetails = User::where('id', $request->user_id)->first();
            // $requestparam = (object)array(
            //     'body' => $msg,
            //     'title' => 'Swasthfit'
            // );
            // $fcm = $userDetails->fcm_token;
            // $this->sendNotificationtest($requestparam, $fcm);
            // }

            $requestparam = (object)array(
                'body' => 'Congratulations! Your Dietitian Update Your Food.',
                'title' => 'Swasthfit'
            );
            $users = User::where('id', $request->user_id)->first();
            $fcm =  $users->fcm_token;

            $this->sendNotificationtest($requestparam, $fcm);
            $notification = new Notification;
            $notification->user_id = $request->user_id;
            $notification->massage = $requestparam;
            $notification->save();



            return $this->responseJson(true, 200, "User Food Updated Successfully..");
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage() . '/' . $th->getLine() . '/' . $th->getFile(), 'data' => (object)[]], 500);
        }
    }



    public function editCustomerFood(Request $request, $id)
    {

        $userId = auth()->user()->id;
        $validator = Validator::make($request->all(), [
            'food_id' => 'nullable',
        ]);
        if ($validator->fails()) {
            $error = ['error' => $validator->errors()->all()];
            return $this->responseJson(false, 200, $validator->errors()->first(), "");
        }

        try {
            $food = UserFootitem::where('id', $id)->first();
            $food->food_id = implode(',', $request->food_id);
            $food->save();

            $getfood = Food::whereIn('id', $request->food_id)->orderBy('created_at', 'desc')->get();

            foreach ($getfood as $getfoods) {
                $msg = "Your eating time " . $getfoods->food_type  . ". Please eat " . $getfoods->name . " on time.";

                $notification = new Notification;
                $notification->trainer_id = $userId;
                $notification->user_id = $request->user_id;
                $notification->massage = $msg;
                $notification->save();


                $userDetails = User::where('id', $request->user_id)->first();
                $requestparam = (object)array(
                    'body' => $msg,
                    'title' => 'Swasthfit'
                );
                $fcm = $userDetails->fcm_token;
                $this->sendNotificationtest($requestparam, $fcm);
            }



            return $this->responseJson(true, 200, "Edit User Food Successfully..");
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage() . '/' . $th->getLine() . '/' . $th->getFile(), 'data' => (object)[]], 500);
        }
    }



    public function deleteCustomerFood(Request $request, $id)
    {
        $food = UserFootitem::where('id', $id)->delete();
        return response()->json(['success' => true, 'message' => 'Deleted Successfully']);
    }

    public function customerDetails(Request $request, $id)
    {
        $userDetails = User::where('id', $id)->first();

        $questions = ProfileQuestion::with(['answers' => function ($query) {
            $query->select('id', 'profile_question_id', 'answer', 'slug', 'input_type', 'comments');
        }])->select('id', 'question', 'slug', 'group_wise')->get();

        // Group by 'group_wise'
        $groupedQuestions = $questions->groupBy('group_wise');
        $arryMain = [];

        foreach ($groupedQuestions as $mkey => $main) {
            $arryMain[$mkey] = [];  // Initialize an array for each mkey
            foreach ($main as $value) {
                $answers = [];
                foreach ($value->answers as $answer) {
                    $answers[] = [
                        'answer' => $answer->answer,
                        'slug' => $answer->slug,
                        'input_type' => $answer->input_type,
                        'comments' => $answer->comments,
                        'user_ans' => 1
                    ];
                }

                $arryMain[$mkey][] = [
                    'id' => $value->id,
                    'question' => $value->question,
                    'slug' => $value->slug,
                    'group_wise' => $value->group_wise,
                    'answers' => $answers
                ];
            }
        }

        $data['personal_details'] = new UserDetailApiCollection($userDetails);
        $data['additional_details'] = $arryMain;
        return $this->responseJson(true, 200, "", $data);
    }


    public function customerWorkoutUpdate(Request $request)
    {

        $userId = auth()->user()->id;
        $validator = Validator::make($request->all(), [
            'workout_data' => 'nullable',
        ]);
        if ($validator->fails()) {
            $error = ['error' => $validator->errors()->all()];
            return $this->responseJson(false, 200, $validator->errors()->first(), "");
        }

        try {
            foreach ($request->workout_param as $rows) {

                $food = new UserWorkoutItem;
                $food->workout_type = $request->type;
                $food->trainer_id = $userId;
                $food->user_id = $request->user_id;
                $food->reps = $rows['reps'];
                $food->sets = $rows['sets'];
                $food->time = $rows['time'];
                $food->workout_id = $rows['id'];
                $food->save();

                // echo $rows['reps'];
                $updates = WorkoutDetails::where('workout_id', $rows['id'])->first();
                if ($updates) {
                    $update = WorkoutDetails::where('workout_id', $rows['id'])->first();
                    $update->reps = $rows['reps'];
                    $update->workout_name = $request->type;
                    $update->sets = $rows['sets'];
                    $update->time = $rows['time'];
                    $update->save();
                } else {
                    $update = new WorkoutDetails;
                    $update->workout_id = $rows['id'];
                    $update->reps = $rows['reps'];
                    $update->workout_name = $request->type;
                    $update->sets = $rows['sets'];
                    $update->time = $rows['time'];
                    $update->save();
                }
            }

            $requestparam = (object)array(
                'body' => 'Congratulations! Your Dietitian Update Your Food.',
                'title' => 'Swasthfit'
            );
            $users = User::where('id', $request->user_id)->first();
            $fcm =  $users->fcm_token;

            $this->sendNotificationtest($requestparam, $fcm);
            $notification = new Notification;
            $notification->user_id = $request->user_id;
            $notification->massage = $requestparam;
            $notification->save();





            // $getfood = Food::whereIn('id', $request->food_id)->orderBy('created_at', 'desc')->get();

            // foreach($getfood as $getfoods){
            // $msg = "Your eating time " . $getfoods->food_type  . ". Please eat " . $getfoods->name . " on time.";

            // $notification = new Notification;
            // $notification->trainer_id=$userId;
            // $notification->user_id=$request->user_id;
            // $notification->massage=$msg;
            // $notification->save();


            // $userDetails = User::where('id', $request->user_id)->first();
            // $requestparam = (object)array(
            //     'body' => $msg,
            //     'title' => 'Swasthfit'
            // );
            // $fcm = $userDetails->fcm_token;
            // $this->sendNotificationtest($requestparam, $fcm);

            //}



            return $this->responseJson(true, 200, "Customer Workout List Added Successfully..");
        } catch (\Throwable $th) {
            echo $th;
            return response()->json(['status' => false, 'message' => $th->getMessage() . '/' . $th->getLine() . '/' . $th->getFile(), 'data' => (object)[]], 500);
        }
    }


    public function liveSession(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'trainer_id' => 'nullable',
            'topic' => 'required',
            'date_and_time' => 'required',
        ]);
        if ($validator->fails()) {
            $error = ['error' => $validator->errors()->all()];
            return $this->responseJson(false, 200, $validator->errors()->first(), "");
        }

        // Create a new LiveSession instance
        $liveSession = new LiveSession;

        // Assign the validated data to the model's properties
        $liveSession->trainer_id = $request->trainer_id;
        $liveSession->topic = $request->topic;
        $liveSession->date_and_time = $request->date_and_time;
        // Assign other fields as needed

        // Save the model to the database
        $liveSession->save();

        // Optionally, you can return a response or redirect to a different page

        return response()->json(['success' => true, 'message' => 'Live session created successfully']);
    }


    public function newUserList(Request $request)
    {
        $lastWeek = Carbon::now()->subDays(7)->toDateTimeString();


        $userss = User::where('is_subscribed', '1')->where('payment_date', '>=', $lastWeek)->get();

        $data = [];
        foreach ($userss as $users) {
            $data[] = new UserDetailApiCollection($users);
        }
        return $this->responseJson(true, 200, "", $data);
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

    public function clientListTrainer(Request $request) {}
}
