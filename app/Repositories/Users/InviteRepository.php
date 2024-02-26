<?php
namespace App\Repositories\Users;

use App\Models\Role;
use App\Models\User;
use App\Mail\SendMailable;
use App\Traits\UploadAble;
use Illuminate\Support\Carbon;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Mail;
use App\Contracts\Users\InviteContract;

/**
 * Class InviteRepository
 *
 * @package \App\Repositories
 */
class InviteRepository extends BaseRepository implements InviteContract
{
    use UploadAble;
    /**
     * InviteRepository constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function createInvite($params){
    	$isUserCreated= $this->create([
    		'first_name' 			=> $params['first_name'],
    		'last_name' 			=> $params['last_name'],
    		'email' 			    => $params['email'],
    		'email_verified_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
    		'mobile_number'         => $params['phone_no'],
            'password'              => bcrypt($params['password']),
    	]);
        if($isUserCreated){
            $isRole= Role::find($params['role_id']);
            $isUserCreated->roles()->attach($isRole);
        }
        if($isUserCreated && isset($params['admin_image'])){
            $fileName= uniqid().'.'.$params['admin_image']->getClientOriginalExtension();
            $isUserRelatedMediaUploaded= $this->uploadOne($params['admin_image'],config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName,'public');
            if($isUserRelatedMediaUploaded){
                $isUserCreated->media()->create([
                    'user_id'=> $isUserCreated->id,
                    'mediaable_type' =>get_class($isUserCreated),
                    'mediaable_id' => $isUserCreated->id,
                    'media_type' => 'image',
                    'file'=> $fileName,
                    'is_profile_picture' => true
                ]);
            }
        }
        if($isUserCreated){
            $mailParams                     = array();
            $mailParams['mail_type']        = 'admin_invite';
            $mailParams['to']               = $params['email'];
            $mailParams['from']             = config('mail.from.address');
            $mailParams['subject']          = $isRole->name.' Invitation from '.env('APP_NAME');
            $mailParams['greetings']        = "Hello ! User";
            $mailParams['line']             = 'You have been invited to become an '.$isRole->name.' at ' . env('APP_NAME');
            $mailParams['content']          = "Click on the button below to login as an ".$isRole->name.".";
            $mailParams['link']             = route('login');
            $mailParams['end_greetings']    = "Regards,";
            $mailParams['from_user']        = env('MAIL_FROM_NAME');
            Mail::send(new SendMailable($mailParams));
        }

        return $isUserCreated;
    }
}
