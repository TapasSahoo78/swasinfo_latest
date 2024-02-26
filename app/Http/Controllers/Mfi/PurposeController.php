<?php

namespace App\Http\Controllers\Mfi;

use App\Http\Controllers\BaseController;
use App\Services\Branch\BranchService;
use App\Services\Loan\LoanService;
use App\Services\Purpose\PurposeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurposeController extends BaseController
{
    protected $purposeService;
    protected $branchService;
    protected $loanService;
    public function __construct(PurposeService $purposeService, BranchService $branchService, LoanService $loanService)
    {
        $this->purposeService = $purposeService;
        $this->branchService = $branchService;
        $this->loanService = $loanService;

    }
    public function listPurpose(Request $request)
    {
        $this->setPageTitle('All Purposes');

        /* $filterConditions = [
        'mfi_id' => auth()->user()->mfi_id,
        'status' => 1,
        ];
        $filterLoanConditions = [
        'mfi_id' => auth()->user()->mfi_id,
        'status' => 1,
        ]; */
        $filterPurposeConditions = [
            'mfi_id' => auth()->user()->mfi_id,
        ];
        if($request->has('purpose_name')){
            $filterPurposeConditions['purpose_name']= $request->purpose_name ;
        }

        /*  $listBranch = $this->branchService->listBranch($filterConditions, 'id', 'asc', 15);

        $listLoan = $this->loanService->listLoan($filterLoanConditions, 'id', 'asc', 15); */

        $listPurpose = $this->purposeService->listPurpose($filterPurposeConditions, 'id', 'asc', 15);

        return view('mfi.purpose.list', compact('listPurpose'));
    }

    public function store(Request $request)
    {
        if ($request->post()) {
            $id = $request->id;
            if (!empty($id)) {
                $request->validate([
                    'name' => 'required|string|unique:purposes,name,' . $id,
                    'note' => 'required|string'
                    /* 'min_amount' => 'required|numeric|min:30|regex:/^[0-9]+$/',
                'max_amount' => 'required|numeric|gt:min_amount|regex:/^[0-9]+$/', */
                ]);
                $message = "Purpose Updated Successfully";
            } else {
                $request->validate([
                    'name' => 'required|string|unique:purposes,name',
                    'note' => 'required|string',
                ]);
                $message = "Purpose Created Successfully";
            }

            /* $request->validate([
                  'branch_id' => 'required|array',
                'lone_type_id' => 'required|exists:loans,uuid',
                'name' => 'required|string',
                'note' => 'required|string',
            ]); */
            DB::begintransaction();
            try {
                $isPurposeCreated = $this->purposeService->createOrUpdatePurpose($request->except('_token'),$id);

                if ($isPurposeCreated) {
                    DB::commit();
                    $data = ['status' => true, 'message' => $message, 'data' => ['purpose' => $isPurposeCreated]];
                    return response($data);

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
