<?php

namespace App\Services\Trainer;
use App\Contracts\Trainers\TrainerContract;
use App\Trainer\TrainerRepository;
use App\Contracts\Payment\PaymentContract;
use Illuminate\Support\Facades\Hash;
class TrainerService
{
     /**
     * @var TrainerContract
     */
    protected $trainerRepository;
    /**
     * @var PaymentContract
     */
    protected $paymentRepository;
	/**
     * UserService constructor
     */
    public function __construct(TrainerContract $trainerRepository,PaymentContract $paymentRepository){
        $this->trainerRepository    = $trainerRepository;
        $this->paymentRepository = $paymentRepository;
    }
    /**
     * Find user by id
     *
     * @param int $id
     * @return mixed
     */

     public function findUser(int $id)    {
        //return $this->trainerRepository->find($id);
        return $this->trainerRepository->with('address')
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
        //return $this->trainerRepository->find($id);
        return $this->trainerRepository->find($id);
    }

    public function findUserBy(array $where)    {
        return $this->trainerRepository->findOneBy($where);
    }

    public function registerCustomer(array $attributes){
        return $this->trainerRepository->registerCustomer($attributes);
    }

    public function registerMfiUser(array $attributes,$id= null){

        if (is_null($id)) {
            return $this->trainerRepository->registerMfiUser($attributes);
        } else {
            return $this->trainerRepository->updateMfiUser($attributes, $id);
        }
    }

     /**
     * Get user profile details
     *
     * @param int $userId
     * @return mixed
     */
    public function findUserProfile(int $userId)    {
        return $this->trainerRepository->with('profile')
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
        return $this->trainerRepository->findUserByIds($userIds, $columns);
    }

    public function findUserByFacebook($facebookid){
        // return $this->userRepository->AppServiceProvider ([
        //     'email' => $email
        return $this->trainerRepository->findOneBy ([
            'facebook_id' => $facebookid
        ]);
    }


    public function findUserByGoogle($googleid){
        // return $this->userRepository->AppServiceProvider ([
        //     'email' => $email
        return $this->trainerRepository->findOneBy ([
            'googleplus_id' => $googleid
        ]);
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
        return $this->trainerRepository->findUsers($profileType, $filterConditions, $orderBy, $sortBy, $limit, $inRandomOrder);
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
        return $this->trainerRepository->userSearch($profileType, $filterConditions, $orderBy, $sortBy, $limit, $inRandomOrder);
    }

    public function validatePassword(string $password, int $userId){
        $currentHashedPassword = $this->trainerRepository->find($userId)->password;
        return Hash::check($password, $currentHashedPassword);
    }

    public function saveUserProfileDetails($attributes,$userId){
        $attributes['password'] = Hash::make($attributes['password']);
        if(!empty($attributes['is_password_changed']))
        {
            $attributes['is_password_changed'] = !empty($attributes['is_password_changed']) ? 1 :0;
        }
        return $this->trainerRepository->update($attributes, $userId);
    }
    public function userDetailsUpdate(array $attributes, int $userId){
        return $this->trainerRepository->userUpdate($attributes, $userId);
    }

    public function findUserByUserName($userName)    {
        return $this->trainerRepository->findOneBy([
            'username' => $userName
        ]);
    }

    public function findUserByEmail($email){
        return $this->trainerRepository->findOneBy ([
            'email' => $email
        ]);
    }
    public function findUserByMobile($mobileNumber){
        return $this->trainerRepository->findOneBy([
            'mobile_number' => $mobileNumber
        ]);
    }

    public function updateOrCreateProfile($attributes,$id)
    {
    return $this->trainerRepository->createProfile($attributes,$id);
    }
    public function updateOrCreateAdvanceUserDetails($attributes,$id)
    {
        return $this->trainerRepository->CreateAdvanceUserDetails($attributes,$id);
    }
    public function updateOrCreateUserFoodItems($attributes,$id)
    {
        return $this->trainerRepository->CreateUserFoodItems($attributes,$id);
    }
    public function updateOrCreateHealthWorkout($attributes,$id)
    {
        return $this->trainerRepository->updateOrCreateHealthWorkout($attributes,$id);
    }

    public function updateOrCreateProfileImage($attributes,$id)
    {
        return $this->trainerRepository->createProfileImage($attributes,$id);

    }



    public function listUsersAll(array $filterConditions,$role,string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->trainerRepository->listUsersAll($filterConditions,$role, $orderBy, $sortBy, $limit);
    }
    public function listCustomers(array $filterConditions,string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->trainerRepository->listCustomers($filterConditions,'customer',$orderBy, $sortBy, $limit);
    }

