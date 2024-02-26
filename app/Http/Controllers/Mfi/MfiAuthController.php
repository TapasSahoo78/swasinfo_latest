<?php

namespace App\Http\Controllers\Mfi;

use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Models\Mfi;
use Illuminate\Http\Request;

class MfiAuthController extends BaseController
{
    //

    public function __construct()
    {
        $this->middleware('guest')->except('mfiLogout');
    }
    public function showLoginForm(Request $request)
    {
        $this->setPageTitle('Login','');
        //return $request->slug;
        $mfiSlug = $request->slug;
        $logo = Mfi::where('code',$request->slug)->first();
        //dd($logo->logo_picture);
        return view('mfi.auth.login')->with(['mfi_slug'=> $mfiSlug,'logo'=>$logo]);
    }

    public function login(Request $request)
    {
        $input = $request->all();
        // return $input;
        $this->validate($request, [
            'login_id' => 'required|min:5',
            'password' => 'required',
            'mfi_slug' => 'required',
        ]);

        $userData = array(
            'login_id' => $input['login_id'],
            'password' => $input['password'],
        );
        $rememberMe = $request->has('remember') ? true : false;
        /* $userData = User::where('login_id',$request->login_id)->first(); */
        //dd($userData->toArray());
        // return $user;
        // return auth()->attempt($userData, $rememberMe);
        if (auth()->attempt($userData, $rememberMe)) {

            $user = auth()->user();
            // return $user;
            if (!auth()->user()->is_active) {
                auth()->logout();
                return $this->responseRedirectBack('Oh no! Your Account has been deactivated. Please contact admin', 'info', true, true);
            } else if (!auth()->user()->is_approve) {
                auth()->logout();
                return $this->responseRedirectBack('Hang tight! Our team are currently verifying your application. You\'ll receive an approval email when your account is ready.', 'info', true, true);
            } else {
                // return auth()->user();
                // return redirect()->route('customer.dashboard');

                //    return redirect(RouteServiceProvider::HOME);
                // if(auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('admin') || auth()->user()->hasRole('sub-admin'))  return redirect(RouteServiceProvider::HOME);

                // else if(auth()->user()->hasRole('customer')){
                //     // dd('here');
                return redirect()->route('mfi.home', ['slug' => $request->mfi_slug]);
                // }

                // else if(auth()->user()->hasRole('seller')) return redirect()->route('seller.dashbord');

                // else if(auth()->user()->hasRole('delivery-agent')) return redirect()->route('delivery.agent.dashbord');
            }
        }

        return $this->responseRedirectBack('Login Id and password are wrong.', 'error', true, true);
    }

    public function mfiLogout(Request $request){
        auth()->logout();
        return    redirect()->route('mfi.login-show', ['slug' => request()->slug]);
    }


}
