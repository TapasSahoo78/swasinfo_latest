<?php

namespace App\Http\Controllers\Mfi;

use App\Http\Controllers\BaseController;
use App\Services\Account\AccountService;
use App\Services\Branch\BranchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends BaseController
{
    protected $accountService;
     protected $branchService;
    public function __construct(AccountService $accountService,BranchService $branchService)
    {
        $this->accountService = $accountService;
        $this->branchService = $branchService;

    }
    public function listAccounts()
    {
        $this->setPageTitle('All Accounts');
        $filterConditions = [
            'mfi_id' => auth()->user()->mfi_id
        ];
         $filterBranchConditions = [
            /* 'mfi_id' => auth()->user()->mfi_id, */
            'status' => 1
        ];
        $listAccount = $this->accountService->listAccount($filterConditions, 'id', 'asc', 15);
        $listBranch = $this->branchService->listBranch($filterBranchConditions, 'id', 'asc', 15);
        //dd($listBranch->toArray());
        return view('mfi.account.list', compact('listAccount','listBranch'));
    }

    public function store(Request $request)
    {
        if ($request->post()) {
            $id = $request->id;

            /* dd($request->all()); */
            if (!empty($id)) {
                $request->validate([
                    'branch_id' => 'required|exists:branches,id',
                    'account_type' => 'required',
                    /* 'account_sub_type' => 'required', */
                    'account_name' => 'required|string',
                    /* 'account_number' => 'required_if:account_sub_type,1|numeric|unique:accounts,account_number,' . $id, */
                    /* 'ifsc_code' => 'required_if:account_sub_type,1|regex:/^[\w-]*$/|unique:accounts,ifsc_code,' . $id,
                    'account_holder_name' => 'required_if:account_sub_type,1|string',
                    'upi_id' => 'required_if:account_sub_type,3|nullable|numeric|unique:accounts,upi_id,' . $id, */
                    'opening_balance' => 'required|numeric|min:1|regex:/^[0-9]+$/',
                    'note'=>'required|string'
                ]);

                $message = "Account Updated Successfully";

            } else {
                $request->validate([
                    'branch_id' => 'required|exists:branches,id',
                    'account_type' => 'required',
                    /* 'account_sub_type' => 'required', */
                    'account_name' => 'required|string',
                    /* 'account_number' => 'required_if:account_sub_type,1|nullable|numeric|unique:accounts,account_number',
                    'ifsc_code' => 'required_if:account_sub_type,1|regex:/^[\w-]*$/|nullable|unique:accounts,ifsc_code',
                    'account_holder_name' => 'required_if:account_sub_type,1|nullable|string', */
                    'opening_balance' => 'required|numeric|min:1|regex:/^[0-9]+$/',
                    'note'=>'required|string'
                ]);
                /* if($request->account_sub_type == '3'){
                $request->validate([
                'upi_id' => 'required_if:account_sub_type,3|nullable|numeric|unique:accounts,upi_id',
                ]);
                }
                if($request->account_sub_type == '1'){
                $request->validate([
                'account_number' => 'required_if:account_sub_type,1|numeric|unique:accounts,account_number',
                'ifsc_code' => 'required_if:account_sub_type,1|regex:/^[\w-]*$/|unique:accounts,ifsc_code',
                'account_holder_name' => 'required_if:account_sub_type,1|string',
                ]);
                } */

                $message = "Account Created Successfully";
            }
            // DB::begintransaction();
            // try {
            $isAccountCreated = $this->accountService->createOrUpdateAccount($request->except('_token'), $id);

            if ($isAccountCreated) {
                DB::commit();
                $data = ['status' => true, 'message' => $message, 'data' => ['account' => $isAccountCreated]];
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
