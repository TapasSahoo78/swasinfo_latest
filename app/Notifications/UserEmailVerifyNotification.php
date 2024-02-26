<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;
use App\Mail\SendMailable;

class UserEmailVerifyNotification extends VerifyEmail implements ShouldQueue
{
    use Queueable;

    public static $toMailCallback;
    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $data = array();
        $data['mail_type']      = 'email_verify';
        $data['to']             = $this->user->email;
        $data['from']           = config('services.email_configuration')['site_mail_from'];
        $data['subject']        = 'User Email Verify Notification';
        $data['greetings']      = "Hello! ".$this->user->username;
        $data['button']         = "Verify Email Addresss";
        $data['line']           = "Please copy the below code and put it on your site to verify your email address.";
        $data['end_greetings']  = config('services.email_configuration')['site_mail_greetings'];
        $data['from_user']      = config('services.email_configuration')['site_mail_greetings_from'];
        //$verificationUrl = $this->verificationUrl($notifiable);
        /* if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        } */
        //$data['link']=$verificationUrl;
        $data['link']           = $this->user->verification_code;
        return (new SendMailable($data));
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
