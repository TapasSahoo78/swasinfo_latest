<?php

namespace App\Notifications;

use PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Mail\SiteEmail;
use App\Channels\Messages\TextMessage;
use App\Channels\TextMessageChannel;

class SiteNotification extends Notification
{
    use Queueable;

    public $user;
    public $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $data)
    {
        $this->user = $user;
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $sendNotification   = [];
        $userNotificationSettings = [];
        $sendEmail          = false;
        $sendText           = false;
        $sendDBPush         = false;

        if($this->user->profile){
            $userNotificationSettings       = $this->user->profile->notifications;
        }

        //User (profile) notification settings
        $userEmailNotificationSettings  = isset($userNotificationSettings['medium']['email']) ? $userNotificationSettings['medium']['email'] : false;
        $userDbNotificationSettings     = isset($userNotificationSettings['medium']['inApp']) ? $userNotificationSettings['medium']['inApp'] : false;

        // (site) notification settings
        $siteEmailNotificationSettings  = config('services.notifications')['email'];
        $siteDbNotificationSettings     = config('services.notifications')['inApp'];


        //For admin
        if(
            $this->data['type'] == 'newAgencyRegistration' ||
            $this->data['type'] == 'newPerformerUserRegistration' ||
            $this->data['type'] == 'addToContactforAdmin' ||
            $this->data['type'] == 'mediaPurchaseforAdmin' ||
            $this->data['type'] == 'userMembershipPurchaseForAdmin' ||
            $this->data['type'] == 'reportedPostRemoveNotification'
        ){
            array_push($sendNotification, 'database');
        }

        //mandatory email notification
        if($siteEmailNotificationSettings &&
            ($this->data['type'] == 'registrationComplete' ||
            $this->data['type'] == 'registrationCompleteByAgency' ||
            $this->data['type'] == 'emailVerify' ||
            $this->data['type'] == 'emailVerification' ||
            $this->data['type'] == 'emailVerifyResend' ||
            $this->data['type'] == 'emailVerified' ||
            $this->data['type'] == 'resetPassword' ||
            $this->data['type'] == 'passwordChanged' ||
            $this->data['type'] == 'emailChanged' ||
            $this->data['type'] == 'accountApproved' ||
            $this->data['type'] == 'accountUnapproved' ||
            $this->data['type'] == 'accountBan' ||
            $this->data['type'] == 'accountActive' ||
            $this->data['type'] == 'userMembershipPurchase' ||
            $this->data['type'] == 'postConsentSendToModel')
        ){
            array_push($sendNotification, 'mail');
        }

        if($userEmailNotificationSettings && $siteEmailNotificationSettings)
        {
            if($this->data['type'] == 'newReview'){
                $sendEmail = true;
            }

            if($sendEmail){
                array_push($sendNotification, 'mail');
            }
        }
        return $sendNotification;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if(!empty($this->user->first_name)){
            $nameParts = explode(' ', trim($this->user->first_name));
            $firstName = ucfirst($nameParts[0]);
        } else{
            $firstName = $this->user->username ?? "User";
        }


        $mailData                   = [];
        $mailData['to']             = $this->user->email;
        $mailData['from']           = config('services.email_configuration')['site_mail_from'];
        $mailData['reply_to']       = config('services.email_configuration')['site_reply_to'];
        $mailData['greetings']      = 'Dear ' . $firstName . ',';
        $mailData['end_greetings']  = config('services.email_configuration')['site_mail_greetings'];
        $mailData['from_user']      = config('services.email_configuration')['site_mail_greetings_from'];
        // $mailData['subject']        = 'Mail from Canably';//$this->data['subject'];
        // $mailData['line']           = $this->data['line'];

        if($this->data['type'] == 'registrationComplete'){//queue

            $mailData['line'] = 'Welcome to Canably!';
            $mailData['link']           = route('login');
            $mailData['button']         = 'Login';
            $mailData['subject']        = 'Welcome to Canably!';
           // $mailData['line']           = 'Your registration has been successful as ' . $accountType . ' Please copy the below code and put it on your site to verify your email address. '.$this->user->verification_code.'. Click to below button for login to continue. Thank you for register with us.';
        }else if($this->data['type'] == 'emailVerify'){//instant
            $mailData['link']           = '';
            $mailData['button']         = $this->user->verification_code;
            $mailData['subject']        = 'Customer Email Verification';
            $mailData['content']        = 'Your Password is '.$this->data['password'] ?? '';
            $mailData['line']           = 'Please copy the below code and put it on your site to verify your email address.';
        }else if($this->data['type'] == 'emailVerification'){//instant
            $mailData['link']           = route('login');
            $mailData['button']         = 'login';
            $mailData['subject']        = 'Customer Credentials';
            $mailData['content']        = 'Your Password is '.$this->data['password'] ?? '';
            $mailData['line']           = 'Please copy the below code and put it on your site to verify your email address.';
        }else if($this->data['type'] == 'emailVerifyResend'){//instant
            $mailData['link']           = '';
            $mailData['button']         = $this->user->verification_code;
            $mailData['subject']        = 'User Email Verify resend';
            $mailData['line']           = 'This is duplicate email for email verification. Please copy the below code and put it on your site to verify your email address.';
        }else if($this->data['type'] == 'emailVerified'){//queue

            if($this->user->roles()->first->slug == 'customer'){
                $accountType = 'Customer account. Continue and enjoy our service.';
            }else if($this->user->roles()->first->slug == 'seller'){
                $accountType = 'Seller account. Your account is being verified by the administrator. We will notify you once it approves for full access.';
            }

            $mailData['link']           = '';
            $mailData['button']         = '';
            $mailData['subject']        = 'Email verification successful';
            $mailData['line']           = 'Your email address has been successfully verified with us. You are register as '.$accountType ;
        }
        // email notification Reset Password
        else if($this->data['type'] == 'resetPassword'){//instant
            $mailData['link']           = url(route('password.reset', ['token' => $this->data['token'], 'email' => $notifiable->getEmailForPasswordReset()], false));
            $mailData['button']         = 'Reset Password';
            $mailData['subject']        = 'Reset Password';
            $mailData['line']           = 'Please click on the below button to reset your password.';
        }
        // email notification Password Changed
        else if($this->data['type'] == 'passwordChanged'){//queue
            $mailData['link']           = route('login');
            $mailData['button']         = 'Support';
            $mailData['subject']        = 'Password has been Updated';
            $mailData['line']           = 'Your profile password has been updated successfully. If this is not done by you please contact support immediately.';
        }
        else if($this->data['type'] == 'emailChanged'){//queue
            $mailData['link']           = route('login');
            $mailData['button']         = 'Support';
            $mailData['subject']        = 'Email change ';
            $mailData['line']           = 'Your profile Email has been updated successfully. If this is not done by you please contact support immediately.';
        }
        // email notification Account Approved
        else if($this->data['type'] == 'accountApproved'){//queue
            $mailData['link']           = route('login');
            $mailData['button']         = 'Login';
            $mailData['subject']        = 'Account approved ';
            $mailData['line']           = 'Your account has been approved. Login to continue.';
        }else if($this->data['type'] == 'accountUnapproved'){//queue
            $mailData['link']           = route('login');
            $mailData['button']         = 'Support';
            $mailData['subject']        = 'Account unapproved ';
            $mailData['line']           = 'Your account has been unapproved. Contact to support for more details.';
        }else if($this->data['type'] == 'accountBan'){//queue
            $mailData['link']           = route('login');
            $mailData['button']         = 'Support';
            $mailData['subject']        = 'Account banned from admin';
            $mailData['line']           = 'Your account has been banned. Contact to support for more details.';
        }else if($this->data['type'] == 'accountActive'){//queue
            $mailData['link']           = route('login');
            $mailData['button']         = 'Login';
            $mailData['subject']        = 'Account activated from admin';
            $mailData['line']           = 'Your account has been activated. Log In to continue.';
        }
        else if(
                $this->data['type'] == 'textMessage' ||
                $this->data['type'] == 'videoMessage' ||
                $this->data['type'] == 'imageMessage'
                ){//queue
            $mailData['link']           = route('login');
            $mailData['button']         = 'Message';
            $mailData['subject']        = 'New message from ' . $this->data['from_user_name'];
            $mailData['line']           = 'You have received a new ' . $this->data['message_type'] . ' message from ' . $this->data['from_user_name'] . '. Click to below button to see the message.';
        }
        else if($this->data['type'] == 'packageExpiredSoon'){//queue
            $mailData['link']           = route('login');
            $mailData['button']         = 'Package';
            $mailData['subject']        = 'Your package subcription will be expired soon';
            $mailData['line']           = 'Your package subcription will be expired soon. Please renew your package subcription for use continuously.';
        }else if($this->data['type'] == 'packageExpired'){//queue
            $mailData['link']           = route('login');
            $mailData['button']         = 'Package';
            $mailData['subject']        = 'Your package subcription expired';
            $mailData['line']           = 'Your package subcription has expired. Please renew your package subcription for continue use.';
        }
        else if($this->data['type'] == 'userMembershipPurchase'){//queue
            $mailData['link']           = route('login');
            $mailData['button']         = 'Escorts';
            $mailData['subject']        = $this->data['package_name'] . ' - package purchased';
            $mailData['line']           = 'You have successfully purchase '. $this->data['package_name']. ' package by spending '.config('services.currency')['symbol'] . $this->data['debit_amount'] .'.' ;
        }else


        if($this->data['type'] == 'newReview'){//queue
            $mailData['subject'] = $this->data['db_notification_body'];
            $mailData['line']    = $this->data['db_notification_body'];
        }

        return (new SiteEmail($mailData));
    }

    /**
     * Get the text representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return boolean
     */
    public function toTextMessage($notifiable)
    {
        return (new TextMessage)
        ->content($this->data['from_user_name'] . ' send you a new ' . $this->data['message_type'] . ' message. Go to your message section to see the message. -Canably');
    }

    /**
     * Get the text representation of the db notification.
     *
     * @param  mixed  $notifiable
     * @return data
     */
    /**
     * Get the text representation of the db notification.
     *
     * @param  mixed  $notifiable
     * @return data
     */
    public function toDatabase($notifiable)
    {
        $mailData['subject'] = '';
        $mailData['line']    = '';
        $mailData['data']    = '';


        if($this->data['type'] == 'newAgencyRegistration' ||
            $this->data['type'] == 'newPerformerUserRegistration' ||
            $this->data['type'] == 'addToContactforAdmin' ||
            $this->data['type'] == 'mediaPurchaseforAdmin' ||
            $this->data['type'] == 'userMembershipPurchaseForAdmin'
        ){//queue  //for admin
            $mailData['subject']        = $this->data['db_notification_body'];
            $mailData['line']           = $this->data['db_notification_body'];
            $mailData['data']           = $this->data['db_notification_data'];
        }


        return [
            'title'     => $mailData['subject'],
            'message'   => $mailData['line'],
            'data'      => $mailData['data']
        ];
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
