<?php

namespace App\Http\Controllers\Mfi;

use App\Http\Controllers\BaseController;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Services\Branch\BranchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchController extends BaseController
{
    protected $branchService;
    public function __construct(BranchService $branchService)
    {
        $this->branchService = $branchService;

    }
    public function listBranch(Request $request)
    {
        $this->setPageTitle('All Branch');

        $countryList = Country::where('id', '=', '101')->get();
        $states = State::where('country_id', '=', '101')->get();
        $cities = City::where('country_id', '=', '101')->get();
        $filterConditions = [
            'mfi_id' => auth()->user()->mfi_id
        ];
        if($request->has('branch')){
            $filterConditions['branch']= $request->branch ;
        }
        if($request->has('brcode')){
            $filterConditions['brcode']= $request->brcode ;
        }

        $listBranch = $this->branchService->listBranch($filterConditions, 'id', 'asc', 15);
        // dd($listBranch->toArray());
        return view('mfi.branch.list', compact('listBranch','countryList', 'states', 'cities'));
    }

    public function store(Request $request)
    {
        //return $request->all();
        if ($request->post()) {
            $id = $request->id;
            if (!empty($id)) {
                $request->validate([
                    'name' => 'required|string|unique:branches,name,' . $id,
                    'code' => 'required|string|unique:branches,code,' . $id,
                    'landmark' => 'required|string',
                    'country_name' => 'required|string',
                    'state_name' => 'required|string',
                    'city_name' => 'required|string',
                    'zip_code' => 'required|numeric|digits:6',
                    'full_address' => 'required|string',
                    /* 'min_amount' => 'required|numeric|min:30|regex:/^[0-9]+$/',
                'max_amount' => 'required|numeric|gt:min_amount|regex:/^[0-9]+$/', */
                ]);
                $message = "Branch Updated Successfully";
            } else {
                $request->validate([
                    'name' => 'required|string|unique:branches,name',
                    'code' => 'required|string|unique:branches,code',
                    'landmark' => 'required|string',
                    'country_name' => 'required|string',
                    'state_name' => 'required|string',
                    'city_name' => 'required|string',
                    'zip_code' => 'required|numeric|digits:6',
                    'full_address' => 'required|string',
                ]);
                $message = "Branch Created Successfully";
            }

            //dd($request->all());
            /* $request->validate([
            'name' => 'required|string|unique:branches,name',
            'code' => 'required|string|unique:branches,code',
            'landmark' => 'required|string',
            'country_name' => 'required',
            'state_name' => 'required',
            'city_name' => 'required',
            'zip_code' => 'required',
            'full_address' => 'required',
            ]); */

            DB::begintransaction();
            try {
                $isBranchCreated = $this->branchService->createOrUpdateBranch($request->except('_token'), $id);

                if ($isBranchCreated) {
                    /*  $userBranchData = ['user_id' => auth()->user()->id, 'branch_id' => $isBranchCreated->id];
                    UserBranch::create($userBranchData); */
                    DB::commit();
                    $data = ['status' => true, 'message' => $message, 'data' => ['branch' => $isBranchCreated]];
                    return response($data);

                    /* return $this->responseRedirectBack('Profile updated successfully', 'success', false); */
                }
            } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                $data = ['status' => false, 'message' => 'Something went wrong !!', 'data' => []];
                return response($data);

            }

        }
    }

    public function actionOfAreaUpdate(Request $request)
    {
        // return $request->all();
        if ($request->post()) {
            $id = $request->branch_opreation_id;
            //dd($request->all());
            if (!empty($id)) {
                $request->validate([
                    'branch_id' => 'required|string|unique:branch_operation_areas,branch_id,' . $id,
                    'zone_name' => 'required',
                    'country_name' => 'required|string',
                    'states_name' => 'required|string',
                    'cities_name' => 'required|array',
                    'zip_codes' => 'nullable|array',
                    // 'mfi_id' => 'required|string',

                ]);
                $message = "Branch Operation Area Updated Successfully";
            } else {
                $request->validate([
                    'branch_id' => 'required|string|unique:branch_operation_areas,branch_id',
                    'zone_name' => 'required',
                    'country_name' => 'required|string',
                    'states_name' => 'required|string',
                    'cities_name' => 'required|array',
                    'zip_codes' => 'nullable|array',
                    // 'mfi_id' => 'required|string',
                ]);
                $message = "Branch Operation Area Created Successfully";
            }

            // DB::begintransaction();
            // try {
                $isBranchOperationAreaCreated = $this->branchService->createOrUpdateBranchOperationArea($request->except('_token'), $id);

                if ($isBranchOperationAreaCreated) {

                    // DB::commit();
                    $data = ['status' => true, 'message' => $message, 'data' => ['branch' => $isBranchOperationAreaCreated]];
                    return response($data);

                    /* return $this->responseRedirectBack('Profile updated successfully', 'success', false); */
                }
            // } catch (\Exception$e) {
            //     DB::rollBack();
            //     logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            //     $data = ['status' => false, 'message' => 'Something went wrong !!', 'data' => []];
            //     return response($data);

            // }

        }
    }
}
