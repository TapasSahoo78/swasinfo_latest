<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\BaseController;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
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
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
    /**
     * Method for overriding the where to redirect users after verification.
     * The redirectTo method will take precedence over the redirectTo attribute.
     */
    public function redirectTo()
    {
        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('sub-admin')){
            return route('admin.home');
        }else{
            /* if(in_array(auth()->user()->hasRole())){
                return route('user.email.verification.success');
            } */
            return route('user.email.verification.success');
        }
    }

    /**
     * Method for verifying user email by otp.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verifyByEmailOTP(Request $request)
    {
        $verificationCode = $request->verification_code;

        $request->validate([
            'verification_code' => 'integer|required',
        ]);

        $user = auth()->user();
        if($user->verification_code == $verificationCode){
            // $user->markEmailAsVerified();
            // $this->redirectPath()
            return $this->responseRedirect('user.email.verification.success', '', 'noFlash', false, false);
        }else{
            return $this->responseRedirectBack('You have entered an incorrect email verification code.', 'error', true, true);
        }
    }

    /**
     * Handle registration success page.
     */
    public function userEmailVerificationSuccess()
    {
        ## Welcome Email to User
        if(auth()->check()) {
            $user = auth()->user();
            $userId             = $user->id;
            $userDetails        = $user;
            $mailData           = [];
            $mailData['type']   = 'registrationComplete';
            // event(new SiteNotificationEvent($userDetails, $mailData));
        }

        $this->setPageTitle('Verification Success', '');
        return view('auth.email-verification-success');
    }
}
