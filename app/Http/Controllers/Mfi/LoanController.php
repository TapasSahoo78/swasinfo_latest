<?php

namespace App\Http\Controllers\Mfi;

use App\Http\Controllers\BaseController;
use App\Models\Branch;
// use App\Models\Loan;
use App\Services\Loan\LoanService;
use App\Services\Branch\BranchService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class LoanController extends BaseController
{
    protected $loanService;
    protected $branchService;

    public function __construct(LoanService $loanService,BranchService $branchService)
    {
        $this->loanService = $loanService;
        $this->branchService = $branchService;
    }
    public function listLoans(Request $request)
    {
        $this->setPageTitle('All Loan Products');
        $filterConditions = [
            'mfi_id' => auth()->user()->mfi_id,
        ];
        $filterLoanConditions = [
            'mfi_id' => auth()->user()->mfi_id
        ];
         if($request->has('loan_product_name')){
            $filterLoanConditions['loan_product_name']= $request->loan_product_name ;
        }
        if($request->has('loan_code')){
            $filterLoanConditions['loan_code']= $request->loan_code ;
        }
        $branches = $this->branchService->listBranch($filterConditions, 'id', 'asc');
        $listLoan = $this->loanService->listLoan($filterLoanConditions, 'id', 'asc', 15);
        //dd($listLoan->toArray());
        return view('mfi.loan.loan', compact('listLoan','branches'));
    }

    public function store(Request $request)
    {
        // return $request->all();
        if ($request->post()) {
            //dd($request->all());
            $id = $request->id;
            if(!empty($id))
            {
                $request->validate([
                    'branches' => 'required|array',
                    'applicability' => 'required',
                    'name' => 'required|string|unique:loans,name,'.$id,
                    'code' => 'required|string|unique:loans,code,'.$id,
                    'maturity_amount'=>'required|numeric|min:100|regex:/^[0-9]+$/',
                    'principal_amount'=>'required|numeric|min:100|regex:/^[0-9]+$/',
                    'tenure'=>'required|numeric|max:200|regex:/^[0-9]+$/',
                    // 'no_of_kist'=>'required|numeric|lt:tenure|regex:/^[0-9]+$/'
                ]);
                $message="Loan Product updated successfully";
            }else
            {
                $request->validate([
                    'branches' => 'required|array',
                    'applicability' => 'required',
                    'name' => 'required|string|unique:loans,name',
                    'code' => 'required|string|unique:loans,code',
                    'maturity_amount'=>'required|numeric|min:100|regex:/^[0-9]+$/',
                    'principal_amount'=>'required|numeric|min:100|regex:/^[0-9]+$/',
                    'tenure'=>'required|numeric|max:200|regex:/^[0-9]+$/',
                    // 'no_of_kist'=>'required|numeric|lt:tenure|regex:/^[0-9]+$/'
                ]);
                $message= 'Loan Product created successfully';
            }
            if(in_array("all", $request->branches))
            {
                $allBranchIds = Branch::where('status',1)->where('mfi_id',auth()->user()->mfi_id)->pluck('id')->toArray();
                // return $allBranchIds;
                $request->merge(['branches'=>$allBranchIds]);
            }
            // return $request->all();
            // DB::begintransaction();
            // try {
                $isLoanTypeCreated = $this->loanService->createOrUpdateLoan($request->except('_token'),$id);

                if ($isLoanTypeCreated) {
                    DB::commit();
                    $data = ['status' => true, 'message' =>$message, 'data' => ['loan' => $isLoanTypeCreated]];
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
    public function updateEmi(Request $request)
    {
        // return $request->all();
        if ($request->post()) {
            //dd($request->all());
            $id = $request->id;
            if(!empty($id))
            {
                $request->validate([
                    'loan_id' => 'required|string',
                    'number_of_week'=>'required|array',
                    'emi_amount'=>'required|array',
                ]);
                $message="Loan Emi updated successfully";
            }else
            {
                $request->validate([
                    'loan_id' => 'required|string',
                    'number_of_week'=>'required|array',
                    'emi_amount'=>'required|array',
                ]);
                $message= 'Loan Emi created successfully';
            }

            // DB::begintransaction();
            // try {
                $isLoanTypeCreated = $this->loanService->createOrUpdateLoanEmai($request->except('_token'),$id);

                // if ($isLoanTypeCreated) {
                //     DB::commit();
                    $data = ['status' => true, 'message' =>$message, 'data' => ['loan' => $isLoanTypeCreated]];
                    return response($data);

                    /* return $this->responseRedirectBack('Profile updated successfully', 'success', false); */
                // }
            // } catch (\Exception$e) {
            //     DB::rollBack();
            //     logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            //     $data = ['status' => false, 'message' => 'Something went wrong !!', 'data' => []];
            //     return response($data);

            // }

        }
    }
}
