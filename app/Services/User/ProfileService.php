<?php

namespace App\Services\User;

use App\Traits\UploadAble;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Contracts\Post\MediaContract;
use App\Contracts\Users\RateContract;
use App\Contracts\Users\UserContract;
use App\Services\Location\CityService;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    use UploadAble;
    /**
     * @var UserContract
     */
    protected $userRepository;

    /**
     * @var RateContract
     */
    protected $rateRepository;

    /**
     * @var MediaContract
     */
    protected $mediaRepository;

    protected $cityService;

	/**
     * UserService constructor
     */
    public function __construct(
        UserContract $userRepository,
        RateContract $rateRepository,
        MediaContract $mediaRepository,
        CityService $cityService,
    )
    {
        $this->userRepository  = $userRepository;
        $this->rateRepository  = $rateRepository;
        $this->mediaRepository = $mediaRepository;
        $this->cityService  = $cityService;
    }

     /**
     * Update user profile different details
     *
     * @param string $tag
     * @param array $attributes
     * @param int $userId
     * @return bool|\Illuminate\Database\Eloquent\Model
     */
    public function saveUserProfileDetails(string $tag, array $attributes, int $userId)
    {
        
        $user = $this->userRepository->find($userId);

        if($tag == 'profileBasicDetails'){
            $attributes['phone_number'] = $attributes['phone_number'] ?? '';
            //unset($attributes['phone_code']);

            return $user->update($attributes);
        }else if($tag == 'profileContactDetails'){
            $userAttributes = [];
            $userAttributes['phone_number']     = $attributes['phone_number'];
            $userAttributes['message_number']   = $attributes['message_number'];
            $user->update($userAttributes);
            $profileId = $user->profile->id;
            return $user->profile()->update(['contactmethod' => $attributes['contactmethod']], $profileId);
        }else if($tag == 'profileAllDetails'){
            if(isset($attributes['display_name'])) $user->update(['display_name' => $attributes['display_name']]);
            if(isset($attributes['phone_number'])) $user->update(['phone_number' => $attributes['phone_number']]);
            $profileId = $user->profile->id;
            $this->rateRepository->createRate($attributes, $userId);
            unset($attributes['rates']);
            unset($attributes['display_name']);
            unset($attributes['phone_number']);
            $attributes['aboutme']= strip_tags($attributes['aboutme']) ?? null;

            if(isset($attributes['city']) && !empty($attributes['city'])) {
                //dd(gettype($attributes['city']));
                $cityId = $attributes['city'];
                $theCity = $this->cityService->findByID($cityId);
                if($theCity){
                    $attributes['city_id'] = $theCity->id;
                    $attributes['state_id'] = $theCity->state_id;
                    $attributes['country_id'] = $theCity->country_id;
                }                
            }
            unset($attributes['city']);

            return $user->profile()->update($attributes, $profileId);
        }else if($tag == 'profileSocialUrls'){
            return $user->profile()->update($attributes, $userId);
        }else if($tag == 'agencyDetails'){
            // dd($attributes);
            $userData['display_name']= $attributes['display_name'] ?? null;
            $userData['phone_number']= $attributes['phone_number'] ?? null;
            $profileData['contact_email']= $attributes['contact_email'] ?? null;
            if(isset($attributes['city']) && !empty($attributes['city'])) {                
                $cityId = $attributes['city'];
                $theCity = $this->cityService->findByID($cityId);
                if($theCity){
                    $profileData['city_id'] = $theCity->id;
                    $profileData['state_id'] = $theCity->state_id;
                    $profileData['country_id'] = $theCity->country_id;
                }                
            }                       
            $profileData['aboutme']= strip_tags($attributes['aboutme']) ?? null;
            $this->userRepository->update($userData, $userId);
            return $user->profile()->update($profileData, $userId);
        }else if($tag == 'profileRateDetails'){
            return $this->rateRepository->createRate($attributes, $userId);
        }else if($tag == 'profileServiceDetails'){
            $profileId = $user->profile->id;
            return $user->profile()->update($attributes, $profileId);
        }else if($tag == 'profileAvailability'){
            return $user->profile()->update($attributes, $userId);
        }else if($tag == 'profileLocation'){
            return $this->userRepository->updateUserLocation($attributes, $userId);
        }else if($tag == 'locationRemove'){
            $userlocationid = uuidtoid($attributes['userlocationid'], 'user_locations');
            $location = $user->userlocations()->find($userlocationid);
            return $location->delete();
        }else if($tag == 'profileAboutDetails'){
            if($attributes['country']){
                $attributes['country'] = customfind($attributes['country'], 'countries')->slug;
            }if($attributes['state']){
                $attributes['state'] = customfind($attributes['state'], 'states')->slug;
            }if($attributes['city']){
                $attributes['city'] = customfind($attributes['city'], 'cities')->slug;
            }
            $profileId = $user->profile->id;
            return $user->profile()->update($attributes, $profileId);
        }else if($tag == 'ProfileFanDetails'){
            $profileData= [];
            $userData= [];
            $profileId = $user->profile->id;
            if(isset($attributes['occupation'])){
                $profileData['occupation']= $attributes['occupation'];
            }
            if(isset($attributes['ethnicity'])){
                $profileData['ethnicity']= $attributes['ethnicity'];
            }
            if(isset($attributes['aboutme'])){
                $profileData['aboutme']= $attributes['aboutme'];
            }
            if(isset($attributes['birthday'])){
                $profileData['birthday']= $attributes['birthday'];
            }
            if(isset($attributes['phone_number'])){
                $userData['phone_number']= $attributes['phone_number'];
            }
            $user->update($userData);
            return $user->profile()->update($profileData, $profileId);
        }else if($tag == 'profileImageChange'){
            $user->media()->update([
                            'is_profile_picture' => 0
                        ], $userId);
            $mediaId = uuidtoid($attributes['mediaId'], 'medias');
            return $this->mediaRepository->update(['is_profile_picture' => 1], $mediaId);
        }else if($tag == 'profileImage'){
            return $this->userRepository->updateProfileImage($attributes['rawImageContent'], $userId);
        }else if($tag == 'mediaDelete'){
            $mediaId = uuidtoid($attributes['mediaId'], 'medias');
            $media = $this->mediaRepository->find($mediaId);
            if($media && !$media->is_profile_picture){
                $pathArray=['collection','cover','original','post','profile','thumbnail'];
                $deleted = $media->delete();
                $delete = $media->post()->delete();
                if($deleted){
                    $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');
                    if($fileDisk == 's3'){
                        $storageDisk = Storage::disk('s3');
                        foreach ($pathArray as $path) {
                            if($storageDisk->exists('images/'.$path.'/'.$media->file)){
                                $this->deleteOne('images/'.$path.'/'.$media->file);
                            }
                        }
                    }else if($fileDisk == 'public'){
                        foreach ($pathArray as $path) {
                            if(file_exists(public_path().'/storage/images/'.$path.'/'.$media->file)){
                                unlink(public_path().'/storage/images/'.$path.'/'.$media->file);
                            }
                        }
                    }

                    return 'deleted';
                }
            }else{
                return 'prflpic';
            }
            return false;
            return $this->mediaRepository->delete($mediaId);
        }else if($tag== 'changeOnlinestatus'){
            return $this->userRepository->update($attributes, $userId);
        }else if($tag== 'changeprofilestatus'){
            return $this->userRepository->update($attributes, $userId);
        }else if($tag== 'setBumptime'){
        }else if($tag== 'setMetadetails'){
            $profileId = $user->profile->id;
            return $user->profile()->update($attributes, $profileId);
        }else if($tag == 'profileNotificationSettings'){
            $profileId = $user->profile->id;
            return $user->profile()->update($attributes, $profileId);
        }else if($tag == 'profileChangePassword'){
            $attributes['password'] = Hash::make($attributes['password']);
            return $this->userRepository->update($attributes, $userId);
        }else if($tag == 'profileChangeEmail'){
            return $this->userRepository->update($attributes, $userId);
        }else if($tag == 'profileTwoFactorSettings'){
            return $user->update($attributes);
        }else if($tag == 'savebasic'){
            $attributes['aboutme']= strip_tags($attributes['aboutme']);
            return $user->profile()->update($attributes);
        }



        /*else if($tag == 'profileDisplayStatus'){
            return $this->userRepository->update($attributes, $userId);
        }else if($tag == 'profileRegionSettings'){
            $profileId = $user->profile->id;
            return $user->profile()->update($attributes, $profileId);
        }else if($tag == 'profileStatDetails'){
            $profileId = $user->profile->id;
            return $user->profile()->update($attributes, $profileId);
        }else if($tag == 'profileSubscriptionAmount'){
            $profileId = $user->profile->id;
            return $user->profile()->update($attributes, $profileId);
        } */

    }

    public function deleteUserDetails(int $id){
        return $this->userRepository->delete($id);
    }
    /**
     * Validate user existing password
     *
     * @param string $password
     * @param int $userId
     * @return bool
     */
    public function validatePassword(string $password, int $userId)
    {
        $currentHashedPassword = $this->userRepository->find($userId)->password;
        return Hash::check($password, $currentHashedPassword);
    }
    public function validateEmail(string $email, int $userId){
        $currentEmail = $this->userRepository->find($userId)->email;
        return $currentEmail==$email ? true : false;
    }

    /**
     * Update user notification preferences
     *
     * @param array $attributes
     * @param int $userId
     * @return bool
     */
    public function saveUserNotificationPreferences(array $attributes, int $userId)
    {
        $user = $this->userRepository->find($userId);
        return $user->profile()->update($attributes, $userId);
    }
}
