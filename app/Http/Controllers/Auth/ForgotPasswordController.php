<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Rules\ReCaptchaRule;
use Illuminate\Http\Request;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * @var UserService
     */
    protected $userService;

    public function __construct(UserService $userService){
        $this->userService        = $userService;
    }

    protected function validateEmail(Request $request)
    {
        return $request->validate([
            'email' => ['required', 'email'],
            // 'recaptcha' => ['required', new ReCaptchaRule('forgetpassword')],
        ]);
    }

    /**
     * Send a reset link to the given user.
     * overriding the method sendResetLinkEmail in SendsPasswordResetEmails
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);
        //dd('die');
        $filterConditions=[
            'email'=>$request->email,
        ];
        $user=$this->userService->findUserBy($filterConditions);
        // return $user;
        if(!$user){

            return $this->responseRedirectBack('Email not registered with us', 'error', true, true);
        }
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        return $response == Password::RESET_LINK_SENT ? $this->sendResetLinkResponse($request, $response) : $this->sendResetLinkFailedResponse($request, $response);
    }
}
