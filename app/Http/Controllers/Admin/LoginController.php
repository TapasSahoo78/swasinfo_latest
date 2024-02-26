<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Auth;
use Helper;
use Log;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\BaseController;
use App\Models\Admin;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class LoginController extends BaseController
{

//     public function adminLogin(Request $request) {
//       //  echo $password = Hash::make('123456');die;
// //        if(['middleware'=>['admin']]){
// //            return redirect('admin/dashboard');
// //        }
//         if(Auth::guard('web_admin')->check()){
//             return redirect('admin/dashboard');
//         }

//         if ($request->isMethod('post')) {

//             $rules = [
//                 'email' => 'required|email|max:150',
//                 'password' => 'required',
//             ];
//             $customMessages = [
//                 'email.required' => 'Email address is required',
//                 'email.email' => 'Valid email address is required',
//                 'password.required' => 'Password is required',
//             ];
//             $this->validate($request, $rules, $customMessages);
//             $credentials = array('email' => $request['email'], 'password' => $request['password']);
//             if (Auth::guard('web_admin')->attempt($credentials)) {
//                 return redirect('admin/dashboard');
//             } else {
//                 return redirect()->back()->with('flash_message', trans('messages.10'));
//             }
//         }
//        return view('admin.login');

//     }

    public function editAdminPassword() {
        Session::put('page','update-admin-password');
        $adminDetails = Auth::guard('web_admin')->user();
        return view('Admin-view.Setting.editAdminPassword', ['adminDetails' => $adminDetails]);
    }

    public function chkCurrentPassword(Request $request) {
        $data = $request->all();
        if (Hash::check($data['current_pwd'], Auth::guard('web_admin')->user()->password)) {
            echo trans('labels.8');
        } else {
            echo trans('labels.9');
        }
    }

    public function updateCurrentPassword(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            if (Hash::check($data['current_pwd'], Auth::guard('web_admin')->user()->password)) {
                if ($data['new_pwd'] == $data['confirm_pwd']) {
                    Admin::where('id', Auth::guard('web_admin')->user()->id)
                            ->update(['password' => bcrypt($data['new_pwd'])]);
                    Session::flash('success_message', trans('messages.13'));
                } else {
                    Session::flash('error_message', trans('messages.12'));
                }
            } else {
                Session::flash('error_message', trans('messages.11'));
                return redirect()->back();
            }
            return redirect()->back();
        }
    }

    public function logout() {
        Auth::guard('web_admin')->logout();
        return redirect('admin');
    }


   

}
