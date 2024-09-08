<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Mail\SendMailable;
use Illuminate\Http\Request;
use App\Services\User\UserService;
use App\Services\User\InviteService;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\BaseController;
use App\Models\User;

class InvitationController extends BaseController
{

    protected $userService;
    protected $inviteService;

    /**
     * InvitationController constructor.
     * @param InviteService $inviteService
     */

    public function __construct(
        UserService $userService,
        InviteService $inviteService
    ) {
        $this->userService    = $userService;
        $this->inviteService  = $inviteService;
    }
    public function list(Request $request)
    {
        $users    =  $this->inviteService->fetchInvites(['registered_at' => null]);

        $this->setPageTitle('Admin Users', '');
        return view('admin.invite.invite-admin', compact('users'));
    }

    public function create()
    {

        $roles = Role::where('role_type', 'sub-admin')->get();

        $this->setPageTitle('Add Admin User', '');
        return view('admin.invite.add-admin', compact('roles'));
    }

    /**
     * Store a newly created user.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name'     =>  'required|string',
            'last_name'     =>  'required|string',
            'email'     =>  'required|email|unique:users,deleted_at,NULL',
            'mobile_number' => 'required|numeric|digits:10',
            'role'   =>  'required|exists:roles,id',
            'password' => 'required|string'
        ]);
        // dd($request->all());
        \DB::beginTransaction();
        try {
            $isAdminCreated = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile_number' => $request->mobile_number,
                'password' => bcrypt($request->password)
            ]);

            /* $this->inviteService->createAdmin($request->except('_token')); */
            if ($isAdminCreated) {
                $isRole = Role::find($request->role);
                $isAdminCreated->roles()->attach($isRole);
            }
            if ($isAdminCreated) {
                \DB::commit();
                return $this->responseRedirect('admin.user.list', 'Admin User created', 'success', false, false);
            }
        } catch (\Exception $e) {
            \DB::rollback();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseRedirectBack('Something went wrong', 'error', true);
        }
        return $this->responseRedirect('admin.invitation.list', 'Invitation link has been sent to the user', 'success', false, false);
    }
}
