<?php
namespace App\Contracts\Trainers;
/**
 * Interface PageContract
 * @package App\Contracts
 */
interface TrainerContract
{

    /**
     * @param $profileType
     * @param null $filterConditions
     * @param string $orderBy
     * @param string $sortBy
     * @param null $limit
     * @return mixed
     */
    public function findUsers($profileType, $filterConditions = null,
        $orderBy = 'id', $sortBy = 'desc', $limit = null);

    /**
     * Get all admin user
     *
     * @return mixed
     */
    public function getUsers(string $role,array $filterConditions);

    public function listDemands(array $filterConditions, string $orderBy = 'id', string $sortBy = 'desc', $limit = null, $inRandomOrder = false);

    public function getAllUsers($filterConditions,$role,string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false);

    public function listCustomers($filterConditions,$role,string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false);

    public function getCustomersDashboard(string $role,$filterConditions,$limit);

    public function getSellersDashboard(string $role,$filterConditions,$limit);

    public function getEmployeeUsers(string $role,string $type);


    /**
     * Create an admin
     *
     * @param array $params
     * @return mixed
     */
    public function createAdmin(array $params);

    public function createCustomer(array $attributes);
    /* public function createCustomerDemand(array $attributes); */

    public function createUser(array $attributes);

    public function updateUser(array $attributes,int $id);
    public function createProfile(array $attributes,int $id);
    public function createProfileImage(array $attributes,int $id);


    public function registerCustomer(array $attributes);

    public function updateCustomer(array $attributes,int $id);
    /* public function updateCustomerDemand(array $attributes,int $id); */


    public function createAgent(array $attributes);
    public function registerMfiUser(array $attributes);
    public function updateMfiUser(array $attributes,int $id);

    public function updateAgent(array $attributes,int $id);

    public function listUsersAll(array $filterConditions,$role,string $orderBy = 'id', string $sortBy = 'desc', $limit = null, $inRandomOrder = false);

    public function createCustomerPersonalDetails(array $attributes);
    public function createCustomerFamilyDetails(array $attributes);
    public function createCustomerPropertyDetails(array $attributes);
    public function createCustomerOtherLoansDetails(array $attributes);
    public function createCustomerBankDetails(array $attributes);

    public function updateCustomerPersonalDetails(array $attributes,int $id);
    public function updateCustomerFamilyDetails(array $attributes,int $id);


    public function updateCustomerPropertyDetails(array $attributes,int $id);

    public function updateCustomerOtherLoansDetails(array $attributes,int $id);
    public function updateCustomerBankDetails(array $attributes,int $id);

    public function updateOrCreateFamilyDetails(array $attributes);
    public function updateOrCreatePropertyDetails(array $attributes);
    public function updateOrCreateOthernLoanDetails(array $attributes);
    public function updateOrCreateBankDetails(array $attributes);

    public function updateOrCreatePersonalDetails(array $attributes);
    public function updateOrCreateKycDetails(array $attributes,$id);


}
