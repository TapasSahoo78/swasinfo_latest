<?php

namespace App\Http\Controllers\Auth;

use App\Rules\ReCaptchaRule;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\BaseController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout','adminLogout');
    }

    public function showLoginForm()
    {
        $this->setPageTitle('Admin Login','');
        return view('auth.login');
    }

    public function login(Request $request)
    {
      
        $input = $request->all();
        // return $input;
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
            // 'recaptcha' => ['required', new ReCaptchaRule('login')],
        ]);

        $userData = array(
            'email' => $input['email'],
            'password' => $input['password']
        );
        $rememberMe = $request->has('remember') ? true : false;
        // return auth()->attempt($userData, $rememberMe);
        if (auth()->attempt($userData, $rememberMe)) {
            
            $user = auth()->user();
            // return $user;
            if (!$user->is_active) {
                auth()->logout();
                return $this->responseRedirectBack('Oh no! Your Account has been deactivated. Please contact admin', 'info', true, true);
            } else if (!$user->is_approve) {
                auth()->logout();
                return $this->responseRedirectBack('Hang tight! Our team is currently verifying your application. You\'ll receive an approval email when your account is ready.', 'info', true, true);
            } else if ($user->deleted_at !== null) {
                auth()->logout();
                return $this->responseRedirectBack('Your account has been deleted. Please contact support for further assistance.', 'info', true, true);
            } else {
                // User is active, approved, and not deleted
                return redirect(RouteServiceProvider::HOME);
                // Add additional role-based redirections if needed
            }
        }

        return $this->responseRedirectBack('Email address and password are wrong.', 'error', true, true);
    }

    public function adminLogout(Request $request){
        $this->loggedOut($request);
    }

    protected function loggedOut(Request $request) {
        $referer= $request->headers->get('referer');
        if(str_contains($referer,'admin')){
            return redirect(route('admin.login'));
        }else{
            return redirect(route('admin.login'));
        }

    }

  

    
}
