<?php

namespace App\Repositories\Users;


use App\Models\Role;
use App\Models\User;
use App\Models\CustomerKycVerification;
use App\Models\CustomerDemand;
use App\Models\UserFoodItemDetail;
use App\Models\Address;
use App\Models\Document;
use App\Models\Lead;
use App\Models\FitnessGoal;
use App\Models\FoodItems;
use App\Models\UserPhysicallyActiveConditions;
use App\Mail\SendMailable;

use App\Traits\UploadAble;
use Illuminate\Support\Str;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Mail;
use App\Contracts\Users\UserContract;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Plan;
use Carbon\Carbon;


/**
 * Class UserRepository
 *
 * @package \App\Repositories
 */
class UserRepository extends BaseRepository implements UserContract
{
    use UploadAble;
    protected $model;
    protected $permissionModel;
    protected $userFoodItemModel;
    protected $documentModel;
    protected $roleModel;
    protected $fitnessGoalModel;
    protected $foodItemsModel;
    protected $userPhysicallyActiveConditions;
    protected $addressModel;
    protected $productModel;
    protected $branchModel;
    protected $leadModel;

    protected $kycDetailsModel;
    protected $customerDemandModel;
    /**
     * UserRepository constructor.
     * @param User $model
     * @param Permission $permissionModel
     * @param Document $documentModel
     * @param Role $roleModel
     * @param Address $addressModel
     * @param Product $productModel
     * @param Branch $branchModel
     * @param CustomerKycVerification $kycDetailsModel
     * @param CustomerDemand $customerDemandModel
     */
    public function __construct(
        User $model,
        Permission $permissionModel,
        UserFoodItemDetail $userFoodItemModel,
        Document $documentModel,
        Role $roleModel,
        FitnessGoal $fitnessGoalModel,
        FoodItems $foodItemsModel,
        UserPhysicallyActiveConditions $userPhysicallyActiveConditions,
        Address $addressModel,
        Product $productModel,
        Branch $branchModel,
        Lead $leadModel,
        CustomerKycVerification $kycDetailsModel,
        CustomerDemand $customerDemandModel
    ) {
        parent::__construct($model);
        $this->model            = $model;
        $this->permissionModel  = $permissionModel;
        $this->documentModel    = $documentModel;
        $this->roleModel        = $roleModel;
        $this->addressModel     = $addressModel;
        $this->userFoodItemModel     = $userFoodItemModel;
        $this->productModel     = $productModel;
        $this->branchModel      = $branchModel;
        $this->leadModel      = $leadModel;
        $this->fitnessGoalModel      = $fitnessGoalModel;
        $this->foodItemsModel      = $foodItemsModel;
        $this->userPhysicallyActiveConditions      = $userPhysicallyActiveConditions;

        $this->kycDetailsModel  = $kycDetailsModel;
        $this->customerDemandModel  = $customerDemandModel;
    }



    public function findUsers($profileType, $filterConditions = null, $orderBy = 'id', $sortBy = 'desc', $limit = null, $inRandomOrder = false)
    {
        $query = $this->model->where('profile_type', $profileType)->with('profile');


        if (!is_null($filterConditions)) {
            $query = $query->where($filterConditions);
        }

        if ($inRandomOrder) {
            $query = $query->inRandomOrder();
        } else {
            //$query = $query->orderBy('autoboost_time', 'desc');
            //$query = $query->orderBy('membership_plan', 'desc');
            $query = $query->orderBy($orderBy, $sortBy);
        }
        if (!is_null($limit)) {
            return $query->paginate($limit);
        }

        return $query->get();
    }

    public function userSearch(
        $profileType,
        $filterConditions = null,
        $orderBy = 'id',
        $sortBy = 'desc',
        $limit = null,
        $inRandomOrder = false
    ) {
        $query = $this->model
            ->where('profile_type', $profileType)
            ->with('profile');

        if ($profileType == 'performer') {
            $query = $query->where(function ($query) {
                $query->where('membership_plan', '>', 0)
                    ->where('is_hidden', 0)
                    ->where('package_status', true);
            });
        }
        if (!is_null($filterConditions)) {
            foreach ($filterConditions as $fKey => $fCondition) {
                if (in_array($fKey, array('servicesoffered', 'idonotoffer', 'category'))) {
                    $query = $query->whereHas('profile', function (Builder $query) use ($fKey, $fCondition) {
                        if (!in_array('All', $fCondition)) {
                            $query->whereJsonContains($fKey, $fCondition);
                        }
                    });
                } elseif (in_array($fKey, array('gender', 'measurements', 'icaterto', 'ethnicity', 'servicetype', 'paymentmethod', 'bodytype', 'country', 'state', 'city', 'nationality'))) {
                    $query = $query->whereHas('profile', function (Builder $query) use ($fKey, $fCondition) {
                        $query->where($fKey, $fCondition);
                    });
                }
            }
        }

        if ($inRandomOrder) {
            $query = $query->inRandomOrder();
        }
        $models = $query->get();
        // dump($models->pluck('id')->toArray());

        // foreach($models as $model){
        //     dump($model->id .' -- '.$model->boost_sort_date_time .' -- '.$model->autoboost_time .' -- '. $model->created_at . ' ##'.($model->autoboost_time ? 'autoboost_time' : 'created_at'));
        // }

        $models = $models->sortByDesc('boost_sort_date_time');

        // dd($models->pluck('id')->toArray());

        if (is_null($limit)) {
            return $models;
        } else {
            return $models->paginate($limit);
        }
    }