    /*ZM TESTED*/

    public function getAdmins(){
        return $this->trainerRepository->getUsers('admin');
    }

    public function getSellers()
    {
        return $this->trainerRepository->getUsers('seller');
    }
    public function getSellersDashboard($role,$filterConditions,$limit)
    {
        return $this->trainerRepository->getSellersDashboard($role,$filterConditions,$limit);
    }
    public function getCustomers($role,$filterConditions)
    {
        return $this->trainerRepository->getUsers($role,$filterConditions);
    }
    public function getCustomersDashboard($role,$filterConditions,$limit)
    {
        return $this->trainerRepository->getCustomersDashboard($role,$filterConditions,$limit);
    }

    public function getEmployees(string $role,string $type)
    {
        return $this->trainerRepository->getEmployeeUsers($role,$type);
    }

    public function getAllUsers($filterConditions,$role,string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->trainerRepository->getAllUsers($filterConditions,$role,$orderBy,$sortBy);
    }

    public function createOrUpdateCustomer($attributes,$id=null){

        if(!is_null($id)){
            return $this->trainerRepository->updateCustomer($attributes,$id);
        }
        return $this->trainerRepository->createCustomer($attributes);
        
    }

    public function createOrUpdatefaceCustomer($attributes,$id=null){
        
        return $this->trainerRepository->createfaceCustomer($attributes);
    }


    public function createOrUpdateTrainer($attributes,$id=null){
        
        if(!is_null($id)){
            return $this->trainerRepository->updateTrainer($attributes,$id);
        }
        return $this->trainerRepository->createTrainer($attributes);
    }
    public function createOrUpdateCustomerFamily($attributes){
        // return $attributes;
        return $this->trainerRepository->updateOrCreateFamilyDetails($attributes);
    }
    public function updateOrCreatePropertyDetails($attributes){
        // return $attributes;
        return $this->trainerRepository->updateOrCreatePropertyDetails($attributes);
    }
    public function updateOrCreateOthernLoanDetails($attributes){
        // return $attributes;
        return $this->trainerRepository->updateOrCreateOthernLoanDetails($attributes);
    }
    public function updateOrCreateBankDetails($attributes){
        // return $attributes;
        return $this->trainerRepository->updateOrCreateBankDetails($attributes);
    }
    public function updateOrCreateKycDetails($attributes,$id=null){
        // return $attributes;

        return $this->trainerRepository->updateOrCreateKycDetails($attributes,$id);
    }
    public function updateOrCreatePersonalDetails($attributes){
        // return $attributes;
        return $this->trainerRepository->updateOrCreatePersonalDetails($attributes);
    }
    public function createOrUpdateUser($attributes,$id=null){
        if(!is_null($id)){
            return $this->trainerRepository->updateUser($attributes,$id);
        }
        return $this->trainerRepository->createUser($attributes);
    }

    public function createOrUpdateAgent($attributes,$id=null){
        if(!is_null($id)){
            return $this->trainerRepository->updateAgent($attributes,$id);
        }
        return $this->trainerRepository->createAgent($attributes);
    }

    /**
     * Create an admin
     *
     * @param array $params
     * @return mixed
     */
    public function createAdmin(array $params){
        return $this->trainerRepository->createAdmin($params);
    }


    public function findMultipleUserBy(array $params)    {
        return $this->trainerRepository->findBy($params);
    }


    public function listUsers()    {
        return $this->trainerRepository->listUsers();
    }

     /**
     * Update user profile image
     *
     * @param array $params
     * @param int $id
     * @return bool
     */
    public function updateProfileImage($uploadedFile, int $id)    {
        $updated = $this->trainerRepository->updateProfileImage($uploadedFile, $id);
        return ($updated);
    }

    public function findById($id)    {
        return $this->trainerRepository->find($id);
    }

    public function getSpecificPermissions()
    {
        return $this->trainerRepository->getSpecifiedPermissions();
    }
     public function findDemandById($id){
        return $this->trainerRepository->findDemandById($id);
    }



    public function updateUserDetails($attributes,$id){
        return $this->trainerRepository->updateDetails($attributes,$id);
    }
    public function updateUserStatus(array $attributes,$id){
        return $this->trainerRepository->update($attributes,$id);
    }

