<?php

namespace App\Http\Controllers\Mfi;

use App\Http\Controllers\BaseController;
use App\Services\Role\RoleService;
use App\Services\User\UserService;
use App\Services\Branch\BranchService;
use App\Services\Loan\LoanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MFIController extends BaseController
{

    protected $roleService;
     protected $loanService;
    protected $branchService;
    protected $userService;

    public function __construct(
        UserService $userService,
        RoleService $roleService,
        BranchService $branchService,
        LoanService $loanService
    ) {
        $this->userService = $userService;
        $this->roleService = $roleService;
         $this->branchService = $branchService;
         $this->loanService = $loanService;
    }
    public function index()
    {
        // return request()->slug;
        $this->setPageTitle('Dashboard');
         $filterConditions = [
            'mfi_id' => auth()->user()->mfi_id,
            'status'=>1
        ];
        $filterUserConditions = [
            'is_active' => 1
        ];
        $filterConditionsUsers = [
            'mfi_id' => auth()->user()->mfi_id,
            'is_active' => 1
        ];
         $filterLoanConditions = [
            'mfi_id' => auth()->user()->mfi_id,
            'status'=>1
        ];
        $listBranch = $this->branchService->listBranch($filterConditions, 'id', 'asc', 15);
        $totalBranches =  $listBranch->count();
        $listUsers = $this->userService->listUsersAll($filterUserConditions,[],'id', 'asc', 15);
        $totalUsers = $listUsers->count();
        $listCustomers = $this->userService->listCustomers($filterConditionsUsers, 'id', 'asc', 15);
        $totalCustomers = $listCustomers->count();
        $listLoan = $this->loanService->listLoan($filterLoanConditions, 'id', 'asc', 15);
        $totalloans = $listLoan->count();
        //dd($totalCustomers);
        //dd($totalUsers);
        /* $filterConditions = [
        'is_active' => 1,
        ];
        $filterSellerConditions = [
        'is_active' => 1,
        ]; */

        /* $customers = $this->userService->getCustomersDashboard('customer', $filterConditions, 10);

        $sellers = $this->userService->getSellersDashboard('seller', $filterSellerConditions, 5); */

        return view('mfi.dashboard.dashboard' , compact('totalBranches', 'totalUsers','totalCustomers','totalloans'));

        /*  if (auth()->user()->can('view-dashboard')) {
    $this->setPageTitle('Admin Dashboard');
    $filterConditions = [
    'is_active' => 1,
    ];
    $filterSellerConditions = [
    'is_active' => 1,
    ];

    $customers = $this->userService->getCustomersDashboard('customer', $filterConditions, 10);

    $sellers = $this->userService->getSellersDashboard('seller', $filterSellerConditions, 5);

    return view('admin.dashboard.dashboard', compact('customers', 'sellers'));
    } else {
    $this->setPageTitle('Admin Profile');
    return redirect()->route('admin.profile');
    } */
    }

    public function profile(Request $request)
    {
        $this->setPageTitle('User Profile');
        if ($request->post()) {
            //dd($request->all());
            $request->validate([
                'mobile_number' => 'required|numeric|digits:10',
                'first_name' => 'required|string',
                'username' => 'sometimes|string|nullable',
            ]);
            DB::begintransaction();
            try {
                $isUserUpdated = $this->userService->userDetailsUpdate($request->except(['_token', 'email']), auth()->user()->id);
                if ($isUserUpdated) {
                    DB::commit();
                    return $this->responseRedirectBack('Profile updated successfully', 'success', false);
                }
            } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something Went Wrong', 'error', true);
            }

        }
        return view('mfi.dashboard.profile');
    }

    public function adminUser(Request $request)
    {
        $this->setPageTitle('Admin Users');
        $users = $this->userService->getAdmins()->paginate(15);
        return view('mfi.dashboard.admin-user', compact('users'));
    }

    public function adminUserEdit(Request $request, $uuid)
    {
        $userId = uuidtoid($uuid, 'users');
        $userDetails = $this->userService->findById($userId);
        if ($request->post()) {
            DB::beginTransaction();
            try {
                $isUserUpdated = $this->userService->updateUserDetails($request->except(['_token', 'email']), $userId);
                if ($isUserUpdated) {
                    DB::commit();
                    return $this->responseRedirect('admin.user.list', 'User updated successfully', 'success', false);
                }
            } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something Went Wrong', 'error', true);
            }

        }
        $this->setPageTitle('User Edit');
        return view('mfi.dashboard.edit-user', compact('userDetails'));
    }
    public function attachPermission(Request $request, $uuid)
    {
        $this->setPageTitle('Admin Users');
        $id = uuidtoid($uuid, 'users');
        $user = $this->userService->findUser($id);
        $permissions = $this->roleService->getAllPermissions();
        $permissions = $permissions->chunk(ceil($permissions->count() / 13));
        if ($request->post()) {
            DB::begintransaction();
            try {
                $user->permissions()->detach();
                $isPermissionAttached = $user->givePermissionsTo($request->permission);
                if ($isPermissionAttached) {
                    DB::commit();
                    return $this->responseRedirect('admin.user.list', 'Permission attached to user successfully', 'success');
                }
            } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something Went Wrong', 'error', true);
            }
        }
        return view('mfi.dashboard.attach-permission', compact('user', 'permissions'));
    }

    public function changePassword(Request $request)
    {
        $this->setPageTitle('Change Password');
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
                    /* $mailData = [];
                    $mailData['type'] = 'passwordChanged';
                    event(new SiteNotificationEvent(auth()->user(), $mailData)); */
                    return $this->responseRedirect('admin.change.password', 'Password has been updated successfully', 'success', false, false);
                } else {
                    return $this->responseRedirectBack('We are facing some technical issue now. Please try again after some time.', 'error', true, true);
                }
            } else {
                return $this->responseRedirectBack('Invalid current password provided, please try again!', 'error', true, true);
            }
        }
        return view('mfi.dashboard.change-password');
    }
}