    /**
     * Fetch list of users by user ids
     *
     * @param array $userIds
     * @param array $userIds
     * @return mixed
     */
    public function findUserByIds(array $userIds, array $select)
    {
        try {
            $query = $this->model;
            if (!empty($select)) {
                $query = $query->select($select);
            }
            return $query->whereIn('id', $userIds)->get();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Update user profile image
     *
     * @param array $params
     * @param int $id
     * @param string $profileType
     * @return bool
     */
    public function updateProfileImage(string $uploadFile, int $userId) //UploadedFile $uploadFile
    {
        $fileName                = uniqid() . ".jpeg";
        $storageDisk    = config('services.storage')['disk'];
        $uploadLocation = config('services.fileUploadPaths')['customerImageUploadPath'];
        $isFileUploaded = $this->createImageFromBase64($uploadFile, $uploadLocation, $fileName, $storageDisk);
        if ($isFileUploaded) {
            $user = $this->model->find($userId);
            $user->media()->where('is_profile_picture', true)->delete();
            $isProfilePictureRelatedMediaCreated = $user->media()->create([
                'mediaable_type'     => 'App\Models\User',
                'mediaable_id'       => $userId,
                'media_type'         => 'image',
                'file'               => $fileName,
                'is_profile_picture' => true
            ]);

            if ($isProfilePictureRelatedMediaCreated) {
                return $fileName;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function createOrUpdateCart($attributes)
    {
        // dd($attributes);
        $carts = auth()->user()->carts()->where('product_id', $attributes['product_id'])->whereJsonContains('attributes', $attributes['attributes'])->first();
        if (!empty($carts)) {
            return $carts->update([
                'quantity' => $carts->quantity + $attributes['quantity'],
            ]);
        } else {
            return auth()->user()->carts()->create([
                'product_id' => $attributes['product_id'],
                'attributes' => $attributes['attributes'],
                'quantity' => $attributes['quantity'],
            ]);
        }
    }

    public function getUsers($role, $filterConditions)
    {
        return $this->model->whereHas('roles', function ($q) use ($role) {
            $q->where('role_type', $role);
        })->where($filterConditions)->orderBy('id', 'DESC')->get();
    }


    public function getUserssales($role, $filterConditions)
    {
        $userId = auth()->user()->id;
        return $this->model->whereHas('roles', function ($q) use ($role) {
            $q->where('role_type', $role);
        })->where($filterConditions)->where('created_by', $userId)->orderBy('id', 'DESC')->get();
    }

    public function getUserscount($role, $filterConditions)
    {
        return $this->model->whereHas('roles', function ($q) use ($role) {
            $q->where('role_type', $role);
        })->where($filterConditions)->orderBy('id', 'DESC')->count();
    }

    public function gettransactionUsers($role, $filterConditions)
    {
        return $this->model->whereHas('roles', function ($q) use ($role) {
            $q->where('role_type', $role);
        })->where($filterConditions)->where('payment_type', '!=', '0')->orderBy('id', 'DESC')->get();
    }
    public function getAdminUsers($role, $filterConditions)
    {
        return $this->model->whereHas('roles', function ($q) use ($role) {
            $q->whereIn('role_type', $role);
        })->where($filterConditions)->get();
    }


    public function getAdminUserscount($role, $filterConditions)
    {
        return $this->model->whereHas('roles', function ($q) use ($role) {
            $q->whereIn('role_type', $role);
        })->where($filterConditions)->count();
    }
    public function getCustomersDashboard($role, $filterConditions, $limit)
    {
        return $this->model->whereHas('roles', function ($q) use ($role) {
            $q->where('role_type', $role);
        })->where($filterConditions)->paginate($limit);
    }
    public function getSellersDashboard($role, $filterConditions, $limit)
    {
        return $this->model->whereHas('roles', function ($q) use ($role) {
            $q->where('role_type', $role);
        })->where($filterConditions)->paginate($limit);
    }

    public function getEmployeeUsers($role, $type)
    {
        return $this->model->whereHas('roles', function ($q) use ($role, $type) {
            $q->where('slug', $role);
            $q->where('role_type', $type);
        })->get();
    }

    public function getAllUsers($filterConditions, $role, string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->model->whereHas('roles', function ($q) use ($role) {
            $q->whereNotIn('role_type', $role);
        })->where($filterConditions)->orderBy($orderBy, $sortBy)->get();
    }

    public function createCustomer($attributes)
    {
        //$password='12345678';
        $attributes['email_verified_at'] = NULL;
        $attributes['password'] = bcrypt($attributes['password']);
        $attributes['is_email'] = $attributes['is_email'];
        $attributes['is_approve'] = 0;
        $attributes['is_blocked'] = 0;
        $isCustomerCreated = $this->create($attributes);
        if ($isCustomerCreated) {
            $isCustomerRole = $this->roleModel->where('slug', 'customer')->first();
            $isCustomerCreated->roles()->sync($isCustomerRole->id);
        }
        return $isCustomerCreated;
    }

    public function createfaceCustomer($attributes)
    {
        //$password='12345678';
        $attributes['email_verified_at'] = NULL;
        $attributes['password'] = bcrypt(12345678);
        $attributes['is_email'] = 1;
        $attributes['is_approve'] = 0;
        $attributes['is_blocked'] = 0;
        $isCustomerCreated = $this->create($attributes);
        if ($isCustomerCreated) {
            $isCustomerRole = $this->roleModel->where('slug', 'customer')->first();
            $isCustomerCreated->roles()->sync($isCustomerRole->id);
        }
        return $isCustomerCreated;
    }

    public function updateMfiUser($attributes, $id)
    {
        $user = $this->find($id);
        // $randomPassword ="12345678";
        // $randomPassword = Str::random(8);
        $attributes['first_name'] = $attributes['contact_person_name'];
        $attributes['email'] = $attributes['contact_person_email'];
        $attributes['mobile_number'] = $attributes['contact_person_phone'];
        $isCustomerCreated = $user->update($attributes);
        if ($isCustomerCreated) {
            // if (isset($attributes['mfi_image'])) {
            //     $fileName = uniqid() . '.' . $attributes['mfi_image']->getClientOriginalExtension();
            //     $isFileUploaded = $this->uploadOne($attributes['mfi_image'], config('constants.SITE_LOGO_IMAGE_UPLOAD_PATH'), $fileName, 'public');
            //     if ($isFileUploaded) {
            //         $isFileRelatedMediaCreated = $user->media()->updateOrCreate(['user_id' => $id, 'is_logo' => true], [
            //             'mediaable_type' => get_class($user),
            //             'mediaable_id' => $user->id,
            //             'media_type' => 'logo',
            //             'file' => $fileName,
            //             'is_logo' => true,
            //         ]);
            //     }
            // }
            $user->address()->create([
                'table_id' => $user->id,
                'full_address' => $attributes['full_address'],
                'landmark' => $attributes['landmark'],
                'address_type' => 'user address',
                'country_name' => $attributes['country_name'],
                'state_name' => $attributes['state_name'],
                'city_name' => $attributes['city_name'],
                'zip_code' => $attributes['zip_code'],
            ]);


            return $user;
        }
        /* return $user; */
    }

    public function createTrainer($attributes)
    {
        $isCustomerCreated = $this->create([
            'type'         => $attributes['type'],
            'first_name'         => $attributes['name'],
            'mobile_number'     => $attributes['mobile_number'],
            'email'             => $attributes['email'],
            'introduction'      => $attributes['introduction'],
            'email_verified_at' => \Carbon\Carbon::now(),
            'password'          => bcrypt($attributes['password']),
            'is_approve'        => 1
        ]);
        //$isCustomerCreated = $this->create($attributes);
        if ($isCustomerCreated) {
            $isCustomerRole = $this->roleModel->where('slug', 'trainer')->first();
            $isCustomerCreated->roles()->sync($isCustomerRole->id);
            /* create profile */
            $isCustomerCreated->trainerProfile()->create($attributes);
            if (isset($attributes['trainer_image'])) {
                $fileName = uniqid() . '.' . $attributes['trainer_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['trainer_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $isCustomerCreated->media()->create([
                        'mediaable_type' => get_class($isCustomerCreated),
                        'mediaable_id' => $isCustomerCreated->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true
                    ]);
                }
            }
        }
        return $isCustomerCreated;
    }
    public function updateTrainer($attributes, $id)
    {
        $user = $this->find($id);
        $isAgentCreated = $user->update([
            'type'         => $attributes['type'],
            'first_name'         => $attributes['name'],
            'mobile_number'     => $attributes['mobile_number'],

            'introduction'      => $attributes['introduction'],
            'email_verified_at' => \Carbon\Carbon::now(),
            'is_approve'        => 1
        ]);

        if ($isAgentCreated) {
            /* create profile */
            $profileData['introduction'] = $attributes['introduction'];
            $user->trainerProfile()->update($profileData);
            if (isset($attributes['trainer_image'])) {
                $fileName = uniqid() . '.' . $attributes['trainer_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['trainer_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $user->media()->updateOrCreate(['user_id' => $id, 'is_profile_picture' => true], [
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $user->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true
                    ]);
                }
            }
        }
        return $user;
    }





    public function createSales($attributes)
    {
        $isCustomerCreated = $this->create([
            'first_name'         => $attributes['name'],
            'mobile_number'     => $attributes['mobile_number'],
            'email'             => $attributes['email'],
            'username'             => $attributes['email'],
            'introduction'      => $attributes['introduction'],
            'email_verified_at' => \Carbon\Carbon::now(),
            'password'          => bcrypt($attributes['password']),
            'is_approve'        => 1
        ]);
        //$isCustomerCreated = $this->create($attributes);
        if ($isCustomerCreated) {
            $isCustomerRole = $this->roleModel->where('slug', 'sales')->first();
            $isCustomerCreated->roles()->sync($isCustomerRole->id);
            /* create profile */
            $isCustomerCreated->trainerProfile()->create($attributes);
            if (isset($attributes['trainer_image'])) {
                $fileName = uniqid() . '.' . $attributes['trainer_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['trainer_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $isCustomerCreated->media()->create([
                        'mediaable_type' => get_class($isCustomerCreated),
                        'mediaable_id' => $isCustomerCreated->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true
                    ]);
                }
            }
        }
        return $isCustomerCreated;
    }
    public function updateSales($attributes, $id)
    {
        $user = $this->find($id);
        $isAgentCreated = $user->update([
            'first_name'         => $attributes['name'],
            'mobile_number'     => $attributes['mobile_number'],
            'introduction'      => $attributes['introduction'],
            'email_verified_at' => \Carbon\Carbon::now(),
            'is_approve'        => 1
        ]);

        if ($isAgentCreated) {
            /* create profile */
            $profileData['introduction'] = $attributes['introduction'];
            $user->trainerProfile()->update($profileData);
            if (isset($attributes['trainer_image'])) {
                $fileName = uniqid() . '.' . $attributes['trainer_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['trainer_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $user->media()->updateOrCreate(['user_id' => $id, 'is_profile_picture' => true], [
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $user->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true
                    ]);
                }
            }
        }
        return $user;
    }


    public function createAgent($attributes)
    {
        $userId = auth()->user()->id;
        $isCustomerCreated = $this->create([
            'first_name'         => $attributes['name'],
            'mobile_number'     => $attributes['mobile_number'],
            'email'             => $attributes['email'],
            'username'             => $attributes['email'],
            'introduction'      => $attributes['introduction'],
            'email_verified_at' => \Carbon\Carbon::now(),
            'password'          => bcrypt($attributes['password']),
            'is_approve'        => 1,
            'created_by' => $userId
        ]);
        //$isCustomerCreated = $this->create($attributes);
        if ($isCustomerCreated) {
            $isCustomerRole = $this->roleModel->where('slug', 'sales-agent')->first();
            $isCustomerCreated->roles()->sync($isCustomerRole->id);
            /* create profile */
            $isCustomerCreated->trainerProfile()->create($attributes);
            if (isset($attributes['trainer_image'])) {
                $fileName = uniqid() . '.' . $attributes['trainer_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['trainer_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $isCustomerCreated->media()->create([
                        'mediaable_type' => get_class($isCustomerCreated),
                        'mediaable_id' => $isCustomerCreated->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true
                    ]);
                }
            }
        }
        return $isCustomerCreated;
    }
    public function updateAgent($attributes, $id)
    {
        $user = $this->find($id);
        $isAgentCreated = $user->update([
            'first_name'         => $attributes['name'],
            'mobile_number'     => $attributes['mobile_number'],
            'introduction'      => $attributes['introduction'],
            'email_verified_at' => \Carbon\Carbon::now(),
            'is_approve'        => 1
        ]);

        if ($isAgentCreated) {
            /* create profile */
            $profileData['introduction'] = $attributes['introduction'];
            $user->trainerProfile()->update($profileData);
            if (isset($attributes['trainer_image'])) {
                $fileName = uniqid() . '.' . $attributes['trainer_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['trainer_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $user->media()->updateOrCreate(['user_id' => $id, 'is_profile_picture' => true], [
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $user->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true
                    ]);
                }
            }
        }
        return $user;
    }


    public function createVendor($attributes)
    {
        // $userId = auth()->user()->id;
        $isCustomerCreated = $this->create([
            'first_name'         => $attributes['name'],
            'mobile_number'     => $attributes['mobile_number'],
            // 'email'             => $attributes['email'],
            'username'             => $attributes['username'],
            // 'introduction'      => $attributes['introduction'],
            // 'pickup_address'      => $attributes['pickupaddress'],
            'email_verified_at' => \Carbon\Carbon::now(),
            'password'          => bcrypt($attributes['password']),
            'is_approve'        => 1,
            // 'created_by'=>$userId
        ]);
        //$isCustomerCreated = $this->create($attributes);
        if ($isCustomerCreated) {
            $isCustomerRole = $this->roleModel->where('slug', 'vendor')->first();
            $isCustomerCreated->roles()->sync($isCustomerRole->id);
            /* create profile */
            $isCustomerCreated->trainerProfile()->create($attributes);
            if (isset($attributes['trainer_image'])) {
                $fileName = uniqid() . '.' . $attributes['trainer_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['trainer_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $isCustomerCreated->media()->create([
                        'mediaable_type' => get_class($isCustomerCreated),
                        'mediaable_id' => $isCustomerCreated->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true
                    ]);
                }
            }
        }
        return $isCustomerCreated;
    }
    public function updateVendor($attributes, $id)
    {
        $user = $this->find($id);
        $isAgentCreated = $user->update([
            'first_name'         => $attributes['name'],
            'mobile_number'     => $attributes['mobile_number'],
            'introduction'      => $attributes['introduction'],
            // 'pickup_address'      => $attributes['pickupaddress'],
            'email_verified_at' => \Carbon\Carbon::now(),
            'is_approve'        => 1
        ]);

        if ($isAgentCreated) {
            /* create profile */
            $profileData['introduction'] = $attributes['introduction'];
            $user->trainerProfile()->update($profileData);
            if (isset($attributes['trainer_image'])) {
                $fileName = uniqid() . '.' . $attributes['trainer_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['trainer_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $user->media()->updateOrCreate(['user_id' => $id, 'is_profile_picture' => true], [
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $user->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true
                    ]);
                }
            }
        }
        return $user;
    }

    public function createDoctor($attributes)
    {
        $isCustomerCreated = $this->create([
            'first_name'         => $attributes['name'],
            'mobile_number'     => $attributes['mobile_number'],
            'email'             => $attributes['email'],
            'username'             => $attributes['email'],
            'introduction'      => $attributes['introduction'],
            'email_verified_at' => \Carbon\Carbon::now(),
            'password'          => bcrypt($attributes['password']),
            'is_approve'        => 1
        ]);
        //$isCustomerCreated = $this->create($attributes);
        if ($isCustomerCreated) {
            $isCustomerRole = $this->roleModel->where('slug', 'doctor')->first();
            $isCustomerCreated->roles()->sync($isCustomerRole->id);
            /* create profile */
            $isCustomerCreated->trainerProfile()->create($attributes);
            if (isset($attributes['trainer_image'])) {
                $fileName = uniqid() . '.' . $attributes['trainer_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['trainer_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $isCustomerCreated->media()->create([
                        'mediaable_type' => get_class($isCustomerCreated),
                        'mediaable_id' => $isCustomerCreated->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true
                    ]);
                }
            }
        }
        return $isCustomerCreated;
    }
    public function updateDoctor($attributes, $id)
    {
        $user = $this->find($id);

        $isAgentCreated = $user->update([
            'first_name'         => $attributes['name'],
            'mobile_number'     => $attributes['mobile_number'],
            'introduction'      => $attributes['introduction'],
            'email_verified_at' => \Carbon\Carbon::now(),
            'is_approve'        => 1
        ]);

        if ($isAgentCreated) {
            /* create profile */
            $profileData['introduction'] = $attributes['introduction'];
            $user->trainerProfile()->update($profileData);
            if (isset($attributes['trainer_image'])) {
                $fileName = uniqid() . '.' . $attributes['trainer_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['trainer_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $user->media()->updateOrCreate(['user_id' => $id, 'is_profile_picture' => true], [
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $user->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true
                    ]);
                }
            }
        }
        return $user;
    }


    public function updateCustomer($attributes, $id)
    {
        $user = $this->find($id);
        $isCustomerUpdated = $user->update($attributes);
        if ($isCustomerUpdated) {
        }
        return $user;
    }








    public function registerCustomer($attributes)
    {

        $isCustomerCreated = $this->create($attributes);
        if ($isCustomerCreated) {
            $isCustomerCreated->profile()->create($attributes);
            $isCustomerRole = $this->roleModel->where('slug', 'customer')->first();
            $isCustomerCreated->roles()->sync($isCustomerRole->id);
        }
        return $isCustomerCreated;
    }

    public function registerMfiUser($attributes)
    {
        $randomPassword = "12345678";
        // $randomPassword = Str::random(8);
        $attributes['first_name'] = $attributes['contact_person_name'];
        $attributes['email'] = $attributes['contact_person_email'];
        $attributes['email_verified_at'] = \Carbon\Carbon::now();
        $attributes['mobile_number'] = $attributes['contact_person_phone'];
        // $attributes['login_id'] = $attributes['login_id'];
        $attributes['password'] = bcrypt($randomPassword);
        $isCustomerCreated = $this->create($attributes);
        if ($isCustomerCreated) {
            $isCustomerCreated->address()->create([
                'table_id' => $isCustomerCreated->id,
                'full_address' => $attributes['full_address'],
                'landmark' => $attributes['landmark'],
                'address_type' => 'user address',
                'country_name' => $attributes['country_name'],
                'state_name' => $attributes['state_name'],
                'city_name' => $attributes['city_name'],
                'zip_code' => $attributes['zip_code'],
            ]);
            // $isCustomerCreated->profile()->create($attributes);
            $isCustomerRole = $this->roleModel->where('slug', 'hq-admin')->first();
            $isCustomerCreated->roles()->sync($isCustomerRole->id);
            $permissions = Permission::whereNotIn('permission_type', ['super_admin'])->get();
            $isCustomerCreated->permissions()->attach($permissions);
            // foreach()
            // if (isset($attributes['mfi_image'])) {
            //     $fileName = uniqid() . '.' . $attributes['mfi_image']->getClientOriginalExtension();
            //     $isFileUploaded = $this->uploadOne($attributes['mfi_image'], config('constants.SITE_LOGO_IMAGE_UPLOAD_PATH'), $fileName, 'public');
            //     if ($isFileUploaded) {
            //         $isFileRelatedMediaCreated = $isCustomerCreated->media()->create([
            //             'mediaable_type' => get_class($isCustomerCreated),
            //             'mediaable_id' => $isCustomerCreated->id,
            //             'media_type' => 'logo',
            //             'file' => $fileName,
            //             'is_logo' => true,
            //         ]);
            //     }
            // }

            // try{
            $mailParams = array();
            $mailParams['mail_type'] = 'user_invite';
            $mailParams['to'] = $isCustomerCreated->email;
            $mailParams['password'] = $randomPassword;
            $mailParams['login_id'] = $isCustomerCreated->login_id;
            $mailParams['from'] = config('mail.from.address');
            $mailParams['subject'] = $isCustomerCreated->roles()->first()->name . ' Invitation from ' . env('APP_NAME');
            $mailParams['greetings'] = "Hello ! User";
            $mailParams['line'] = 'You have been invited to become an ' . $isCustomerCreated->roles()->first()->name . ' at ' . env('APP_NAME');
            $mailParams['content'] = "Click on the button below to login as an " . $isCustomerCreated->roles()->first()->name . ".";
            $mailParams['login_link'] = route('login');
            $mailParams['end_greetings'] = "Regards,";
            $mailParams['from_user'] = env('MAIL_FROM_NAME');
            Mail::send(new SendMailable($mailParams));
            // }catch(\Exception $e){
            //     // $data= ['status'=>false,'message'=>'Something went wrong'];
            //     // logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            //     // return response($data);
            //     // return $this->responseRedirectBack('Something went wrong','error',true);
            // }

        }
        return $isCustomerCreated;
    }

    // public function createAgent($attributes)
    // {

    //     $isAgentCreated = $this->create([
    //         'first_name'         => $attributes['first_name'],
    //         'last_name'         => $attributes['last_name'],
    //         'mobile_number'     => $attributes['mobile_number'],
    //         'password'     => $attributes['password'],
    //         'email'             => $attributes['email'],
    //         'email_verified_at' => \Carbon\Carbon::now(),
    //         'password'          => bcrypt($attributes['password']),
    //         'is_approve'        => 1
    //     ]);

    //     if ($isAgentCreated) {

    //         $isAgentRole = $this->roleModel->where('slug', 'delivery-agent')->first();
    //         $isAgentCreated->roles()->sync($isAgentRole->id);
    //         /* create profile */
    //         $isAgentCreated->profile()->create($attributes);
    //         if (isset($attributes['agent_image'])) {
    //             $fileName = uniqid() . '.' . $attributes['agent_image']->getClientOriginalExtension();
    //             $isFileUploaded = $this->uploadOne($attributes['agent_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
    //             if ($isFileUploaded) {
    //                 $isFileRelatedMediaCreated = $isAgentCreated->media()->create([
    //                     'mediaable_type' => get_class($isAgentCreated),
    //                     'mediaable_id' => $isAgentCreated->id,
    //                     'media_type' => 'image',
    //                     'file' => $fileName,
    //                     'is_profile_picture' => true
    //                 ]);
    //             }
    //         }
    //         if (isset($attributes['document_file'])) {
    //             $fileName = uniqid() . '.' . $attributes['document_file']->getClientOriginalExtension();
    //             $isFileUploaded = $this->uploadOne($attributes['document_file'], config('constants.SITE_AGENT_DOCUMENT_UPLOAD_PATH'), $fileName, 'public');
    //             if ($isFileUploaded) {
    //                 $isFileRelatedMediaCreated = $isAgentCreated->document()->create([
    //                     'title' => $attributes['title'],
    //                     'documentable_type ' => get_class($isAgentCreated),
    //                     'documentable_id ' => $isAgentCreated->id,
    //                     'document_type' => 'document',
    //                     'file' => $fileName,
    //                 ]);
    //             }
    //         }
    //         $mailParams                     = array();
    //         $mailParams['mail_type']        = 'seller_invite';
    //         $mailParams['to']               = $attributes['email'];
    //         $mailParams['password']         = $attributes['password'];
    //         $mailParams['from']             = config('mail.from.address');
    //         $mailParams['subject']          = $isAgentCreated->roles()->first()->name . ' Invitation from ' . env('APP_NAME');
    //         $mailParams['greetings']        = "Hello ! User";
    //         $mailParams['line']             = 'You have been invited to become an ' . $isAgentCreated->roles()->first()->name . ' at ' . env('APP_NAME');
    //         $mailParams['content']          = "Click on the button below to login as an " . $isAgentCreated->roles()->first()->name . ".";
    //         $mailParams['link']             = route('login');
    //         $mailParams['end_greetings']    = "Regards,";
    //         $mailParams['from_user']        = env('MAIL_FROM_NAME');
    //         Mail::send(new SendMailable($mailParams));
    //     }
    //     return $isAgentCreated;
    // }

    // public function updateAgent($attributes, $id)
    // {
    //     $user = $this->find($id);
    //     $isAgentCreated = $user->update([
    //         'first_name'         => $attributes['first_name'],
    //         'last_name'         => $attributes['last_name'],
    //         'mobile_number'     => $attributes['mobile_number'],
    //         // 'email'             => $attributes['email'],
    //         'email_verified_at' => \Carbon\Carbon::now(),
    //         // 'password'          => bcrypt($attributes['password']),
    //         'is_approve'        => 1
    //     ]);

    //     if ($isAgentCreated) {
    //         $profileData['address'] = $attributes['address'];
    //         $profileData['zipcode'] = $attributes['zipcode'];
    //         /* create profile */
    //         $user->profile()->update($profileData);
    //         if (isset($attributes['agent_image'])) {
    //             $fileName = uniqid() . '.' . $attributes['agent_image']->getClientOriginalExtension();
    //             $isFileUploaded = $this->uploadOne($attributes['agent_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
    //             if ($isFileUploaded) {
    //                 $isFileRelatedMediaCreated = $user->media()->updateOrCreate(['user_id' => $id, 'is_profile_picture' => true], [
    //                     'mediaable_type' => get_class($user),
    //                     'mediaable_id' => $user->id,
    //                     'media_type' => 'image',
    //                     'file' => $fileName,
    //                     'is_profile_picture' => true
    //                 ]);
    //             }
    //         }
    //         if (isset($attributes['document_file'])) {
    //             $fileName = uniqid() . '.' . $attributes['document_file']->getClientOriginalExtension();
    //             $isFileUploaded = $this->uploadOne($attributes['document_file'], config('constants.SITE_AGENT_DOCUMENT_UPLOAD_PATH'), $fileName, 'public');
    //             if ($isFileUploaded) {
    //                 $isFileRelatedMediaCreated = $user->document()->updateOrCreate(['documentable_id' => $id], [
    //                     'title' => $attributes['title'],
    //                     'documentable_type ' => get_class($user),
    //                     'documentable_id ' => $user->id,
    //                     'document_type' => 'document',
    //                     'file' => $fileName,
    //                 ]);
    //             }
    //         }
    //     }
    //     return $user;
    // }
    /**
     * Create an admin
     *
     * @param array $params
     * @return mixed
     */
    public function createAdmin(array $params)
    {
        $user = $this->create([
            'first_name'         => $params['first_name'],
            'last_name'         => $params['last_name'],
            'mobile_number'     => $params['mobile_number'],
            'email'             => $params['email'],
            'email_verified_at' => \Carbon\Carbon::now(),
            'password'          => bcrypt($params['password']),
            'is_approve'        => 1
        ]);
        ## Admin role and permission
        if ($user) {
            $user->roles()->sync($params['role_id']);
            $user->profile()->create([
                'address' => $params['address'],
                'organization_name' => $params['organization_name'],
                'designation' => $params['designation']
            ]);
            if (isset($params['seller_image'])) {
                $fileName = uniqid() . '.' . $params['seller_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($params['seller_image'], config('constants.SITE_ORIGINAL_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $user->media()->create([
                        'user_id' => $user->id,
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $user->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true
                    ]);
                }
            }
            if (isset($params['document'])) {
                foreach ($params['document'] as $documents) {
                    $fileName = uniqid() . '.' . $documents['file']->getClientOriginalExtension();
                    $title = $documents['title'];
                    $isFileUploaded = $this->uploadOne($documents['file'], config('constants.SITE_SELLER_DOCUMENT_UPLOAD_PATH'), $fileName, 'public');
                    if ($isFileUploaded) {
                        $isFileRelatedMediaCreated = $user->document()->create([
                            'title' => $title,
                            'documentable_type ' => get_class($user),
                            'documentable_id ' => $user->id,
                            'document_type' => 'document',
                            'file' => $fileName,
                        ]);
                    }
                }
            }

            $mailParams                     = array();
            $mailParams['mail_type']        = 'seller_invite';
            $mailParams['to']               = $params['email'];
            $mailParams['password']         = $params['password'];
            $mailParams['from']             = config('mail.from.address');
            $mailParams['subject']          = $user->roles()->first()->name . ' Invitation from ' . env('APP_NAME');
            $mailParams['greetings']        = "Hello ! User";
            $mailParams['line']             = 'You have been invited to become an ' . $user->roles()->first()->name . ' at ' . env('APP_NAME');
            $mailParams['content']          = "Click on the button below to login as an " . $user->roles()->first()->name . ".";
            $mailParams['link']             = route('login');
            $mailParams['end_greetings']    = "Regards,";
            $mailParams['from_user']        = env('MAIL_FROM_NAME');
            Mail::send(new SendMailable($mailParams));
        }
        return $user;
    }

    public function createUser(array $attributes)
    {
        $randomPassword = "12345678";

        $user = $this->create([
            'first_name'         => $attributes['name'],
            'email'             => $attributes['email'],
            'mobile_number'     => $attributes['phone'],
            'email_verified_at' => \Carbon\Carbon::now(),
            'password'          => bcrypt($randomPassword),
            'login_id'             => $attributes['login_id'],
            'mfi_id'            => auth()->user() ? auth()->user()->mfi_id : null,
        ]);
        ## User Creation role and permission
        if ($user) {
            $branch = $this->branchModel->find(uuidtoid($attributes['branch_id'], 'branches'));
            $role = $this->roleModel->find(uuidtoid($attributes['role_id'], 'roles'));
            $user->address()->create([
                'table_id' => $user->id,
                'full_address' => $attributes['full_address'],
                'landmark' => $attributes['landmark'],
                'address_type' => 'user address',
                'country_name' => $attributes['country_name'],
                'state_name' => $attributes['state_name'],
                'city_name' => $attributes['city_name'],
                'zip_code' => $attributes['zip_code'],
            ]);

            $user->branches()->attach($branch);
            // $user->roles()->attach($role);

            $isCustomerRole = $this->roleModel->find(uuidtoid($attributes['role_id'], 'roles'));
            $user->roles()->sync($isCustomerRole->id);
            $permissions =  $isCustomerRole->permissions;
            $user->permissions()->attach($permissions);


            $mailParams                     = array();
            $mailParams['mail_type']        = 'user_invite';
            $mailParams['to']               = $attributes['email'];
            $mailParams['login_id']         = $attributes['login_id'];
            $mailParams['password']         = $randomPassword;
            $mailParams['from']             = config('mail.from.address');
            $mailParams['subject']          = $user->roles()->first()->name . ' Invitation from ' . env('APP_NAME');
            $mailParams['greetings']        = "Hello ! User";
            $mailParams['line']             = 'You have been invited to become an ' . $user->roles()->first()->name . ' at ' . env('APP_NAME');
            $mailParams['content']          = "Click on the button below to login as an " . $user->roles()->first()->name . ".";
            $mailParams['login_link']             = url(auth()->user()->mfi->code . '/login');
            $mailParams['end_greetings']    = "Regards,";
            $mailParams['from_user']        = env('MAIL_FROM_NAME');
            Mail::send(new SendMailable($mailParams));
        }
        return $user;
    }

    public function getSpecifiedPermissions()
    {
        return $this->permissionModel->NotMfi()->get();
    }

    public function updateUser(array $attributes, int $id)
    {
        $user = $this->find($id);
        $isUserUpdated = $user->update([
            'first_name' => $attributes['name'],
            'email' => $attributes['email'],
            'mobile_number' => $attributes['phone'],
            'login_id'         => $attributes['login_id'],

        ]);
        if ($isUserUpdated) {
            $branch = $this->branchModel->find(uuidtoid($attributes['branch_id'], 'branches'));
            $role = $this->roleModel->find(uuidtoid($attributes['role_id'], 'roles'));

            $profileData['landmark'] = $attributes['landmark'] ?? null;
            $profileData['country_name'] = $attributes['country_name'] ?? null;
            $profileData['state_name'] = $attributes['state_name'] ?? null;
            $profileData['city_name'] = $attributes['city_name'] ?? null;
            $profileData['zip_code'] = $attributes['zip_code'] ?? null;
            $profileData['full_address'] = $attributes['full_address'] ?? null;
            $user->address()->update($profileData);
            $user->branches()->detach();
            $user->branches()->attach($branch);
            $user->roles()->detach();
            $user->roles()->attach($role);
            $user->permissions()->detach();
            $permissions =  $role->permissions;
            $user->permissions()->attach($permissions);
        }

        return $isUserUpdated;
    }


    public function updateStatus(array $attributes)
    {
        return $this->update(['is_active' => $attributes['is_active']], $attributes['id']);
    }



    public function findAddress(int $id)
    {
        return $this->addressModel->find($id);
    }

    public function updateAddress(array $attributes, int $id)
    {
        $address = $this->addressModel->find($id);
        $isAddressUpdated = $address->update($attributes);
        if ($isAddressUpdated) {
            return $address;
        } else {
            return false;
        }
    }

    public function createAddress(array $attributes)
    {
        return $this->find(auth()->user()->id)->addressBook()->create($attributes);
    }

    public function deleteAddress($id)
    {
        return $this->addressModel->find($id)->delete();
    }
    /*************************************************** */
    /*ADMIN PART TEMP*/

    /**
     * Get user details by id
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model|mixed
     */
    public function findDetails(int $id)
    {
        $params = ['id' => $id];
        return $this->findOneBy($params);
    }

    /**
     * Deactivating a user account and generating log
     *
     * @param array $data
     * @param int $id
     * @return mixed|null
     */
    public function deactivateUserAccount(array $data, int $id)
    {
        $params = $data['userData'];
        $deactivateLogsParams = $data['deactivateLogData'];
        $user = $this->update($params, $id);

        return true;
    }

    /*ADMIN PART TEMP*/

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findUserByEmail($email)
    {
        try {
            return $this->model->where('email', '=', $email)->first();
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * Update user profile image
     *
     * @param array $params
     * @param int $id
     * @return bool
     */



    /**
     * Find an user by username
     *
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findUserByUsername($username)
    {
        try {
            return $this->model->where('username', '=', $username)->first();
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * Get all approves users by profile type
     *
     * @param $profileTypes
     * @return mixed
     */
    public function getApprovedUsersWithProfileType($profileTypes)
    {
        if (!is_array($profileTypes)) $profileTypes = array($profileTypes);

        return $this->model->whereIn('profile_type', $profileTypes)
            ->where('is_approve', true)
            ->get();
    }



    public function userUpdate(array $attributes, int $id)
    {
        $user = $this->find($id);
        $isUserUpdated = $this->update($attributes, $id);
        if ($isUserUpdated) {
            /* $user->profile()->update([
                'gender'=> $attributes['gender'],
                'address'=> $attributes['address']
            ]); */
            if (isset($attributes['profile_image'])) {
                $fileName = uniqid() . '.' . $attributes['profile_image']->getClientOriginalExtension();
                $isImageUploaded = $this->uploadOne($attributes['profile_image'], config('constants.SITE_PROFILE_IMAGE_UPLOAD_PATH'), $fileName);

                if ($isImageUploaded) {
                    $isFileRelatedMediaCreated = $user->media()->updateOrCreate(['is_profile_picture' => true, 'user_id' => auth()->user()->id], [
                        'user_id' => auth()->user()->id,
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $user->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true
                    ]);
                }
            }
        }
        return $isUserUpdated;
    }

    public function updateDetails($attributes, $id)
    {
        $isUserUpdated = $this->update($attributes, $id);
        if ($isUserUpdated) {
            $user = $this->findDetails($id);
            if (isset($attributes['profile_image'])) {
                $fileName = uniqid() . '.' . $attributes['profile_image']->getClientOriginalExtension();
                $isUserRelatedMediaUploaded = $this->uploadOne($attributes['profile_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isUserRelatedMediaUploaded) {
                    $user->media()->updateOrCreate(['user_id' => $id, 'is_profile_picture' => true], [
                        'user_id' => $id,
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true
                    ]);
                }
            }
            $user->profile()->updateOrCreate(['user_id' => $id], [
                'user_id' => $id,
                'gender' => $attributes['gender'],
                'address' => $attributes['address']
            ]);
        }
        return $isUserUpdated;
    }

    public function updateSeller(array $attributes, int $id)
    {
        $userData = $this->find($id);
        $isSellerUpdated = $this->update($attributes, $id);

        if ($isSellerUpdated) {
            $userData->profile()->updateOrCreate(['user_id' => $userData->id], [
                'address' => $attributes['address'],
                'organization_name' => $attributes['organization_name'],
                'designation' => $attributes['designation'],
                'user_id' => $userData->id
            ]);

            if (isset($attributes['seller_image'])) {
                $fileName = uniqid() . '.' . $attributes['seller_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['seller_image'], config('constants.SITE_ORIGINAL_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $userData->media()->updateOrCreate(['is_profile_picture' => true, 'user_id' => $userData->id], [
                        'user_id' => $userData->id,
                        'mediaable_type' => get_class($userData),
                        'mediaable_id' => $userData->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true
                    ]);
                }
            }

            if (isset($attributes['document'])) {
                // dd('here');
                foreach ($attributes['document'] as $document) {
                    $fileName = uniqid() . '.' . $document['file']->getClientOriginalExtension();
                    $title = $document['title'];
                    $isFileUploaded = $this->uploadOne($document['file'], config('constants.SITE_SELLER_DOCUMENT_UPLOAD_PATH'), $fileName, 'public');
                    if ($isFileUploaded) {
                        $isFileRelatedMediaCreated = $userData->document()->create([
                            'title' => $title,
                            'documentable_type ' => get_class($userData),
                            'documentable_id ' => $userData->id,
                            'document_type' => 'document',
                            'file' => $fileName,
                        ]);
                    }
                }
            }
        }
        return $isSellerUpdated;
    }

    public function findDocument($id)
    {
        return $this->documentModel->find($id);
    }



    public function listUsersAll($filterConditions, $role, string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        /**
         * in this listing customer record is excuting
         */
        //return $this->model->listUser('',['customer'])->where($filterConditions)->orderBy($orderBy, $sortBy)->get();
        $user = $this->model->listUser('', ['customer']);
        /* if (!is_null($filterConditions)) {
            $user = $user->where($filterConditions);
        } */
        if (!is_null($filterConditions)) {
            //dd($filterConditions);
            foreach ($filterConditions as $fKey => $fCondition) {
                if ($fKey == 'first_name') {
                    $user = $user->where(function ($query) use ($fCondition) {
                        $query->where('first_name', 'LIKE', "%$fCondition%");
                    });
                } elseif ($fKey == 'branch') {
                    $user = $user->whereHas('branch', function (Builder $query) use ($fCondition) {
                        $query->where('branch_id', '=', $fCondition);
                    });
                } else {
                    $user = $user->where($fKey, $fCondition);
                }
            }
        }
        $user = $user
            ->orderBy($orderBy, $sortBy);
        if (!is_null($limit)) {
            return $user->paginate($limit);
        }
        return $user->get();
    }


    public function listCustomers($filterConditions, $role, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $user = $this->model->listUser('customer');
        if (!is_null($filterConditions)) {
            /* $user = $user->where($filterConditions); */
            foreach ($filterConditions as $fKey => $fCondition) {
                if ($fKey == 'first_name') {
                    $user = $user->where(function ($query) use ($fCondition) {
                        $query->where('first_name', 'LIKE', "%$fCondition%");
                    });
                } elseif ($fKey == 'branch') {
                    $user = $user->whereHas('branch', function (Builder $query) use ($fCondition) {
                        $query->where('branch_id', '=', $fCondition);
                    });
                } else {
                    $user = $user->where($fKey, $fCondition);
                }
            }
        }
        $user = $user
            ->orderBy($orderBy, $sortBy);
        if (!is_null($limit)) {
            return $user->paginate($limit);
        }
        return $user->get();
    }


    public function createCustomerPersonalDetails($attributes)
    {
        $loan_id = uuidtoid($attributes['loan_id'], 'loans');
        $personalDetailsCreated = $this->create([
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
            'mfi_id' => auth()->user() ? auth()->user()->mfi_id : null,
            'title' => $attributes['title'],
            /* 'name' => $attributes['name'],
            'aadhaar_no' => $attributes['aadhaar_no'], */
            'mobile_number' => $attributes['mobile_number'],
        ]);


        if ($personalDetailsCreated) {
            $personalDetailsCreated->personalDetail()->create([
                'user_id' => $personalDetailsCreated->id,
                'mfi_id' => auth()->user() ? auth()->user()->mfi_id : null,
                'loan_id' => !empty($loan_id) ? $loan_id : '',
                'aadhaar_no' => $attributes['aadhaar_no'],
                'alternative_phone' => $attributes['alternative_phone'],
                'address' => $attributes['address'],
                'aadhaar_address' => $attributes['aadhaar_address'],
                'landmark' => $attributes['landmark']
            ]);
            if (isset($attributes['customer_image'])) {
                $fileName = uniqid() . '.' . $attributes['customer_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['customer_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $personalDetailsCreated->media()->create([
                        'mediaable_type' => get_class($personalDetailsCreated),
                        'mediaable_id' => $personalDetailsCreated->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true
                    ]);
                }
            }
            if (isset($attributes['location_image'])) {
                $fileName = uniqid() . '.' . $attributes['location_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['location_image'], config('SITE_LOCATION_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $personalDetailsCreated->media()->create([
                        'mediaable_type' => get_class($personalDetailsCreated),
                        'mediaable_id' => $personalDetailsCreated->id,
                        'media_type' => 'location',
                        'file' => $fileName,
                        'is_location' => true
                    ]);
                }
            }
            if (isset($attributes['aadhaar_image'])) {
                $fileName = uniqid() . '.' . $attributes['aadhaar_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['aadhaar_image'], config('SITE_aadhaar_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $personalDetailsCreated->media()->create([
                        'mediaable_type' => get_class($personalDetailsCreated),
                        'mediaable_id' => $personalDetailsCreated->id,
                        'media_type' => 'aadhaar',
                        'file' => $fileName,
                        'is_aadhaar' => true
                    ]);
                }
            }

            return $personalDetailsCreated;
        }
        //return $isCustomerCreated;
    }

    public function updateCustomerPersonalDetails($attributes, $id)
    {
        $user = $this->find($id);

        $isCustomerUpdated = $user->update($attributes);

        if ($isCustomerUpdated) {

            $personDetails = [
                'loan_id' => $attributes['loan_id'],
                'loan_group' => $attributes['loan_group'] ?? "",
                'aadhaar_no' => $attributes['aadhaar_no'],
                'alternative_phone' => $attributes['alternative_phone'],
                'address' => $attributes['address'],
                'aadhaar_address' => $attributes['aadhaar_address'],
                'landmark' => $attributes['landmark'],
                'updated_by' => auth()->user()->id,
            ];
            $user->personalDetail()->update($personDetails);
            foreach ($attributes['member_name'] as $keyM => $member) {
                $familyDetails = [
                    'occupation_id' => $attributes['occupation_id'][$keyM],
                    'member_name' => $attributes['member_name'][$keyM],
                    'age' => $attributes['age'][$keyM],
                    'relation' => $attributes['relation'][$keyM],
                    'updated_by' => auth()->user()->id,
                ];
                $user->familyDetails()->update($familyDetails);
            }
            foreach ($attributes['property_type'] as $keP => $property) {
                $familyDetails = [
                    'property_type' => $attributes['property_type'][$keP],
                    'property_condition' => $attributes['property_condition'][$keP],
                    'year' => $attributes['year'][$keP],
                    'updated_by' => auth()->user()->id
                ];
                $user->propertyDetails()->update($familyDetails);
            }
            foreach ($attributes['company'] as $keyOl => $company) {
                $otherLoanDetails = [
                    'company' => $attributes['company'][$keyOl],
                    'total_loan_amount' => $attributes['total_loan_amount'][$keyOl],
                    'emi_frequency' => $attributes['emi_frequency'][$keyOl],
                    'total_paid_emi' => $attributes['total_paid_emi'][$keyOl],
                    'updated_by' => auth()->user()->id
                ];
                $user->otherLoansDetails()->update($otherLoanDetails);
            }

            if (isset($attributes['location_image'])) {
                $fileNameLocation = uniqid() . '.' . $attributes['location_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['location_image'], config('constants.SITE_LOCATION_IMAGE_UPLOAD_PATH'), $fileNameLocation, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $user->media()->updateOrCreate(['user_id' => $id, 'is_location' => true], [
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $user->id,
                        'media_type' => 'location_image',
                        'file' => $fileNameLocation,
                        'is_location' => true
                    ]);
                }
            }
            if (isset($attributes['aadhaar_image'])) {
                $fileNameAadhaar = uniqid() . '.' . $attributes['aadhaar_image']->getClientOriginalExtension();
                $isFileUploadedAaadhaar = $this->uploadOne($attributes['aadhaar_image'], config('constants.SITE_AADHAAR_IMAGE_UPLOAD_PATH'), $fileNameAadhaar, 'public');
                if ($isFileUploadedAaadhaar) {
                    $isFileRelatedMediaCreated = $user->media()->updateOrCreate(['user_id' => $id, 'is_aadhaar' => true], [
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $user->id,
                        'media_type' => 'aadhaar_image',
                        'file' => $fileNameAadhaar,
                        'is_aadhaar' => true
                    ]);
                }
            }

            if (isset($attributes['customer_image'])) {
                $fileNameCustomer = uniqid() . '.' . $attributes['customer_image']->getClientOriginalExtension();
                $isFileUploadedCustomer = $this->uploadOne($attributes['customer_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileNameCustomer, 'public');
                if ($isFileUploadedCustomer) {
                    $isFileRelatedMediaCreated = $user->media()->updateOrCreate(['user_id' => $id, 'is_profile_picture' => true], [
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $user->id,
                        'media_type' => 'image',
                        'file' => $fileNameCustomer,
                        'is_profile_picture' => true,
                    ]);
                }
            }
        }
        return $user;
    }
    public function createCustomerFamilyDetails($attributes)
    {
        $password = Str::random(8);
        $attributes['email_verified_at'] = auth()->user() ? \Carbon\Carbon::now() : '';
        $attributes['password'] = bcrypt($password);
        $attributes['is_approve'] =  auth()->user() ? 1 : 0;
        $attributes['is_blocked'] = 0;
        $isCustomerCreated = $this->create($attributes);

        if ($isCustomerCreated) {
            $isCustomerRole = $this->roleModel->where('slug', 'customer')->first();
            $isCustomerCreated->roles()->sync($isCustomerRole->id);
            $isCustomerCreated->profile()->create($attributes);
            if (isset($attributes['customer_image'])) {
                $fileName = uniqid() . '.' . $attributes['customer_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['customer_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $isCustomerCreated->media()->create([
                        'mediaable_type' => get_class($isCustomerCreated),
                        'mediaable_id' => $isCustomerCreated->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true
                    ]);
                }
            }
            // $mailParams                     = array();
            // $mailParams['mail_type']        = 'seller_invite';
            // $mailParams['to']               = $attributes['email'];
            // $mailParams['password']         = $password;
            // $mailParams['from']             = config('mail.from.address');
            // $mailParams['subject']          = $isCustomerCreated->roles()->first()->name.' Invitation from '.env('APP_NAME');
            // $mailParams['greetings']        = "Hello ! User";
            // $mailParams['line']             = 'You have been invited to become an '.$isCustomerCreated->roles()->first()->name.' at ' . env('APP_NAME');
            // $mailParams['content']          = "Click on the button below to login as an ".$isCustomerCreated->roles()->first()->name.".";
            // $mailParams['link']             = route('login');
            // $mailParams['end_greetings']    = "Regards,";
            // $mailParams['from_user']        = env('MAIL_FROM_NAME');
            // Mail::send(new SendMailable($mailParams));
        }
        return $isCustomerCreated;
    }

    public function updateCustomerFamilyDetails($attributes, $id)
    {
        $user = $this->find($id);
        if (!auth()->user()->hasRole('customer')) {
            $password = Str::random(8);
            $attributes['email_verified_at'] = \Carbon\Carbon::now();
            $attributes['password'] = bcrypt($password);
            $attributes['is_approve'] = 1;
        }

        $isCustomerUpdated = $user->update($attributes);

        if ($isCustomerUpdated) {
            $profileData['address'] = $attributes['address'] ?? NUll;
            $profileData['birthday'] = $attributes['birthday'] ?? NUll;
            $profileData['gender'] = $attributes['gender'] ?? NUll;
            $profileData['zipcode'] = $attributes['zipcode'] ?? NUll;
            $profileData['country'] = $attributes['country'] ?? NUll;
            $profileData['state'] = $attributes['state'] ?? NUll;
            $profileData['city'] = $attributes['city'] ?? NUll;

            /* create profile */
            $user->profile()->update($profileData);
            if (isset($attributes['customer_image'])) {
                $fileName = uniqid() . '.' . $attributes['customer_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['customer_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $user->media()->updateOrCreate(['user_id' => $id, 'is_profile_picture' => true], [
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $user->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true
                    ]);
                }
            }
        }
        return $user;
    }

    public function createCustomerPropertyDetails($attributes)
    {
        $password = Str::random(8);
        $attributes['email_verified_at'] = auth()->user() ? \Carbon\Carbon::now() : '';
        $attributes['password'] = bcrypt($password);
        $attributes['is_approve'] =  auth()->user() ? 1 : 0;
        $attributes['is_blocked'] = 0;
        $isCustomerCreated = $this->create($attributes);

        if ($isCustomerCreated) {
            $isCustomerRole = $this->roleModel->where('slug', 'customer')->first();
            $isCustomerCreated->roles()->sync($isCustomerRole->id);
            $isCustomerCreated->profile()->create($attributes);
            if (isset($attributes['customer_image'])) {
                $fileName = uniqid() . '.' . $attributes['customer_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['customer_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $isCustomerCreated->media()->create([
                        'mediaable_type' => get_class($isCustomerCreated),
                        'mediaable_id' => $isCustomerCreated->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true
                    ]);
                }
            }
            // $mailParams                     = array();
            // $mailParams['mail_type']        = 'seller_invite';
            // $mailParams['to']               = $attributes['email'];
            // $mailParams['password']         = $password;
            // $mailParams['from']             = config('mail.from.address');
            // $mailParams['subject']          = $isCustomerCreated->roles()->first()->name.' Invitation from '.env('APP_NAME');
            // $mailParams['greetings']        = "Hello ! User";
            // $mailParams['line']             = 'You have been invited to become an '.$isCustomerCreated->roles()->first()->name.' at ' . env('APP_NAME');
            // $mailParams['content']          = "Click on the button below to login as an ".$isCustomerCreated->roles()->first()->name.".";
            // $mailParams['link']             = route('login');
            // $mailParams['end_greetings']    = "Regards,";
            // $mailParams['from_user']        = env('MAIL_FROM_NAME');
            // Mail::send(new SendMailable($mailParams));
        }
        return $isCustomerCreated;
    }

    public function updateCustomerPropertyDetails($attributes, $id)
    {
        $user = $this->find($id);
        if (!auth()->user()->hasRole('customer')) {
            $password = Str::random(8);
            $attributes['email_verified_at'] = \Carbon\Carbon::now();
            $attributes['password'] = bcrypt($password);
            $attributes['is_approve'] = 1;
        }

        $isCustomerUpdated = $user->update($attributes);

        if ($isCustomerUpdated) {
            $profileData['address'] = $attributes['address'] ?? NUll;
            $profileData['birthday'] = $attributes['birthday'] ?? NUll;
            $profileData['gender'] = $attributes['gender'] ?? NUll;
            $profileData['zipcode'] = $attributes['zipcode'] ?? NUll;
            $profileData['country'] = $attributes['country'] ?? NUll;
            $profileData['state'] = $attributes['state'] ?? NUll;
            $profileData['city'] = $attributes['city'] ?? NUll;

            /* create profile */
            $user->profile()->update($profileData);
            if (isset($attributes['customer_image'])) {
                $fileName = uniqid() . '.' . $attributes['customer_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['customer_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $user->media()->updateOrCreate(['user_id' => $id, 'is_profile_picture' => true], [
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $user->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true
                    ]);
                }
            }
        }
        return $user;
    }

    public function createCustomerOtherLoansDetails($attributes)
    {
        $password = Str::random(8);
        $attributes['email_verified_at'] = auth()->user() ? \Carbon\Carbon::now() : '';
        $attributes['password'] = bcrypt($password);
        $attributes['is_approve'] =  auth()->user() ? 1 : 0;
        $attributes['is_blocked'] = 0;
        $isCustomerCreated = $this->create($attributes);

        if ($isCustomerCreated) {
            $isCustomerRole = $this->roleModel->where('slug', 'customer')->first();
            $isCustomerCreated->roles()->sync($isCustomerRole->id);
            $isCustomerCreated->profile()->create($attributes);
            if (isset($attributes['customer_image'])) {
                $fileName = uniqid() . '.' . $attributes['customer_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['customer_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $isCustomerCreated->media()->create([
                        'mediaable_type' => get_class($isCustomerCreated),
                        'mediaable_id' => $isCustomerCreated->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true
                    ]);
                }
            }
            // $mailParams                     = array();
            // $mailParams['mail_type']        = 'seller_invite';
            // $mailParams['to']               = $attributes['email'];
            // $mailParams['password']         = $password;
            // $mailParams['from']             = config('mail.from.address');
            // $mailParams['subject']          = $isCustomerCreated->roles()->first()->name.' Invitation from '.env('APP_NAME');
            // $mailParams['greetings']        = "Hello ! User";
            // $mailParams['line']             = 'You have been invited to become an '.$isCustomerCreated->roles()->first()->name.' at ' . env('APP_NAME');
            // $mailParams['content']          = "Click on the button below to login as an ".$isCustomerCreated->roles()->first()->name.".";
            // $mailParams['link']             = route('login');
            // $mailParams['end_greetings']    = "Regards,";
            // $mailParams['from_user']        = env('MAIL_FROM_NAME');
            // Mail::send(new SendMailable($mailParams));
        }
        return $isCustomerCreated;
    }

    public function updateCustomerOtherLoansDetails($attributes, $id)
    {
        $user = $this->find($id);
        if (!auth()->user()->hasRole('customer')) {
            $password = Str::random(8);
            $attributes['email_verified_at'] = \Carbon\Carbon::now();
            $attributes['password'] = bcrypt($password);
            $attributes['is_approve'] = 1;
        }

        $isCustomerUpdated = $user->update($attributes);

        if ($isCustomerUpdated) {
            $profileData['address'] = $attributes['address'] ?? NUll;
            $profileData['birthday'] = $attributes['birthday'] ?? NUll;
            $profileData['gender'] = $attributes['gender'] ?? NUll;
            $profileData['zipcode'] = $attributes['zipcode'] ?? NUll;
            $profileData['country'] = $attributes['country'] ?? NUll;
            $profileData['state'] = $attributes['state'] ?? NUll;
            $profileData['city'] = $attributes['city'] ?? NUll;

            /* create profile */
            $user->profile()->update($profileData);
            if (isset($attributes['customer_image'])) {
                $fileName = uniqid() . '.' . $attributes['customer_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['customer_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $user->media()->updateOrCreate(['user_id' => $id, 'is_profile_picture' => true], [
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $user->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true
                    ]);
                }
            }
        }
        return $user;
    }

    public function createCustomerBankDetails($attributes)
    {
        $password = Str::random(8);
        $attributes['email_verified_at'] = auth()->user() ? \Carbon\Carbon::now() : '';
        $attributes['password'] = bcrypt($password);
        $attributes['is_approve'] =  auth()->user() ? 1 : 0;
        $attributes['is_blocked'] = 0;
        $isCustomerCreated = $this->create($attributes);

        if ($isCustomerCreated) {
            $isCustomerRole = $this->roleModel->where('slug', 'customer')->first();
            $isCustomerCreated->roles()->sync($isCustomerRole->id);
            $isCustomerCreated->profile()->create($attributes);
            if (isset($attributes['customer_image'])) {
                $fileName = uniqid() . '.' . $attributes['customer_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['customer_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $isCustomerCreated->media()->create([
                        'mediaable_type' => get_class($isCustomerCreated),
                        'mediaable_id' => $isCustomerCreated->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true
                    ]);
                }
            }
            // $mailParams                     = array();
            // $mailParams['mail_type']        = 'seller_invite';
            // $mailParams['to']               = $attributes['email'];
            // $mailParams['password']         = $password;
            // $mailParams['from']             = config('mail.from.address');
            // $mailParams['subject']          = $isCustomerCreated->roles()->first()->name.' Invitation from '.env('APP_NAME');
            // $mailParams['greetings']        = "Hello ! User";
            // $mailParams['line']             = 'You have been invited to become an '.$isCustomerCreated->roles()->first()->name.' at ' . env('APP_NAME');
            // $mailParams['content']          = "Click on the button below to login as an ".$isCustomerCreated->roles()->first()->name.".";
            // $mailParams['link']             = route('login');
            // $mailParams['end_greetings']    = "Regards,";
            // $mailParams['from_user']        = env('MAIL_FROM_NAME');
            // Mail::send(new SendMailable($mailParams));
        }
        return $isCustomerCreated;
    }

    public function updateCustomerBankDetails($attributes, $id)
    {
        $user = $this->find($id);
        if (!auth()->user()->hasRole('customer')) {
            $password = Str::random(8);
            $attributes['email_verified_at'] = \Carbon\Carbon::now();
            $attributes['password'] = bcrypt($password);
            $attributes['is_approve'] = 1;
        }

        $isCustomerUpdated = $user->update($attributes);

        if ($isCustomerUpdated) {
            $profileData['address'] = $attributes['address'] ?? NUll;
            $profileData['birthday'] = $attributes['birthday'] ?? NUll;
            $profileData['gender'] = $attributes['gender'] ?? NUll;
            $profileData['zipcode'] = $attributes['zipcode'] ?? NUll;
            $profileData['country'] = $attributes['country'] ?? NUll;
            $profileData['state'] = $attributes['state'] ?? NUll;
            $profileData['city'] = $attributes['city'] ?? NUll;

            /* create profile */
            $user->profile()->update($profileData);
            if (isset($attributes['customer_image'])) {
                $fileName = uniqid() . '.' . $attributes['customer_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['customer_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $user->media()->updateOrCreate(['user_id' => $id, 'is_profile_picture' => true], [
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $user->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true
                    ]);
                }
            }
        }
        return $user;
    }

    public function createKycDetails(array $attributes)
    {

        $userKycDetails = $this->kycDetailsModel->create([
            'user_id'         => $attributes['customer_user_id'],
            'is_verified_all'   => $attributes['verified_all'],
            'is_loan_recommended'   => $attributes['loan_recommended'],
            'purpose_id'             => $attributes['purpose_id'],
            'credit_score'             => $attributes['credit_score'],
            'family_income_month'             => $attributes['family_income_month'],
            'monthly_loan_liability'             => $attributes['monthly_loan_liability'],
            'mfi_id'            => auth()->user() ? auth()->user()->mfi_id : null,
            'created_by'            => auth()->user() ? auth()->user()->id : null,
            'updated_by'            => auth()->user() ? auth()->user()->id : null,
        ]);
        if ($userKycDetails) {
            if (isset($attributes['kyc_profile_image'])) {
                $fileNameKycCustomer = uniqid() . '.' . $attributes['kyc_profile_image']->getClientOriginalExtension();
                $isFileUploadedCustomer = $this->uploadOne($attributes['kyc_profile_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileNameKycCustomer, 'public');
                if ($isFileUploadedCustomer) {
                    $isFileRelatedMediaCreated = $userKycDetails->media()->create([
                        'user_id'         => $attributes['customer_user_id'],
                        'mediaable_type' => get_class($userKycDetails),
                        'mediaable_id' => $userKycDetails->id,
                        'media_type' => 'kyc_image',
                        'reference_type' => 'kyc_image',
                        'file' => $fileNameKycCustomer
                    ]);
                }
            }
            foreach ($attributes['video_url'] as $keyM => $video_url) {
                $videoDetails = [
                    'kyc_id' => $userKycDetails->id,
                    'mfi_id' => auth()->user() ? auth()->user()->mfi_id : null,
                    'video_url' => $attributes['video_url'][$keyM],
                    'status' => 1,
                    'created_by' => auth()->user()->id,
                    'updated_by' => auth()->user()->id,
                ];
                $userKycDetails->videoLinks()->create($videoDetails);
            }

            if (isset($attributes['document_file'])) {
                // dd('here');
                foreach ($attributes['document_file'] as $document) {
                    $fileName = uniqid() . '.' . $document->getClientOriginalExtension();
                    /* $title = $document['title']; */
                    $isFileUploaded = $this->uploadOne($document, config('constants.SITE_SELLER_DOCUMENT_UPLOAD_PATH'), $fileName, 'public');
                    if ($isFileUploaded) {
                        $isFileRelatedMediaCreated = $userKycDetails->documents()->create([
                            'title' => 'document',
                            'documentable_type' => get_class($userKycDetails),
                            'documentable_id' => $userKycDetails->id,
                            'document_type' => 'document',
                            'file' => $fileName,
                        ]);
                    }
                }
            }
        }
        ## User Creation role and permission
        return $userKycDetails;
    }


    public function updateKycDetails($attributes, $id)
    {
        $isBannerUpdated = $this->kycDetailsModel->find($id);
        $isCustomerKycUpdated = $isBannerUpdated->update([
            'is_verified_all'   => $attributes['verified_all'],
            'is_loan_recommended'   => $attributes['loan_recommended'],
            'purpose_id'             => $attributes['purpose_id'],
            'credit_score'             => $attributes['credit_score'],
            'family_income_month'             => $attributes['family_income_month'],
            'monthly_loan_liability'             => $attributes['monthly_loan_liability'],
            'updated_by' => auth()->user()->id
        ]);

        if ($isCustomerKycUpdated) {

            if (isset($attributes['kyc_profile_image'])) {
                $fileNameCustomer = uniqid() . '.' . $attributes['kyc_profile_image']->getClientOriginalExtension();
                $isFileUploadedCustomer = $this->uploadOne($attributes['kyc_profile_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileNameCustomer, 'public');
                if ($isFileUploadedCustomer) {
                    $isFileRelatedMediaCreated = $isBannerUpdated->media()->updateOrCreate(['mediaable_id' => $id, 'reference_type' => 'kyc_image'], [
                        'mediaable_type' => get_class($isBannerUpdated),
                        'mediaable_id' => $isBannerUpdated->id,
                        'media_type' => 'kyc_image',
                        'reference_type' => 'kyc_image',
                        'file' => $fileNameCustomer
                    ]);
                }
            }
        }


        return $isBannerUpdated;
    }


    public function createCustomerDemand(array $attributes)
    {

        $userDemandDetails = $this->customerDemandModel->create([
            'user_id'             => $attributes['user_id'],
            'agent_id'          => $attributes['agent_id'],
            'loan_id'           => $attributes['loan_id'],
            'group_id'             => $attributes['group_id'],
            'loan_amount'         => $attributes['loan_amount'],
            'frequency'         => $attributes['frequency'],
            'emi_start_date'     => date('Y-m-d', strtotime($attributes['emi_start_date'])),
            'tenure'             => $attributes['tenure'],
            'remarks'             => $attributes['remarks'],
            'demand_status'     => 1,
            'disbursement_status'     => 0,
            'mfi_id'            => auth()->user() ? auth()->user()->mfi_id : null,
            'created_by'        => auth()->user() ? auth()->user()->id : null,
            'updated_by'        => auth()->user() ? auth()->user()->id : null,
        ]);

        ## User Creation role and permission
        return $userDemandDetails;
    }
    public function updateCustomerDemand(array $attributes, $id)
    {
        $isBannerUpdated = $this->customerDemandModel->find($id);
        $isdemandUpdated = $isBannerUpdated->update([
            'user_id'             => $attributes['user_id'],
            'agent_id'          => $attributes['agent_id'],
            'loan_id'           => $attributes['loan_id'],
            'group_id'             => $attributes['group_id'],
            'loan_amount'         => $attributes['loan_amount'],
            'frequency'         => $attributes['frequency'],
            'emi_start_date'     => date('Y-m-d', strtotime($attributes['emi_start_date'])),
            'tenure'             => $attributes['tenure'],
            'remarks'             => $attributes['remarks'],
            'updated_by'        => auth()->user() ? auth()->user()->id : null,
        ]);


        ## User Creation role and permission
        return $isBannerUpdated;
    }

    public function listDemands($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $demand = $this->customerDemandModel;
        if (!is_null($filterConditions)) {
            $demand = $demand->where($filterConditions);
        }
        $demand = $demand->orderBy($orderBy, $sortBy);
        if (!is_null($limit)) {
            return $demand->paginate($limit);
        }
        return $demand->get();
    }



    public function updateOrCreateFamilyDetails($attributes)
    {
        // return $attributes;
        $customerId = $attributes['customer_id'];
        $user = $this->find($customerId);
        $requestedMemberIds = [];
        foreach ($attributes['family_details'] as $keyM => $member) {
            $familyDetails = [
                'occupation_id' => $attributes['family_details'][$keyM]['occupation_id'],
                'member_name' => $attributes['family_details'][$keyM]['member_name'],
                'age' => $attributes['family_details'][$keyM]['age'],
                'relation' => $attributes['family_details'][$keyM]['relation'],
                'mfi_id' => auth()->user()->mfi->id,
                'status' => 1
            ];
            $familyId = NULL;

            if (!empty($member['family_id'])) {
                $familyId = $member['family_id'];
            }
            $familyDetails['updated_by'] = auth()->user()->id;
            $familyDetails['created_by'] = auth()->user()->id;
            $requestedMemberIds[] = ($user->familyDetails()->updateOrCreate(['id' => $familyId], $familyDetails))->id;
        }
        if (!empty($user->familyDetails)) {
            $existingMemberIds = $user->familyDetails->pluck('id')->toArray();

            $deletedMemberIds = array_diff($existingMemberIds, $requestedMemberIds);
            foreach ($user->familyDetails as $key => $familyDetails) {
                if (in_array($familyDetails->id, $deletedMemberIds)) {
                    $familyDetails->delete();
                }
            }
        }
        return $user;
    }
    public function updateOrCreatePropertyDetails($attributes)
    {
        // return $attributes;
        $customerId = $attributes['customer_id'];
        $user = $this->find($customerId);
        $requestedPropertyIds = [];

        foreach ($attributes['property_details'] as $keyM => $property) {
            $propertyDetails = [
                'property_type' => $attributes['property_details'][$keyM]['property_type'],
                'property_condition' => $attributes['property_details'][$keyM]['property_condition'],
                'year' => $attributes['property_details'][$keyM]['year'],
                'mfi_id' => auth()->user()->mfi->id,
                'status' => 1
            ];
            $propertyId = NULL;
            if (!empty($property['property_id'])) {
                $propertyId = $property['property_id'];
                // $requestedPropertyIds[]=$property['property_id'];
            }
            $propertyDetails['updated_by'] = auth()->user()->id;
            $propertyDetails['created_by'] = auth()->user()->id;
            $requestedPropertyIds[] = ($user->propertyDetails()->updateOrCreate(['id' => $propertyId], $propertyDetails))->id;
        }
        if (!empty($user->propertyDetails)) {
            $existingPropertyIds = $user->propertyDetails->pluck('id')->toArray();
            $deletedPropertyIds = array_diff($existingPropertyIds, $requestedPropertyIds);
            foreach ($user->propertyDetails as $key => $propertyDetails) {
                if (in_array($propertyDetails->id, $deletedPropertyIds)) {
                    $propertyDetails->delete();
                }
            }
        }
        return $user;
    }


    public function updateOrCreateBankDetails($attributes)
    {
        // return $attributes;
        $customerId = $attributes['customer_id'];
        $user = $this->find($customerId);
        $requestedPropertyIds = [];
        $bank_details_id = !empty($user->bankDetails) ? $user->bankDetails->id : NULL;
        $bankDetails = [
            'user_id' => $user->id,
            'mfi_id' => auth()->user()->mfi_id,
            'account_holder' => $attributes['account_holder'],
            'account_no' => $attributes['account_no'],
            'ifsc_code' => $attributes['ifsc_code'],
            'status' => 1,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ];
        $bankDetails =  $user->bankDetails()->updateOrCreate(['id' => $bank_details_id], $bankDetails);
        return $bankDetails;
    }

    public function updateOrCreateOthernLoanDetails($attributes)
    {
        // return $attributes;
        $customerId = $attributes['customer_id'];
        $user = $this->find($customerId);
        $requestedOtherLoanIds = [];

        foreach ($attributes['other_loan_details'] as $keyM => $property) {
            $otherLoansDetails = [
                'company' => $attributes['other_loan_details'][$keyM]['company'],
                'total_loan_amount' => $attributes['other_loan_details'][$keyM]['total_loan_amount'],
                'emi_frequency' => $attributes['other_loan_details'][$keyM]['emi_frequency'],
                'total_paid_emi' => $attributes['other_loan_details'][$keyM]['total_paid_emi'],
                'mfi_id' => auth()->user()->mfi->id,
                'status' => 1
            ];
            $otherLoanId = NULL;
            if (!empty($property['other_loan_id'])) {
                $otherLoanId = $property['other_loan_id'];
                // $requestedOtherLoanIds[]= $property['other_loan_id'];
            }
            $otherLoansDetails['updated_by'] = auth()->user()->id;
            $otherLoansDetails['created_by'] = auth()->user()->id;
            $requestedOtherLoanIds[] = ($user->otherLoansDetails()->updateOrCreate(['id' => $otherLoanId], $otherLoansDetails))->id;
        }
        if (!empty($user->otherLoansDetails)) {
            $existingOtherLoanIds = $user->otherLoansDetails->pluck('id')->toArray();
            $deletedOtherLoanIds = array_diff($existingOtherLoanIds, $requestedOtherLoanIds);

            foreach ($user->otherLoansDetails as $key => $otherLoansDetails) {
                if (in_array($otherLoansDetails->id, $deletedOtherLoanIds)) {
                    $otherLoansDetails->delete();
                }
            }
        }


        return $user;
    }

    public function updateOrCreatePersonalDetails($attributes)
    {

        $customerId = $attributes['customer_id'];
        $user = "";
        if (!empty($customerId)) {
            $user = $this->find($customerId);
        }
        $branchId = auth()->user()->branch->branch_id;
        $attributes['first_name'] = $attributes['name'];
        $attributes['mobile_number'] = $attributes['mobile'];
        if (empty($user)) {
            $password = '12345678';
            $attributes['email_verified_at'] = auth()->user() ? \Carbon\Carbon::now() : '';
            $attributes['password'] = bcrypt($password);
            $attributes['is_approve'] =  auth()->user() ? 1 : 0;
            $attributes['is_blocked'] = 0;
            $attributes['mfi_id'] = auth()->user()->mfi_id;
            $user = $this->create($attributes);
            $branch = $this->branchModel->find($branchId);
            $isCustomerRole = $this->roleModel->where('slug', 'customer')->first();
            $user->roles()->sync($isCustomerRole->id);
            $user->branches()->attach($branch);
        } else {
            $userUpdate = $user->update($attributes);
        }



        if ($user) {
            $personalId = null;
            if (!empty($user->personalDetail)) {
                $personalId = $user->personalDetail->id;
            }
            /* create person details */
            $personDetails = [
                'user_id' => $user->id,
                'mfi_id' => auth()->user()->mfi_id,
                'loan_id' => $attributes['loan_id'],
                'loan_group' => $attributes['loan_group'] ?? "",
                'aadhaar_no' => $attributes['aadhaar_no'],
                'alternative_phone' => $attributes['alternative_phone'],
                'address' => $attributes['address'],
                'aadhaar_address' => $attributes['aadhaar_address'],
                'landmark' => $attributes['landmark'],
                'status' => 1,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ];
            $user->personalDetail()->updateOrCreate(['id' => $personalId], $personDetails);
            if (isset($attributes['image'])) {
                $fileNameCustomer = uniqid() . ".png";
                $isFileUploadedCustomer = $this->createImageFromBase64($attributes['image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileNameCustomer, 'public');
                if ($isFileUploadedCustomer) {
                    $isFileRelatedMediaCreated = $user->media()->create([
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $user->id,
                        'media_type' => 'image',
                        'file' => $fileNameCustomer,
                        'is_profile_picture' => true
                    ]);
                }
            }
            if (isset($attributes['aadhaar_image'])) {
                $fileNameCustomerAadhar = uniqid() . ".png";
                $isFileUploadedCustomerAadhar = $this->createImageFromBase64($attributes['aadhaar_image'], config('constants.SITE_AADHAAR_IMAGE_UPLOAD_PATH'), $fileNameCustomerAadhar, 'public');
                if ($isFileUploadedCustomerAadhar) {
                    $isFileRelatedMediaCreated = $user->media()->create([
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $user->id,
                        'media_type' => 'aadhaar_image',
                        'file' => $fileNameCustomerAadhar,
                        'is_aadhaar' => true
                    ]);
                }
            }
        }
        return $user;
    }

    public function findDemandById($id)
    {
        return $this->customerDemandModel->find($id);
    }

    public function updateDemandStatus($attributes, $id)
    {
        return $this->customerDemandModel->find($id)->update($attributes);
    }

    public function deleteDemand($id)
    {
        return $this->customerDemandModel->find($id)->delete();
        ## Delete page seo
    }

    public function demandStatusChange($attributes, $id)
    {
        $demandData = $this->customerDemandModel->find($id);
        $demandStatusUpdate = $demandData->update([
            'updated_by' => auth()->user()->id,
            'demand_status' => $attributes['demand_status'],
            'disbursement_status' => $attributes['disbursement_status']
        ]);
        if ($demandStatusUpdate) {
            $demandData->note()->create([
                'mfi_id' => auth()->user() ? auth()->user()->mfi_id : null,
                'demand_id' => $demandData->demand_id,
                'demand_status' => $attributes['demand_status'],
                'disbursement_status' => $attributes['disbursement_status'],
                'notes' => $attributes['notes'],
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);
            return $demandStatusUpdate;
        }
    }

    public function updateOrCreateKycDetails($attributes, $id)
    {

        $userKycDetails = $this->kycDetailsModel->updateOrCreate(['id' => $id], [
            'user_id'         => $attributes['customer_id'],
            'is_verified_all'   => $attributes['is_verified_all'],
            'is_loan_recommended'   => $attributes['is_loan_recommended'],
            'purpose_id'             => $attributes['purpose_id'],
            'credit_score'             => $attributes['credit_score'],
            'family_income_month'             => $attributes['family_income_month'],
            'monthly_loan_liability'             => $attributes['monthly_loan_liability'],
            'mfi_id'            => auth()->user() ? auth()->user()->mfi_id : null,
            'created_by'            => auth()->user() ? auth()->user()->id : null,
            'updated_by'            => auth()->user() ? auth()->user()->id : null,
        ]);
        if ($userKycDetails) {
            if (isset($attributes['kyc_profile_image'])) {
                // $fileNameKycCustomer = uniqid() . '.png';
                $fileNameKycCustomer = uniqid() . '.' . $attributes['document_file']->getClientOriginalExtension();

                $isFileUploadedCustomer = $this->uploadOne($attributes['kyc_profile_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileNameKycCustomer, 'public');
                if ($isFileUploadedCustomer) {
                    $isFileRelatedMediaCreated = $userKycDetails->media()->create([
                        'user_id'         => $attributes['customer_id'],
                        'mediaable_type' => get_class($userKycDetails),
                        'mediaable_id' => $userKycDetails->id,
                        'media_type' => 'kyc_image',
                        'reference_type' => 'kyc_image',
                        'file' => $fileNameKycCustomer
                    ]);
                }
            }
            if (isset($attributes['document_file'])) {
                // $fileName = uniqid() . '.pdf'
                $fileName = uniqid() . '.' . $attributes['document_file']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['document_file'], config('constants.SITE_KYC_DOCUMENT_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $userKycDetails->documents()->create([
                        'title' => 'document',
                        'documentable_type' => get_class($userKycDetails),
                        'documentable_id' => $userKycDetails->id,
                        'document_type' => 'document',
                        'file' => $fileName,
                    ]);
                }
            }
        }
        ## User Creation role and permission
        return $userKycDetails;
    }

    public function createProfile($attributes, $id)
    {
        //dd($attributes);
        $user = $this->find($id);

        $attributes['first_name'] = $attributes['name'];
        if (isset($attributes['refer_code'])) {
            $attributes['refer_code_come'] = $attributes['refer_code'];
        }
        $attributes['is_profile_completed'] = 1;
        $userData = $user->update($attributes);
        /* $userData=[
        ]; */
        if ($userData) {
            $profileData = [
                'gender' => !empty($attributes['gender']) ? $attributes['gender'] : '',
                'age' => !empty($attributes['age']) ? $attributes['age'] : '',
                'height' => !empty($attributes['height']) ? $attributes['height'] : '',
                'weight' => !empty($attributes['weight']) ? $attributes['weight'] : '',
                'email' => !empty($attributes['email']) ? $attributes['email'] : '',
                'mobile_number' => !empty($attributes['mobile_number']) ? $attributes['mobile_number'] : '',
                'target_weight' => !empty($attributes['target_weight']) ? $attributes['target_weight'] : '',
                'bmi' => !empty($attributes['bmi']) ? $attributes['bmi'] : NULL,
                'guidance' => !empty($attributes['guidance']) ? json_encode($attributes['guidance']) : "[]",
            ];
            $user->profile()->updateOrcreate(['user_id' => $id], $profileData);

            $profileOtherData = [
                'do_you_have_any_allergies' => !empty($attributes['do_you_have_any_allergies']) ? $attributes['do_you_have_any_allergies'] : '',
                'do_you_have_any_medical_condition' => !empty($attributes['do_you_have_any_medical_condition']) ? $attributes['do_you_have_any_medical_condition'] : '',
                'diet_type' => !empty($attributes['diet_type']) ? $attributes['diet_type'] : '',
                'allergies_type' => !empty($attributes['allergy_type']) ? $attributes['allergy_type'] : '',
                'medical_condition_type' => !empty($attributes['medical_condition_type']) ? $attributes['medical_condition_type'] : ''
            ];
            $user->profileOtherInformation()->updateOrcreate(['user_id' => $id], $profileOtherData);
            if (isset($attributes['fitness_id']) && !empty($attributes['fitness_id'])) {
                $isUserFitnessGoal = $this->fitnessGoalModel->find($attributes['fitness_id']);
                $user->fitness()->sync($isUserFitnessGoal->id);
            }
            if (isset($attributes['user_physically_conditions_id']) && !empty($attributes['user_physically_conditions_id'])) {
                $isUserPhysicalConditions = $this->userPhysicallyActiveConditions->find($attributes['user_physically_conditions_id']);
                $user->physicalCondition()->sync($isUserPhysicalConditions->id);
            }

            return $user;
        }

        // dd($user->profile);
        //$user->update($userData);

    }
    public function CreateAdvanceUserDetails($attributes, $id)
    {

        $user = $this->find($id);
        $attributes['first_name'] = $attributes['name'];
        $attributes['is_profile_completed'] = 1;
        if ($attributes['gender'] != null &&  $attributes['age'] != null && $attributes['height'] != null &&   $attributes['weight'] != null &&  $attributes['target_weight'] != null &&  $attributes['bmi'] != null && $attributes['do_you_have_any_allergies'] != null &&   $attributes['do_you_have_any_medical_condition'] != null && $attributes['diet_type'] != null &&  $attributes['fitness_id'] != null && $attributes['user_physically_conditions_id'] != null) {

            $attributes['is_advance'] = "1";
        } else {

            $attributes['is_advance'] = "0";
        }

        $userData = $user->update($attributes);
        /* $userData=[
        ]; */
        if ($userData) {
            $profileData = [
                'gender' => !empty($attributes['gender']) ? $attributes['gender'] : '',
                'age' => !empty($attributes['age']) ? $attributes['age'] : '',
                'height_type' => !empty($attributes['weight_type']) ? $attributes['weight_type'] : '',
                'height_type' => !empty($attributes['height_type']) ? $attributes['height_type'] : '',
                'height' => !empty($attributes['height']) ? $attributes['height'] : '',
                'weight' => !empty($attributes['weight']) ? $attributes['weight'] : '',
                'target_weight' => !empty($attributes['target_weight']) ? $attributes['target_weight'] : '',
                'bmi' => !empty($attributes['bmi']) ? $attributes['bmi'] : NULL,
                'guidance' => !empty($attributes['guidance']) ? json_encode($attributes['guidance']) : "[]",
            ];
            $user->profile()->updateOrcreate(['user_id' => $id], $profileData);

            $profileOtherData = [
                'do_you_have_any_allergies' => !empty($attributes['do_you_have_any_allergies']) ? $attributes['do_you_have_any_allergies'] : '',
                'do_you_have_any_medical_condition' => !empty($attributes['do_you_have_any_medical_condition']) ? $attributes['do_you_have_any_medical_condition'] : '',
                'diet_type' => !empty($attributes['diet_type']) ? $attributes['diet_type'] : '',
                'allergies_type' => !empty($attributes['allergies_type']) ? $attributes['allergies_type'] : '',
                'medical_condition_type' => !empty($attributes['medical_condition_type']) ? $attributes['medical_condition_type'] : ''
            ];
            $user->profileOtherInformation()->updateOrcreate(['user_id' => $id], $profileOtherData);

            $isUserFitnessGoal = $this->fitnessGoalModel->find($attributes['fitness_id']);
            $isUserPhysicalConditions = $this->userPhysicallyActiveConditions->find($attributes['user_physically_conditions_id']);
            $user->fitness()->sync($isUserFitnessGoal->id);
            $user->physicalCondition()->sync($isUserPhysicalConditions->id);


            return $user;
        }

        // dd($user->profile);
        //$user->update($userData);

    }

    public function CreateUserFoodItems($attributes, $id)
    {

        $type = $attributes['type'];
        $food_ids = $attributes['foods'];
        $today = Carbon::today();
        $fooditem = UserFoodItemDetail::where('user_id', auth()->user()->id)->whereDate('updated_at', $today)->first();
        if ($fooditem) {
            $a = $fooditem->food_ids;
            $food_ids_comma_separated = implode(',', $food_ids);
            $c = $a . "," . $food_ids_comma_separated;
        } else {
            $c = implode(',', $food_ids);
        }



        $userFoodItems = [
            'type' => $type,
            'food_ids' => $c,
            'user_id' => auth()->user()->id
        ];

        $createuserFoodItems = $this->userFoodItemModel->updateOrcreate(['user_id' => auth()->user()->id], $userFoodItems);

        return true;
    }

    public function updateOrCreateHealthWorkout($attributes, $id)
    {
        //dd($attributes);
        $user = $this->find($id);

        if ($user) {
            $userHealthScreenOne = [
                'sleep_schedule' => !empty($attributes['sleep_schedule']) ? $attributes['sleep_schedule'] : '',
                'total_sleep_hours'
                => !empty($attributes['total_sleep_hours']) ? $attributes['total_sleep_hours'] : '',
                'is_followed_diet_plan'
                => !empty($attributes['is_followed_diet_plan']) ? $attributes['is_followed_diet_plan'] : 0,
                'diet_plan_last_time'
                => !empty($attributes['diet_plan_last_time']) ? $attributes['diet_plan_last_time'] : '',
                'is_followed_exercise_plan'
                => !empty($attributes['is_followed_exercise_plan']) ? $attributes['is_followed_exercise_plan'] : 0,
                'exercise_plan_last_time'
                => !empty($attributes['exercise_plan_last_time']) ? $attributes['exercise_plan_last_time'] : '',
                'any_physical_movement'
                => !empty($attributes['any_physical_movement']) ? $attributes['any_physical_movement'] : 0,
                'physical_movement_last_time'
                => !empty($attributes['physical_movement_last_time']) ? $attributes['physical_movement_last_time'] : '',
                'water_intake_last_time'
                => !empty($attributes['water_intake_last_time']) ? $attributes['water_intake_last_time'] : '',
                'prescription_name'
                => !empty($attributes['prescription_name']) ? $attributes['prescription_name'] : '',
                'medication_name'
                => !empty($attributes['medication_name']) ? $attributes['medication_name'] : '',
                'asthma_name'
                => !empty($attributes['asthma_name']) ? $attributes['asthma_name'] : '',
                'uric_acid_name'
                => !empty($attributes['uric_acid_name']) ? $attributes['uric_acid_name'] : '',
                'diabities_name'
                => !empty($attributes['diabities_name']) ? $attributes['diabities_name'] : '',
                'high_cholesterol_name'
                => !empty($attributes['high_cholesterol_name']) ? $attributes['high_cholesterol_name'] : '',
                'low_blood_pressure_name'
                => !empty($attributes['low_blood_pressure_name']) ? $attributes['low_blood_pressure_name'] : '',

            ];
            $user->userHealthScreenOneDetails()->updateOrcreate(['user_id' => $id], $userHealthScreenOne);

            $userHealthScreenTwo = [
                'do_you_get_tired_during_the_day' => !empty($attributes['do_you_get_tired_during_the_day']) ? $attributes['do_you_get_tired_during_the_day'] : 0,
                'feel_drizzing_when_you_wakeup'
                => !empty($attributes['feel_drizzing_when_you_wakeup']) ? $attributes['feel_drizzing_when_you_wakeup'] : 0,
                'how_much_do_you_smoke_in_a_day'
                => !empty($attributes['how_much_do_you_smoke_in_a_day']) ? $attributes['how_much_do_you_smoke_in_a_day'] : '',
                'how_often_do_you_drink'
                => !empty($attributes['how_often_do_you_drink']) ? $attributes['how_often_do_you_drink'] : '',
                'what_do_you_usually_drink'
                => !empty($attributes['what_do_you_usually_drink']) ? $attributes['what_do_you_usually_drink'] : ''
            ];
            $user->userHealthScreenTwoDetails()->updateOrcreate(['user_id' => $id], $userHealthScreenTwo);

            $userHealthScreenThree = [
                'do_you_take_any_medication' => !empty($attributes['do_you_take_any_medication']) ? $attributes['do_you_take_any_medication'] : 0,
                'have_you_been_recently_hospitalized'
                => !empty($attributes['have_you_been_recently_hospitalized']) ? $attributes['have_you_been_recently_hospitalized'] : 0,
                'do_you_suffer_from_asthma'
                => !empty($attributes['do_you_suffer_from_asthma']) ? $attributes['do_you_suffer_from_asthma'] : 0,
                'do_you_have_high_uric_acid'
                => !empty($attributes['do_you_have_high_uric_acid']) ? $attributes['do_you_have_high_uric_acid'] : 0,
                'do_you_have_diabities'
                => !empty($attributes['do_you_have_diabities']) ? $attributes['do_you_have_diabities'] : 0,
                'do_you_have_high_cholesterol'
                => !empty($attributes['do_you_have_high_cholesterol']) ? $attributes['do_you_have_high_cholesterol'] : 0,
                'do_you_suffer_from_high_or_low_blood_pressure'
                => !empty($attributes['do_you_suffer_from_high_or_low_blood_pressure']) ? $attributes['do_you_suffer_from_high_or_low_blood_pressure'] : 0,


            ];
            $user->userHealthScreenThreeDetails()->updateOrcreate(['user_id' => $id], $userHealthScreenThree);
            if (isset($attributes['prescription'])) {
                // list($type, $data) = explode(';', $attributes['image']);
                // $extSplit = explode('/', $type);
                // $ext      =  $extSplit[1];
                $fileNameCustomers = uniqid() . ".png";
                // if($ext)
                // {
                //     $fileNameCustomer = uniqid() .".". $ext;
                // }

                $isFileUploadedCustomers = $this->createImageFromBase64($attributes['prescription'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileNameCustomers, 'public');
                if ($isFileUploadedCustomers) {
                    $isFileRelatedMediaCreated = $user->media()->updateOrCreate(['user_id' => $id, 'is_prescription' => true], [
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $id,
                        'media_type' => 'image',
                        'file' => $fileNameCustomers,
                        'is_prescription' => true
                    ]);
                }
            }

            if (isset($attributes['medication_prescription'])) {
                // list($type, $data) = explode(';', $attributes['image']);
                // $extSplit = explode('/', $type);
                // $ext      =  $extSplit[1];
                $fileNameCustomerss = uniqid() . ".png";
                // if($ext)
                // {
                //     $fileNameCustomer = uniqid() .".". $ext;
                // }

                $isFileUploadedCustomerss = $this->createImageFromBase64($attributes['medication_prescription'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileNameCustomerss, 'public');
                if ($isFileUploadedCustomerss) {
                    $isFileRelatedMediaCreated = $user->media()->updateOrCreate(['user_id' => $id, 'is_medication_prescription' => true], [
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $id,
                        'media_type' => 'image',
                        'file' => $fileNameCustomerss,
                        'is_medication_prescription' => true
                    ]);
                }
            }

            if (isset($attributes['asthma_prescription'])) {
                // list($type, $data) = explode(';', $attributes['image']);
                // $extSplit = explode('/', $type);
                // $ext      =  $extSplit[1];
                $fileNameCustomersss = uniqid() . ".png";
                // if($ext)
                // {
                //     $fileNameCustomer = uniqid() .".". $ext;
                // }

                $isFileUploadedCustomersss = $this->createImageFromBase64($attributes['asthma_prescription'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileNameCustomersss, 'public');
                if ($isFileUploadedCustomersss) {
                    $isFileRelatedMediaCreated = $user->media()->updateOrCreate(['user_id' => $id, 'is_asthma_prescription' => true], [
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $id,
                        'media_type' => 'image',
                        'file' => $fileNameCustomersss,
                        'is_asthma_prescription' => true
                    ]);
                }
            }

            if (isset($attributes['uric_acid_prescription'])) {
                // list($type, $data) = explode(';', $attributes['image']);
                // $extSplit = explode('/', $type);
                // $ext      =  $extSplit[1];
                $fileNameCustomerssss = uniqid() . ".png";
                // if($ext)
                // {
                //     $fileNameCustomer = uniqid() .".". $ext;
                // }

                $isFileUploadedCustomerssss = $this->createImageFromBase64($attributes['uric_acid_prescription'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileNameCustomerssss, 'public');
                if ($isFileUploadedCustomerssss) {
                    $isFileRelatedMediaCreated = $user->media()->updateOrCreate(['user_id' => $id, 'is_uric_acid_prescription' => true], [
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $id,
                        'media_type' => 'image',
                        'file' => $fileNameCustomerssss,
                        'is_uric_acid_prescription' => true
                    ]);
                }
            }

            if (isset($attributes['diabities_prescription'])) {
                // list($type, $data) = explode(';', $attributes['image']);
                // $extSplit = explode('/', $type);
                // $ext      =  $extSplit[1];
                $fileNameCustomersssss = uniqid() . ".png";
                // if($ext)
                // {
                //     $fileNameCustomer = uniqid() .".". $ext;
                // }

                $isFileUploadedCustomersssss = $this->createImageFromBase64($attributes['diabities_prescription'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileNameCustomersssss, 'public');
                if ($isFileUploadedCustomersssss) {
                    $isFileRelatedMediaCreated = $user->media()->updateOrCreate(['user_id' => $id, 'is_diabities_prescription' => true], [
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $id,
                        'media_type' => 'image',
                        'file' => $fileNameCustomersssss,
                        'is_diabities_prescription' => true
                    ]);
                }
            }

            if (isset($attributes['high_cholesterol_prescription'])) {
                // list($type, $data) = explode(';', $attributes['image']);
                // $extSplit = explode('/', $type);
                // $ext      =  $extSplit[1];
                $fileNameCustomerssssss = uniqid() . ".png";
                // if($ext)
                // {
                //     $fileNameCustomer = uniqid() .".". $ext;
                // }

                $isFileUploadedCustomerssssss = $this->createImageFromBase64($attributes['high_cholesterol_prescription'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileNameCustomerssssss, 'public');
                if ($isFileUploadedCustomerssssss) {
                    $isFileRelatedMediaCreated = $user->media()->updateOrCreate(['user_id' => $id, 'is_high_cholesterol_prescription' => true], [
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $id,
                        'media_type' => 'image',
                        'file' => $fileNameCustomerssssss,
                        'is_high_cholesterol_prescription' => true
                    ]);
                }
            }


            if (isset($attributes['low_blood_pressure_prescription'])) {
                // list($type, $data) = explode(';', $attributes['image']);
                // $extSplit = explode('/', $type);
                // $ext      =  $extSplit[1];
                $fileNameCustomersssssss = uniqid() . ".png";
                // if($ext)
                // {
                //     $fileNameCustomer = uniqid() .".". $ext;
                // }

                $isFileUploadedCustomersssssss = $this->createImageFromBase64($attributes['low_blood_pressure_prescription'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileNameCustomersssssss, 'public');
                if ($isFileUploadedCustomersssssss) {
                    $isFileRelatedMediaCreated = $user->media()->updateOrCreate(['user_id' => $id, 'is_low_blood_pressure_prescription' => true], [
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $id,
                        'media_type' => 'image',
                        'file' => $fileNameCustomersssssss,
                        'is_low_blood_pressure_prescription' => true
                    ]);
                }
            }


            return $user;
        }

        // dd($user->profile);
        //$user->update($userData);

    }
    public function createProfileImage($attributes, $id)
    {
        $user = $this->find($id);
        if ($user) {
            if (isset($attributes['customer_image'])) {
                $fileNameCustomer = uniqid() . '.' . $attributes['customer_image']->getClientOriginalExtension();
                $isFileUploadedCustomer = $this->uploadOne($attributes['customer_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileNameCustomer, 'public');
                if ($isFileUploadedCustomer) {
                    $isFileRelatedMediaCreated = $user->media()->updateOrCreate(['user_id' => $id, 'is_profile_picture' => true], [
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $user->id,
                        'media_type' => 'image',
                        'file' => $fileNameCustomer,
                        'is_profile_picture' => true
                    ]);
                    //dd($isFileRelatedMediaCreated);
                }
            }
        }
        return $user;
    }
}
