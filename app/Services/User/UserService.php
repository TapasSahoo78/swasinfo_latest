<?php
namespace App\Services\User;
use App\Contracts\Users\UserContract;
use App\User\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Contracts\Payment\PaymentContract;
class UserService
{

    /**
     * @var UserContract
     */
    protected $userRepository;
    /**
     * @var PaymentContract
     */
    protected $paymentRepository;

	/**
     * UserService constructor
     */
    public function __construct(UserContract $userRepository,PaymentContract $paymentRepository){
        $this->userRepository    = $userRepository;
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * Find user by id
     *
     * @param int $id
     * @return mixed
     */
    public function findUser(int $id)    {
        //return $this->userRepository->find($id);
        return $this->userRepository->with('address')
    ->where('id', $id)
    ->first();

    }
    /**
     * Find user by id
     *
     * @param int $id
     * @return mixed
     */
    public function findCustomer(int $id)    {
        //return $this->userRepository->find($id);
        return $this->userRepository->find($id);

    }

    public function findUserBy(array $where)    {
        return $this->userRepository->findOneBy($where);
    }

    public function registerCustomer(array $attributes){
        return $this->userRepository->registerCustomer($attributes);
    }

    public function registerMfiUser(array $attributes,$id= null){

        if (is_null($id)) {
            return $this->userRepository->registerMfiUser($attributes);
        } else {
            return $this->userRepository->updateMfiUser($attributes, $id);
        }
    }

     /**
     * Get user profile details
     *
     * @param int $userId
     * @return mixed
     */
    public function findUserProfile(int $userId)    {
        return $this->userRepository->with('profile')
            ->where('id', $userId)
            ->first();
    }

    /**
     * Fetch list of users by user ids
     *
     * @param array $userIds
     * @param array $columns
     * @return mixed
     */
    public function findUserByIds(array $userIds, array $columns){
        return $this->userRepository->findUserByIds($userIds, $columns);
    }

    /**
     * Find list of users based on certain condition
     *
     * @param $profileType
     * @param null $filterConditions
     * @param int $status
     * @param string $sortBy
     * @param null $limit
     * @return mixed
     */
    public function findUsers($profileType, $filterConditions = null,
        $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)    {
        return $this->userRepository->findUsers($profileType, $filterConditions, $orderBy, $sortBy, $limit, $inRandomOrder);
    }

    /**
     * Find list of users for frontend based on certain condition
     *
     * @param $profileType
     * @param null $filterConditions
     * @param int $status
     * @param string $sortBy
     * @param null $limit
     * @return mixed
     */
    public function userSearch($profileType, $filterConditions = null,
        $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)    {
        return $this->userRepository->userSearch($profileType, $filterConditions, $orderBy, $sortBy, $limit, $inRandomOrder);
    }

    public function validatePassword(string $password, int $userId){
        $currentHashedPassword = $this->userRepository->find($userId)->password;
        return Hash::check($password, $currentHashedPassword);
    }

    public function saveUserProfileDetails($attributes,$userId){
        $attributes['password'] = Hash::make($attributes['password']);
        if(!empty($attributes['is_password_changed']))
        {
            $attributes['is_password_changed'] = !empty($attributes['is_password_changed']) ? 1 :0;
        }
        return $this->userRepository->update($attributes, $userId);
    }
    public function userDetailsUpdate(array $attributes, int $userId){
        return $this->userRepository->userUpdate($attributes, $userId);
    }

    public function findUserByUserName($userName)    {
        return $this->userRepository->findOneBy([
            'username' => $userName
        ]);
    }



    public function findUserByEmail($email){
        // return $this->userRepository->AppServiceProvider ([
        //     'email' => $email
        return $this->userRepository->findOneBy ([
            'email' => $email
        ]);
    }
    public function findUserByMobile($mobileNumber){
        return $this->userRepository->findOneBy([
            'mobile_number' => $mobileNumber
        ]);

    }


    public function findUserByFacebook($facebookid){
        // return $this->userRepository->AppServiceProvider ([
        //     'email' => $email
        return $this->userRepository->findOneBy ([
            'facebook_id' => $facebookid
        ]);
    }


    public function findUserByGoogle($googleid){
        // return $this->userRepository->AppServiceProvider ([
        //     'email' => $email
        return $this->userRepository->findOneBy ([
            'googleplus_id' => $googleid
        ]);
    }

    public function createOrUpdateCustomer($attributes,$id=null){
        if(!is_null($id)){
            return $this->userRepository->updateCustomer($attributes,$id);
        }
        return $this->userRepository->createCustomer($attributes);
    }

    public function createOrUpdatefaceCustomer($attributes,$id=null){
        
        return $this->userRepository->createfaceCustomer($attributes);
    }




    public function updateOrCreateProfile($attributes,$id)
    {
        return $this->userRepository->createProfile($attributes,$id);
    }
    public function updateOrCreateAdvanceUserDetails($attributes,$id)
    {
        return $this->userRepository->CreateAdvanceUserDetails($attributes,$id);
    }
    public function updateOrCreateUserFoodItems($attributes,$id)
    {
        return $this->userRepository->CreateUserFoodItems($attributes,$id);
    }
    public function updateOrCreateHealthWorkout($attributes,$id)
    {
        return $this->userRepository->updateOrCreateHealthWorkout($attributes,$id);
    }

    public function updateOrCreateProfileImage($attributes,$id)
    {
        return $this->userRepository->createProfileImage($attributes,$id);

    }



    public function listUsersAll(array $filterConditions,$role,string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->userRepository->listUsersAll($filterConditions,$role, $orderBy, $sortBy, $limit);
    }
    public function listCustomers(array $filterConditions,string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->userRepository->listCustomers($filterConditions,'customer',$orderBy, $sortBy, $limit);
    }




    /*ZM TESTED*/

    public function getAdmins($role,$filterConditions){
        return $this->userRepository->getAdminUsers($role,$filterConditions);
    }

    public function getAdminscount($role,$filterConditions){
        return $this->userRepository->getAdminUserscount($role,$filterConditions);
    }

    public function getSellers()
    {
        return $this->userRepository->getUsers('seller');
    }
    public function getSellersDashboard($role,$filterConditions,$limit)
    {
        return $this->userRepository->getSellersDashboard($role,$filterConditions,$limit);
    }
    public function getCustomers($role,$filterConditions)
    {
        return $this->userRepository->getUsers($role,$filterConditions);
    }

    public function getCustomersales($role,$filterConditions)
    {
        return $this->userRepository->getUserssales($role,$filterConditions);
    }

    public function getCustomerscount($role,$filterConditions)
    {
        return $this->userRepository->getUserscount($role,$filterConditions);
    }

    public function gettranactionCustomers($role,$filterConditions)
    {
        return $this->userRepository->gettransactionUsers($role,$filterConditions);
    }
    public function getCustomersDashboard($role,$filterConditions,$limit)
    {
        return $this->userRepository->getCustomersDashboard($role,$filterConditions,$limit);
    }

    public function getEmployees(string $role,string $type)
    {
        return $this->userRepository->getEmployeeUsers($role,$type);
    }

    public function getAllUsers($filterConditions,$role,string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->userRepository->getAllUsers($filterConditions,$role,$orderBy,$sortBy);
    }


    public function createOrUpdateTrainer($attributes,$id=null){
        if(!is_null($id)){
            return $this->userRepository->updateTrainer($attributes,$id);
        }
        return $this->userRepository->createTrainer($attributes);
    }

    public function createOrUpdateDoctor($attributes,$id=null){
        if(!is_null($id)){
            return $this->userRepository->updateDoctor($attributes,$id);
        }
        return $this->userRepository->createDoctor($attributes);
    }

    public function createOrUpdateSales($attributes,$id=null){
        if(!is_null($id)){
            return $this->userRepository->updateSales($attributes,$id);
        }
        return $this->userRepository->createSales($attributes);
    }

    public function createOrUpdateCustomerFamily($attributes){
        // return $attributes;
        return $this->userRepository->updateOrCreateFamilyDetails($attributes);
    }
    public function updateOrCreatePropertyDetails($attributes){
        // return $attributes;
        return $this->userRepository->updateOrCreatePropertyDetails($attributes);
    }
    public function updateOrCreateOthernLoanDetails($attributes){
        // return $attributes;
        return $this->userRepository->updateOrCreateOthernLoanDetails($attributes);
    }
    public function updateOrCreateBankDetails($attributes){
        // return $attributes;
        return $this->userRepository->updateOrCreateBankDetails($attributes);
    }
    public function updateOrCreateKycDetails($attributes,$id=null){
        // return $attributes;

        return $this->userRepository->updateOrCreateKycDetails($attributes,$id);
    }
    public function updateOrCreatePersonalDetails($attributes){
        // return $attributes;
        return $this->userRepository->updateOrCreatePersonalDetails($attributes);
    }
    public function createOrUpdateUser($attributes,$id=null){
        if(!is_null($id)){
            return $this->userRepository->updateUser($attributes,$id);
        }
        return $this->userRepository->createUser($attributes);
    }

    public function createOrUpdateAgent($attributes,$id=null){
        if(!is_null($id)){
            return $this->userRepository->updateAgent($attributes,$id);
        }
        return $this->userRepository->createAgent($attributes);
    }


    public function createOrUpdateVendor($attributes,$id=null){
        if(!is_null($id)){
        return $this->userRepository->updateVendor($attributes,$id);
        }
        return $this->userRepository->createVendor($attributes);
    }


    /**
     * Create an admin
     *
     * @param array $params
     * @return mixed
     */
    public function createAdmin(array $params){
        return $this->userRepository->createAdmin($params);
    }


    public function findMultipleUserBy(array $params)    {
        return $this->userRepository->findBy($params);
    }


    public function listUsers()    {
        return $this->userRepository->listUsers();
    }


     /**
     * Update user profile image
     *
     * @param array $params
     * @param int $id
     * @return bool
     */
    public function updateProfileImage($uploadedFile, int $id)    {
        $updated = $this->userRepository->updateProfileImage($uploadedFile, $id);
        return ($updated);
    }

    public function findById($id)    {
        return $this->userRepository->find($id);
    }

    public function getSpecificPermissions()
    {
        return $this->userRepository->getSpecifiedPermissions();
    }
     public function findDemandById($id){
        return $this->userRepository->findDemandById($id);
    }



    public function updateUserDetails($attributes,$id){
        return $this->userRepository->updateDetails($attributes,$id);
    }
    public function updateUserStatus(array $attributes,$id){
        return $this->userRepository->update($attributes,$id);
    }

    public function deleteUser($request){
      $id=uuidtoid($request['uuid'],'users');
      $user=$this->userRepository->find($id);
      $isUserDeleted= $user->delete($id);
      if($isUserDeleted){
        $user->profile()->delete();
      }
      return $isUserDeleted;
    }
    public function userDelete($request){
      $id=uuidtoid($request['uuid'],'users');
      $user=$this->userRepository->find($id);
      $isDeletedUser= $user->delete($id);
    //   if($isDeletedUser){
    //     $user->roles()->detach();
    //   }
      return $isDeletedUser;
    }
    public function deleteDocument($id){
      $document=$this->userRepository->findDocument($id);
      return $document->delete($id);
    }

    public function updateSeller(array $attributes,int $id)    {
        return $this->userRepository->updateSeller($attributes, $id);
    }

    /* public function createSeller($request) {
        return $this->userRepository->createAdmin($request);
    } */

    public function findAddress($id){
        return $this->userRepository->findAddress($id);
    }
    public function createOrUpdateAddress($attributes,$id=null){
        if(!is_null($id)){
            return $this->userRepository->updateAddress($attributes,$id);
        }else{
            return $this->userRepository->createAddress($attributes);
        }

    }

    public function deleteAddress($id){
        return $this->userRepository->deleteAddress($id);
    }


    public function createOrUpdateCart(array $attributes){
        return $this->userRepository->createOrUpdateCart($attributes);
    }

    public function createCustomerPersonalDetails($attributes,$id=null){
        /* if(!is_null($id)){
            return $this->userRepository->updateCustomer($attributes,$id);
        } */
        return $this->userRepository->createCustomerPersonalDetails($attributes);
    }
    public function updateCustomerPersonalDetails($attributes,$id){

        return $this->userRepository->updateCustomerPersonalDetails($attributes,$id);
    }
    public function createCustomerFamilyDetails($attributes,$id=null){

        return $this->userRepository->createCustomerFamilyDetails($attributes);
    }
    public function updateCustomerFamilyDetails($attributes,$id){

        return $this->userRepository->updateCustomerFamilyDetails($attributes,$id);
    }
    public function createCustomerPropertyDetails($attributes){
        /* if(!is_null($id)){
            return $this->userRepository->updateCustomer($attributes,$id);
        } */
        return $this->userRepository->createCustomerPropertyDetails($attributes);
    }
    public function updateCustomerPropertyDetails($attributes,$id){

        return $this->userRepository->updateCustomerPropertyDetails($attributes,$id);
    }

    public function createCustomerOtherLoansDetails($attributes){
        /* if(!is_null($id)){
            return $this->userRepository->updateCustomer($attributes,$id);
        } */
        return $this->userRepository->createCustomerOtherLoansDetails($attributes);
    }

    public function updateCustomerOtherLoansDetails($attributes,$id){

        return $this->userRepository->updateCustomerOtherLoansDetails($attributes,$id);
    }

    public function createCustomerBankDetails($attributes){
        /* if(!is_null($id)){
            return $this->userRepository->updateCustomer($attributes,$id);
        } */
        return $this->userRepository->createCustomerBankDetails($attributes);
    }
    public function updateCustomerBankDetails($attributes,$id){

        return $this->userRepository->updateCustomerBankDetails($attributes,$id);
    }


    public function createOrUpdateKycDetails(array $attributes, $id = null)
    {

        if (is_null($id)) {
            return $this->userRepository->createKycDetails($attributes);
        } else {
            return $this->userRepository->updateKycDetails($attributes, $id);
        }
    }
    public function createOrUpdateCustomerDemand(array $attributes, $id = null)
    {

        if (is_null($id)) {
            return $this->userRepository->createCustomerDemand($attributes);
        } else {
            return $this->userRepository->updateCustomerDemand($attributes, $id);
        }
    }

    public function listDemands(array $filterConditions, string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->userRepository->listDemands($filterConditions, $orderBy, $sortBy, $limit);
    }

    public function updateDemandStatus(array $attributes,$id){
        $data['status']= $attributes['value'] == '1' ? 1 : 0;
        return $this->userRepository->updateDemandStatus($data,$id);
    }

    public function deleteDemand(int $id){
        return $this->userRepository->deleteDemand($id);
    }

    public function demandStatusChange(array $attributes, int $id)
    {
            return $this->userRepository->demandStatusChange($attributes, $id);
    }



}
