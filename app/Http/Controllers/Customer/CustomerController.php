<?php

namespace App\Http\Controllers\Customer;

use App\Events\SiteNotificationEvent;
use App\Http\Controllers\BaseController;
use App\Services\User\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends BaseController
{

    protected $userService;
    public function __construct(
        UserService $userService
    ) {
        $this->userService = $userService;
    }
    public function index(Request $request)
    {
        $this->setPageTitle('Customer Dashboard');
        return view('customer.dashboard');
    }
    public function wishList(Request $request)
    {
        $this->setPageTitle('Customer Wish List');
        $wishlists = auth()->user()->wishlists;
        return view('customer.wishlist.wish-list', compact('wishlists'));
    }
    public function addressBook(Request $request)
    {
        $this->setPageTitle('Customer Address Book');
        $addresses = auth()->user()->addressBook;
        return view('customer.address.index', compact('addresses'));
    }

    public function settings(Request $request)
    {
        $this->setPageTitle('Customer Address Book');
        return view('customer.settings');
    }
    public function cart(Request $request)
    {
        $this->setPageTitle('Customer Cart');
        return view('frontend.cart');
    }
    public function orders(Request $request)
    {
        $this->setPageTitle('Customer Orders');
        return view('customer.order');
    }
    public function updateProfile(Request $request)
    {
        $request->validate([
            'username' => 'nullable|unique:users,username,' . auth()->user()->id,
            'mobile_number' => 'nullable|unique:users,mobile_number,' . auth()->user()->id,
        ]);
        DB::beginTransaction();
        try {
            $isCustomerUpdated = $this->userService->createOrUpdateCustomer($request->except(['_token', 'email']), auth()->user()->id);
            if ($isCustomerUpdated) {
                DB::commit();
                return $this->responseRedirect('customer.dashboard', 'Profile updated successfully', 'success', false);
            }
        } catch (Exception $e) {
            DB::rollback();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseRedirectBack('Something went wrong', 'error', true);
        }
    }
    public function updateProfileImage(Request $request)
    {
        if ($request->ajax()) {
            $userId = auth()->user()->id;
            $validated = $this->validate($request, [
                'rawImageContent' => 'required',
            ]);

            $isProcessed = $this->userService->updateProfileImage($request->rawImageContent
                , $userId);

            if ($isProcessed) {
                $storageDisk = config('constants.SITE_FILE_STORAGE_DISK');

                if ($storageDisk == 's3') {
                    $thrumbImage = getS3URL(config('constants.SITE_THUMBNAIL_IMAGE_UPLOAD_PATH') . $isProcessed, 'profilePicture');
                    $profileImage = getS3URL(config('constants.SITE_USER_IMAGE_UPLOAD_PATH') . $isProcessed, 'profilePicture');
                } else if ($storageDisk == 'public') {
                    if (file_exists(public_path('storage/' . config('constants.SITE_USER_IMAGE_UPLOAD_PATH') . '/' . $isProcessed))) {
                        $profileImage = asset('storage/' . config('constants.SITE_USER_IMAGE_UPLOAD_PATH') . '/' . $isProcessed);
                    } else {
                        $profileImage = asset('assets/frontend/images/no-profile-picture.jpeg');
                    }
                }
                return $this->responseJson(true, 200, 'Profile Image updated successfully', [
                    'profileImage' => $profileImage,
                ]);
            } else {
                return $this->responseJson(false, 200, 'We are facing some technical issue now. Please try again after some time.');
            }
        } else {
            abort(403);
        }
    }
    public function changePassword(Request $request)
    {
        $userId = auth()->user()->id;
        if ($request->post()) {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:8|string|different:current_password',
                'confirm_password' => 'required|same:new_password',
            ]);
            $isPasswordValidated = $this->userService->validatePassword($request->current_password, $userId);
            if ($isPasswordValidated) {
                $isProcessed = $this->userService->saveUserProfileDetails([
                    'password' => $request->new_password,
                ], $userId);
                if ($isProcessed) {
                    //Notify user for password changed
                    $mailData = [];
                    $mailData['type'] = 'passwordChanged';
                    event(new SiteNotificationEvent(auth()->user(), $mailData));
                    return $this->responseRedirect('customer.settings', 'Password has been updated successfully', 'success', false, false);
                } else {
                    return $this->responseRedirectBack('We are facing some technical issue now. Please try again after some time.', 'error', true, true);
                }
            } else {
                return $this->responseRedirectBack('Invalid current password provided, please try again!', 'error', true, true);
            }

        }
    }

    public function liveSession(Request $request){
        echo "hello";
        die();
        return view('mfi.customers.livesession');
    }
}