    public function deleteUser($request){
      $id=uuidtoid($request['uuid'],'users');
      $user=$this->trainerRepository->find($id);
      $isUserDeleted= $user->delete($id);
      if($isUserDeleted){
        $user->profile()->delete();
      }
      return $isUserDeleted;
    }
    public function userDelete($request){
      $id=uuidtoid($request['uuid'],'users');
      $user=$this->trainerRepository->find($id);
      $isDeletedUser= $user->delete($id);
      if($isDeletedUser){
        $user->address()->delete();
      }
      return $isDeletedUser;
    }
    public function deleteDocument($id){
      $document=$this->trainerRepository->findDocument($id);
      return $document->delete($id);
    }

    public function updateSeller(array $attributes,int $id)    {
        return $this->trainerRepository->updateSeller($attributes, $id);
    }

    /* public function createSeller($request) {
        return $this->trainerRepository->createAdmin($request);
    } */

    public function findAddress($id){
        return $this->trainerRepository->findAddress($id);
    }
    public function createOrUpdateAddress($attributes,$id=null){
        if(!is_null($id)){
            return $this->trainerRepository->updateAddress($attributes,$id);
        }else{
            return $this->trainerRepository->createAddress($attributes);
        }

    }

    public function deleteAddress($id){
        return $this->trainerRepository->deleteAddress($id);
    }


    public function createOrUpdateCart(array $attributes){
        return $this->trainerRepository->createOrUpdateCart($attributes);
    }

    public function createCustomerPersonalDetails($attributes,$id=null){
        /* if(!is_null($id)){
            return $this->trainerRepository->updateCustomer($attributes,$id);
        } */
        return $this->trainerRepository->createCustomerPersonalDetails($attributes);
    }
    public function updateCustomerPersonalDetails($attributes,$id){

        return $this->trainerRepository->updateCustomerPersonalDetails($attributes,$id);
    }
    public function createCustomerFamilyDetails($attributes,$id=null){

        return $this->trainerRepository->createCustomerFamilyDetails($attributes);
    }
    public function updateCustomerFamilyDetails($attributes,$id){

        return $this->trainerRepository->updateCustomerFamilyDetails($attributes,$id);
    }
    public function createCustomerPropertyDetails($attributes){
        /* if(!is_null($id)){
            return $this->trainerRepository->updateCustomer($attributes,$id);
        } */
        return $this->trainerRepository->createCustomerPropertyDetails($attributes);
    }
    public function updateCustomerPropertyDetails($attributes,$id){

        return $this->trainerRepository->updateCustomerPropertyDetails($attributes,$id);
    }

    public function createCustomerOtherLoansDetails($attributes){
        /* if(!is_null($id)){
            return $this->trainerRepository->updateCustomer($attributes,$id);
        } */
        return $this->trainerRepository->createCustomerOtherLoansDetails($attributes);
    }

    public function updateCustomerOtherLoansDetails($attributes,$id){

        return $this->trainerRepository->updateCustomerOtherLoansDetails($attributes,$id);
    }

    public function createCustomerBankDetails($attributes){
        /* if(!is_null($id)){
            return $this->trainerRepository->updateCustomer($attributes,$id);
        } */
        return $this->trainerRepository->createCustomerBankDetails($attributes);
    }
    public function updateCustomerBankDetails($attributes,$id){

        return $this->trainerRepository->updateCustomerBankDetails($attributes,$id);
    }


    public function createOrUpdateKycDetails(array $attributes, $id = null)
    {

        if (is_null($id)) {
            return $this->trainerRepository->createKycDetails($attributes);
        } else {
            return $this->trainerRepository->updateKycDetails($attributes, $id);
        }
    }
    public function createOrUpdateCustomerDemand(array $attributes, $id = null)
    {

        if (is_null($id)) {
            return $this->trainerRepository->createCustomerDemand($attributes);
        } else {
            return $this->trainerRepository->updateCustomerDemand($attributes, $id);
        }
    }

    public function listDemands(array $filterConditions, string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->trainerRepository->listDemands($filterConditions, $orderBy, $sortBy, $limit);
    }

    public function updateDemandStatus(array $attributes,$id){
        $data['status']= $attributes['value'] == '1' ? 1 : 0;
        return $this->trainerRepository->updateDemandStatus($data,$id);
    }

    public function deleteDemand(int $id){
        return $this->trainerRepository->deleteDemand($id);
    }

    public function demandStatusChange(array $attributes, int $id)
    {
            return $this->trainerRepository->demandStatusChange($attributes, $id);
    }





}
