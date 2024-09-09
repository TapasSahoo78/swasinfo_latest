<?php

namespace App\Models;

use App\Traits\HasRolesAndPermissions as TraitsHasRolesAndPermissions;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;
use Webpatser\Uuid\Uuid;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, TraitsHasRolesAndPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_picture',
        // 'login_id'
        // 'logo_picture'
    ];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
        // self::deleting(function ($query) {
        //     $query->roles()->detach();
        // });
        // self::deleting(function ($query) {
        //     $query->trainerProfile()->detach();
        // });
    }
    protected $fillable = [
        'id',
        'name_prefix',
        'first_name',
        'title',
        'last_name',
        'uuid',
        'email',
        'mobile_number',
        'password',
        'username',
        'login_id',
        'mfi_id',
        'email_verified_at',
        'is_profile_completed',
        'is_password_changed',
        'verification_code',
        'is_active',
        'is_blocked',
        'is_advance',
        'fcm_token',
        'plan_expire',
        'payment_type',
        'payment_date',
        'transaction_id',
        'dietitian_id',
        'trainer_id',
        'created_by',
        'is_email',
        'is_subscribed',
        'pickup_address',
        'otp_verify',
        'type',
        'facebook_id',
        'googleplus_id',
        'refer_code_go',
        'refer_code_come',
        'igst',
        'cgst'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // 'id',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'two_factor_expires_at' => 'datetime',
        'notifications' => 'array',
        // 'address'                => 'array',
    ];

    public function generateUserName($userType, $name)
    {
        $number = mt_rand(100000, 999999);
        $username = $userType . substr($name, 3) . $number;
        if ($this->usernameexists($username)) {
            return $this->generateUsername($userType, $name);
        }
        return $username;
    }

    public function generateTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = rand(10000, 99999);
        $this->two_factor_expires_at = now()->addMinutes(2);
        $this->save();
    }

    public function resetTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function trainerProfile()
    {
        return $this->hasOne(UserTrainerProfile::class, 'user_id');
    }

    public function trainerDetail()
    {
        return $this->hasOne(TrainerDetail::class, 'user_id');
    }



    public function profileOtherInformation()
    {
        return $this->hasOne(ProfileOtherInformation::class, 'user_id');
    }

    public function trainerCustomerRequest()
    {
        return $this->hasOne(TrainerCustomerRequest::class, 'user_id');
    }


    public function userHealthScreenOneDetails()
    {
        return $this->hasOne(UserHealthschedule::class, 'user_id');
    }
    public function userHealthScreenTwoDetails()
    {
        return $this->hasOne(UserHealthScheduleScreenTwo::class, 'user_id');
    }
    public function userHealthScreenThreeDetails()
    {
        return $this->hasOne(UserHealthScheduleScreenThree::class, 'user_id');
    }

    public function personalDetail()
    {
        return $this->hasOne(CustomerPersonalDetail::class);
    }
    public function familyDetails()
    {
        return $this->hasMany(CustomerFamilyDetail::class);
    }
    public function propertyDetails()
    {
        return $this->hasMany(CustomerPropertyDetail::class);
    }
    public function otherLoansDetails()
    {
        return $this->hasMany(CustomerOtherLoanDetail::class);
    }

    public function bankDetails()
    {
        return $this->hasOne(CustomerBankDetail::class);
    }
    public function kycDetails()
    {
        return $this->hasOne(CustomerKycVerification::class);
    }

    public function device()
    {
        return $this->hasMany(Device::class);
    }
    public function mfi()
    {
        return $this->belongsTo(Mfi::class);
    }
    public function branch()
    {
        return $this->hasOne(UserBranch::class);
    }
    public function getProfilePictureAttribute()
    {
        return $this->profilePicture();
    }
    public function getLocationPictureAttribute()
    {
        return $this->locationPicture();
    }
    public function getAadhaarPictureAttribute()
    {
        return $this->aadhaarPicture();
    }
    public function getCustomerPictureAttribute()
    {
        return $this->profilePicture('original/user');
    }

    public function getCustomerLowbloodAttribute()
    {
        return $this->lowblood('original/user');
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . (!is_null($this->last_name) ? ' ' . $this->last_name : '');
    }
    public function profilePicture($type = 'profile')
    {
        $profilePicture = $this->media()->where('is_profile_picture', 1)->value('file');

        if (!is_null($profilePicture)) {
            $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');

            if ($fileDisk == 'public') {
                $image = public_path('storage/images/' . $type . '/' . $profilePicture);
                if (file_exists(public_path('storage/images/' . $type . '/' . $profilePicture))) {
                    return asset('storage/images/' . $type . '/' . $profilePicture);
                }
            }
        }
        return asset('assets/images/pro_img.jpg');
    }


    public function getCustomerHighcholesterolAttribute()
    {
        return $this->highcholesterol('original/user');
    }

    public function highcholesterol($type = 'profile')
    {
        $profilePicture = $this->media()->where('is_high_cholesterol_prescription', 1)->value('file');

        if (!is_null($profilePicture)) {
            $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');

            if ($fileDisk == 'public') {
                $image = public_path('storage/images/' . $type . '/' . $profilePicture);
                if (file_exists(public_path('storage/images/' . $type . '/' . $profilePicture))) {
                    return asset('storage/images/' . $type . '/' . $profilePicture);
                }
            }
        }
        return asset('assets/images/pro_img.jpg');
    }

    public function getCustomerHiabitiesprescriptionAttribute()
    {
        return $this->diabitiesprescription('original/user');
    }

    public function diabitiesprescription($type = 'profile')
    {
        $profilePicture = $this->media()->where('is_diabities_prescription', 1)->value('file');

        if (!is_null($profilePicture)) {
            $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');

            if ($fileDisk == 'public') {
                $image = public_path('storage/images/' . $type . '/' . $profilePicture);
                if (file_exists(public_path('storage/images/' . $type . '/' . $profilePicture))) {
                    return asset('storage/images/' . $type . '/' . $profilePicture);
                }
            }
        }
        return asset('assets/images/pro_img.jpg');
    }


    public function getCustomerUricacidAttribute()
    {
        return $this->uricacid('original/user');
    }

    public function uricacid($type = 'profile')
    {
        $profilePicture = $this->media()->where('is_uric_acid_prescription', 1)->value('file');

        if (!is_null($profilePicture)) {
            $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');

            if ($fileDisk == 'public') {
                $image = public_path('storage/images/' . $type . '/' . $profilePicture);
                if (file_exists(public_path('storage/images/' . $type . '/' . $profilePicture))) {
                    return asset('storage/images/' . $type . '/' . $profilePicture);
                }
            }
        }
        return asset('assets/images/pro_img.jpg');
    }


    public function getCustomerAsthmaAttribute()
    {
        return $this->asthma('original/user');
    }

    public function asthma($type = 'profile')
    {
        $profilePicture = $this->media()->where('is_asthma_prescription', 1)->value('file');

        if (!is_null($profilePicture)) {
            $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');

            if ($fileDisk == 'public') {
                $image = public_path('storage/images/' . $type . '/' . $profilePicture);
                if (file_exists(public_path('storage/images/' . $type . '/' . $profilePicture))) {
                    return asset('storage/images/' . $type . '/' . $profilePicture);
                }
            }
        }
        return asset('assets/images/pro_img.jpg');
    }

    public function getCustomerMedicationAttribute()
    {
        return $this->medication('original/user');
    }

    public function medication($type = 'profile')
    {
        $profilePicture = $this->media()->where('is_medication_prescription', 1)->value('file');

        if (!is_null($profilePicture)) {
            $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');

            if ($fileDisk == 'public') {
                $image = public_path('storage/images/' . $type . '/' . $profilePicture);
                if (file_exists(public_path('storage/images/' . $type . '/' . $profilePicture))) {
                    return asset('storage/images/' . $type . '/' . $profilePicture);
                }
            }
        }
        return asset('assets/images/pro_img.jpg');
    }


    public function getCustomerPrescriptionAttribute()
    {
        return $this->prescription('original/user');
    }

    public function prescription($type = 'profile')
    {
        $profilePicture = $this->media()->where('is_prescription', 1)->value('file');

        if (!is_null($profilePicture)) {
            $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');

            if ($fileDisk == 'public') {
                $image = public_path('storage/images/' . $type . '/' . $profilePicture);
                if (file_exists(public_path('storage/images/' . $type . '/' . $profilePicture))) {
                    return asset('storage/images/' . $type . '/' . $profilePicture);
                }
            }
        }
        return asset('assets/images/pro_img.jpg');
    }



    public function lowblood($type = 'profile')
    {
        $profilePicture = $this->media()->where('is_low_blood_pressure_prescription', 1)->value('file');

        if (!is_null($profilePicture)) {
            $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');

            if ($fileDisk == 'public') {
                $image = public_path('storage/images/' . $type . '/' . $profilePicture);
                if (file_exists(public_path('storage/images/' . $type . '/' . $profilePicture))) {
                    return asset('storage/images/' . $type . '/' . $profilePicture);
                }
            }
        }
        return asset('assets/images/pro_img.jpg');
    }




    public function locationPicture($type = 'location')
    {
        $locationPicture = $this->media()->where('is_location', 1)->value('file');
        // return $profilePicture;
        if (!is_null($locationPicture)) {

            $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');
            if ($fileDisk == 'public') {
                if (file_exists(public_path('storage/images/original/' . $type . '/' . $locationPicture))) {
                    return asset('storage/images/original/' . $type . '/' . $locationPicture);
                }
            }
        }

        return asset('assets/images/pro_img.jpg');
    }
    public function aadhaarPicture($type = 'aadhaar')
    {
        $aadhaarPicture = $this->media()->where('is_aadhaar', 1)->value('file');
        // return $profilePicture;
        if (!is_null($aadhaarPicture)) {

            $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');
            if ($fileDisk == 'public') {
                if (file_exists(public_path('storage/images/original/' . $type . '/' . $aadhaarPicture))) {
                    return asset('storage/images/original/' . $type . '/' . $aadhaarPicture);
                }
            }
        }

        return asset('assets/images/pro_img.jpg');
    }

    public function mediaImage()
    {
        return $this->morphOne('App\Models\Media', 'mediaable')->where('deleted_at', null)->orderBy('id', 'DESC');
    }
    public function media(): HasMany
    {
        return $this->hasMany(Media::class, 'user_id', 'id');
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'user_branches');
    }
    public function fitness()
    {
        return $this->belongsToMany(FitnessGoal::class, 'user_fitness_activations');
    }
    public function physicalCondition()
    {
        return $this->belongsToMany(UserPhysicallyActiveConditions::class, 'user_physical_activations');
    }
    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class, 'user_roles');
    // }
    /* public function roles(){
    return $this->belongsToMany(Role::class, 'user_roles');
    } */

    public function document()
    {
        return $this->morphMany(Document::class, 'documentable');
    }
    public function demands()
    {
        return $this->hasMany(CustomerDemand::class, 'user_id')->orderBy('id', 'desc');
    }
    public function pendingDemands()
    {
        return $this->hasMany(CustomerDemand::class, 'user_id')->orderBy('id', 'desc');
    }
    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function scopeActive($query, $type)
    {
        return $query->whereHas(
            'roles',
            function ($q) use ($type) {
                $q->where('slug', $type);
            }
        )->where('is_active', '1');
    }

    public function scopeInactive($query, $type)
    {
        return $query->whereHas(
            'roles',
            function ($q) use ($type) {
                $q->where('slug', $type);
            }
        )->where('is_active', '0');
    }

    public function scopeUsernameexists($query, $username)
    {
        return $query->where('username', $username)->exists();
    }
    /* public function addressBook(){
return $this->hasOne(Address::class);
} */


    public function scopeListUser($query, $role = "", $excludeRoles = [])
    {
        $branch_ids = getAllBranchIds();
        // dd($branch_ids);
        $query->where('mfi_id', auth()->user()->mfi->id)->whereHas('branch', function ($q) use ($branch_ids) {
            $q->whereIn('branch_id', $branch_ids);
        });
        if (!empty($role)) {
            $query->whereHas('roles', function ($q) use ($role) {
                $q->where('slug', $role);
            });
        }
        if (!empty($excludeRoles) && count($excludeRoles)) {
            $query->whereHas('roles', function ($q) use ($excludeRoles) {
                $q->whereNotIn('slug', $excludeRoles);
            });
        }
        return $query;
    }
    public function userFoodDetails()
    {
        return $this->belongsToMany(UserFoodItems::class, 'user_food_items');
    }

    public function userItemFoodDetails()
    {
        // return $this->belongsTo(UserFoodItemDetail::class, 'food_id');
        return $this->hasMany(UserFoodItemDetail::class, 'user_id');
    }


    public function subscribedDetails()
    {
        return $this->hasOne(Plan::class, 'id', 'payment_type');
        // return $this->hasOne(UserHealthScheduleScreenThree::class, 'user_id')
    }

    public function paymentType()
    {
        return $this->belongsTo(Plan::class, 'payment_type', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function gymPersonalDetails()
    {
        return $this->hasOne(GymTrainerPersonalDetail::class);
    }
    public function gymBusinessDetails()
    {
        return $this->hasOne(GymTrainerBusinessDetail::class);
    }
    public function gymCenterDetails()
    {
        return $this->hasOne(GymManagement::class);
    }
}
