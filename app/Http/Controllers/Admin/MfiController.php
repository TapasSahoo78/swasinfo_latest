<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Services\Branch\BranchService;
use App\Services\Mfi\MfiService;
use App\Services\User\UserService;
use Illuminate\Http\Request;

class MfiController extends BaseController
{
    protected $mfiService;
    protected $userService;
    protected $branchService;

    public function __construct(MfiService $mfiService, UserService $userService, BranchService $branchService)
    {
        $this->mfiService = $mfiService;
        $this->userService = $userService;
        $this->branchService = $branchService;
    }

    public function listMfi()
    {
        $this->setPageTitle('All MFI');
        $filterConditions = [];
        $countryList = Country::where('id', '=', '101')->get();
        $states = State::where('country_id', '=', '101')->get();
        $cities = City::where('country_id', '=', '101')->get();
        $listMfi = $this->mfiService->listMfi($filterConditions, 'id', 'asc', 15);
        return view('admin.mfi.list', compact('countryList', 'states', 'cities'));
    }

    public function store(Request $request)
    {
        // return $request->all();
        if ($request->post()) {
            // dd($request->file('mfi_image'));
            $request->validate([
                'name' => 'required|string|unique:mfis,name',
                'code' => 'required|string|unique:mfis',
                'registration_number' => 'required|string|unique:mfis,registration_number',
                'contact_person_name' => 'required|string',
                'contact_person_email' => 'required|string|unique:users,email',
                'contact_person_phone' => 'required|string|unique:users,mobile_number',
                'login_id' => 'required|string|min:6|max:8|unique:users,login_id',
                'zip_code' => 'required|numeric|digits:6',
                'full_address' => 'required',
                'mfi_image' => 'required|Mimes:jpeg,jpg,gif,png,svg| dimensions:width=46,height=46',
            ]);
            $request->merge(['branch_name' => $request->name . "  HQ Branch"]);
            // DB::beginTransaction();
            // try{
            $isMfiCreated = $this->mfiService->createOrUpdateMfi($request->except('_token'));
            $request->merge(['mfi_id' => $isMfiCreated->id]);
            $isUserCreated = $this->userService->registerMfiUser($request->except('_token'));
            $isBranchCreated = $this->branchService->createMfiBranch($request->except('_token'));
            if ($isMfiCreated && $isBranchCreated && $isUserCreated) {
                $userBranchData = collect(['branch_id' => $isBranchCreated->id]);
                $isUserCreated->branches()->attach($userBranchData);
                $data = ['status' => true, 'message' => 'MFI created successfully', 'data' => ['user' => $isUserCreated, 'branch' => $isBranchCreated, 'mfi' => $isMfiCreated]];
                return response($data);
            }
            // }catch(\Exception $e){
            //     DB::rollback();
            //     $data= ['status'=>false,'message'=>'Something went wrong'];
            //     logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            //     return response($data);
            //     // return $this->responseRedirectBack('Something went wrong','error',true);
            // }
        }
    }

    public function update(Request $request)
    {
        $id = uuidtoid($request->uuid, 'mfis');
        $userId = $request->user_id;
        $request->validate([
            'name' => 'required|string|unique:mfis,name,' . $id,
            'code' => 'required|string|unique:mfis,code,' . $id,
            'registration_number' => 'required|string|unique:mfis,registration_number,' . $id,
            'contact_person_name' => 'required|string',
            'contact_person_email' => 'required|string|unique:users,email,' . $userId,
            'contact_person_phone' => 'required|string|unique:users,mobile_number,' . $userId,
            'login_id' => 'required|string|min:6|max:8|unique:users,login_id,' . $userId,
            'zip_code' => 'required|numeric|digits:6',
            'full_address' => 'required',
            'mfi_image' => 'nullable|Mimes:jpeg,jpg,gif,png,svg| dimensions:width=46,height=46',
        ]);
        $request->merge(['branch_name' => $request->name . "  HQ Branch"]);
        $isMfiCreated = $this->mfiService->createOrUpdateMfi($request->except('_token'), $id);
        $isUserCreated = $this->userService->registerMfiUser($request->except('_token'), $userId);
        $branchId = $isUserCreated->branches->first()->pivot->branch_id;
        // $branchId = $isUserCreated->branches();
        // dd($branchId);
        $isBranchCreated = $this->branchService->createMfiBranch($request->except('_token'), $branchId);
        if ($isMfiCreated) {
            $data = ['status' => true, 'message' => 'MFI Updated successfully', 'data' => []];
        } else {
            $data = ['status' => false, 'message' => 'MFI Updated failed', 'data' => []];
        }
        return response($data);
    }

}
