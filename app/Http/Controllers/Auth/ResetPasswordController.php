<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    // use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function showResetForm(Request $request, $token)
    {
        $email = $request->email;
        return view('auth.passwords.reset', compact('token', 'email'));
    }

    public function reset(Request $request)
    {
        //Validate input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed',
            'token' => 'required'
        ]);

        //check if payload is valid before moving on
        if ($validator->fails()) {
            return $this->responseRedirectBack('Please complete the form', 'error', true, true);
        }

        $password = $request->password;

        $user = User::where('email', $request->email)->first();

        if (!$user) return view('auth.passwords.email');

        // Redirect the user back if the email is invalid
        if (!$user) return $this->responseRedirectBack('Email not found', 'error', true, true);

        //Hash and update the new password
        $user->password = Hash::make($password);
        $user->update(); //or $user->save();

        //login the user immediately they change password successfully
        Auth::login($user);

        if (!auth()->user()->is_active) {
            auth()->logout();
            return $this->responseRedirectBack('Oh no! Your Account has been deactivated. Please contact admin', 'info', true, true);
        } else if (!auth()->user()->is_approve) {
            auth()->logout();
            return $this->responseRedirectBack('Hang tight! Our team are currently verifying your application. You\'ll receive an approval email when your account is ready.', 'info', true, true);
        } else {
            // return auth()->user();
            return redirect(RouteServiceProvider::HOME);
        }
    }
}
