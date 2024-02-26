<?php

namespace App\Http\Controllers\Mfi;

use App\Http\Controllers\BaseController;
use App\Services\Enquiry\EnquiryService;
use App\Services\Lead\LeadService;
use App\Services\Loan\LoanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnquiryController extends BaseController
{
    protected $enquiryService;
    protected $leadService;
    protected $loanService;
    public function __construct(EnquiryService $enquiryService, LeadService $leadService,LoanService $loanService)
    {
        $this->enquiryService = $enquiryService;
        $this->leadService = $leadService;
        $this->loanService = $loanService;

    }
    public function listEnquiry()
    {
        $this->setPageTitle('All Enquiries');
        $filterConditions = [
            'mfi_id' => auth()->user()->mfi_id,
        ];
        $filterLeadConditions = [
            'mfi_id' => auth()->user()->mfi_id,
            'status' => 1,
        ];
        $filterLoanConditions = [
            'mfi_id' => auth()->user()->mfi_id,
            'status' => 1
        ];
        $listEnquiries = $this->enquiryService->listEnquiry($filterConditions, 'id', 'asc', 15);
        $listLeads = $this->leadService->listLeads($filterLeadConditions, 'id', 'asc', 15);
        $listLoans = $this->loanService->listLoan($filterLoanConditions, 'id', 'asc', 15);
        //dd($listBranch->toArray());
        return view('mfi.enquiry.list', compact('listEnquiries', 'listLeads','listLoans'));
    }


    public function store(Request $request)
    {
        //return $request->all();
        if ($request->post()) {
            //dd($request->all());
            $id = $request->id;
            if (!empty($id)) {
                $request->validate([
                    /* 'lead_id' => 'required|exists:leads,uuid', */
                    'loan_id' => 'required|exists:loans,uuid',
                    'min_amount' => 'required|numeric|min:30|regex:/^[0-9]+$/',
                    'max_amount' => 'required|numeric|gt:min_amount|regex:/^[0-9]+$/',
                    'message'=>'required|string'
                    /* 'min_amount' => 'required|numeric|min:30|regex:/^[0-9]+$/',
                'max_amount' => 'required|numeric|gt:min_amount|regex:/^[0-9]+$/', */
                ]);
                $message = "Enquiry Updated Successfully";
            } else {
                $request->validate([
                   /*  'lead_id' => 'required|exists:leads,uuid', */
                    'loan_id' => 'required|exists:loans,uuid',
                    'min_amount' => 'required|numeric|min:30|regex:/^[0-9]+$/',
                    'max_amount' => 'required|numeric|max:1000000|gt:min_amount|regex:/^[0-9]+$/',
                    'message'=>'required|string'
                ]);
                $message = "Enquiry Created Successfully";
            }


            /* $request->validate([
            'account_type' => 'required',
            'account_name' => 'required|string',
            'account_number' => 'required_if:account_type,1|numeric|unique:accounts,account_number',
            'ifsc_code' => 'required_if:account_type,1|regex:/^[\w-]*$/|unique:accounts,ifsc_code',
            'account_holder_name' => 'required_if:account_type,1|string',
            'upi_id' => 'required_if:account_type,3|nullable|numeric|unique:accounts,upi_id',
            'opening_balance' => 'required|numeric|regex:/^[0-9]+$/',
            ]); */
            /* DB::begintransaction();
            try { */
                $isEnquiryCreated = $this->enquiryService->createOrUpdateEnquiry($request->except('_token'), $id);
                //dd($request->all());
                if ($isEnquiryCreated) {
                    DB::commit();
                    $data = ['status' => true, 'message' => $message, 'data' => ['enquiry' => $isEnquiryCreated]];
                    return response($data);

                    /* return $this->responseRedirectBack('Profile updated successfully', 'success', false); */
                }
            /* } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                $data = ['status' => false, 'message' => 'Something went wrong !!', 'data' => []];
                return response($data);

            } */

        }
    }
    public function updateStatus(Request $request)
    {
        //return $request->all();
        if ($request->post()) {
            //dd($request->all());
            $id = $request->enquiry_id;

                $request->validate([
                    'status' => 'required',
                    'notes'=>'required|string'
                    /* 'min_amount' => 'required|numeric|min:30|regex:/^[0-9]+$/',
                'max_amount' => 'required|numeric|gt:min_amount|regex:/^[0-9]+$/', */
                ]);
                $message = "Status Updated Successfully";

            DB::begintransaction();
            try {
                $isEnquiryCreated = $this->enquiryService->enquiryStatusChange($request->except('_token'), $id);

                if ($isEnquiryCreated) {
                    DB::commit();
                    $data = ['status' => true, 'message' => $message, 'data' => ['enquiry' => $isEnquiryCreated]];
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
