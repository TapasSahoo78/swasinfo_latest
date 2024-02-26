<?php

namespace App\Http\Controllers\Admin;

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
    public function listBranch()
    {
        $this->setPageTitle('All Branch');
        $filterConditions = [
            'mfi_id' => auth()->user()->mfi_id,
        ];
        $countryList = Country::where('id', '=', '101')->get();
        $states = State::where('country_id', '=', '101')->get();
        $cities = City::where('country_id', '=', '101')->get();

        $listBranch = $this->branchService->listBranch($filterConditions, 'id', 'asc', 15);
        return view('mfi.branch.list', compact('listBranch','countryList', 'states', 'cities'));
    }

    public function store(Request $request)
    {
        //return $request->all();
        if ($request->post()) {
            //dd($request->all());
            $request->validate([
                'name' => 'required|string|unique:branches,name',
                'code' => 'required|string|unique:branches,code',
                'landmark' => 'required|string',
                'country_name' => 'required',
                'state_name' => 'required',
                'city_name' => 'required',
                'zip_code' => 'required',
                'full_address' => 'required',
            ]);
            DB::begintransaction();
            try {
                $isBranchCreated = $this->branchService->createOrUpdateBranch($request->except('_token'));

                if ($isBranchCreated) {
                    DB::commit();
                    $data = ['status' => true, 'message' => 'Branch created successfully', 'data' => ['branch' => $isBranchCreated]];
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
}
