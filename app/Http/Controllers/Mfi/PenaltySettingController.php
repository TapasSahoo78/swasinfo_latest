<?php

namespace App\Http\Controllers\Mfi;

use App\Http\Controllers\BaseController;
use App\Services\Penalty\PenaltyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenaltySettingController extends BaseController
{
    protected $penaltySettingService;
    public function __construct(PenaltyService $penaltySettingService)
    {
        $this->penaltySettingService = $penaltySettingService;

    }
    public function listCaseOnePenaltySetting(Request $request)
    {

        if ($request->post()) {
            $request->validate([
                'min_amount.*' => 'required|numeric|min:30|regex:/^[0-9]+$/',
                'max_amount.*' => 'required|numeric|gt:min_amount.*|regex:/^[0-9]+$/',
                'penalty_amount.*' => 'required|numeric|regex:/^[0-9]+$/',
            ], [
                'max_amount.*.gt' => 'The Max Amount must be greater than :value',
            ]);

            //dd($request->all());
            //$id = $request->id;
            /*  if (!empty($id)) {

            $message = "Penalty Updated Successfully";

            } else {

            $message = "Penalty Created Successfully";
            } */

            /* $request->validate([
            'min_amount.*' => 'required|array|numeric|min:30|regex:/^[0-9]+$/',
            'max_amount.*' => 'required|array|numeric|gt:min_amount|regex:/^[0-9]+$/',
            'penalty_amount.*' => 'required|array|numeric|regex:/^[0-9]+$/',
            ]); */
            // DB::begintransaction();
            // try {
            DB::begintransaction();
            try {
                $isUserUpdated = $this->penaltySettingService->createOrUpdatePenalty($request->except('_token'));

                if ($isUserUpdated) {
                    /*  $userBranchData = ['user_id' => auth()->user()->id, 'branch_id' => $isBranchCreated->id];
                    UserBranch::create($userBranchData); */
                    DB::commit();
                    $data = ['status' => true, 'message' => 'Penalty Updated Succesfully', 'data' => ['branch' => $isUserUpdated]];
                    return response($data);

                    /* return $this->responseRedirectBack('Profile updated successfully', 'success', false); */
                }
            } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                $data = ['status' => false, 'message' => 'Something went wrong !!', 'data' => []];
                return response($data);

            }

            /* $isUserUpdated = $this->penaltySettingService->createOrUpdatePenalty($request->except('_token'));
            if ($isUserUpdated) {
            DB::commit();
            return $this->responseRedirectBack('Penalty  Updated Successfully', 'success', false);
            } */
            // } catch (\Exception$e) {
            //     DB::rollBack();
            //     logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            //     return $this->responseRedirectBack('Something Went Wrong', 'error', true);
            // }

        }
        $this->setPageTitle('Penalty Settings');

        $filterCaseOneConditions = [
            'mfi_id' => auth()->user()->mfi_id,
            'case_type' => 1,
        ];
        $filterCaseTwoConditions = [
            'mfi_id' => auth()->user()->mfi_id,
            'case_type' => 2,
        ];
        $filterCaseThreeConditions = [
            'mfi_id' => auth()->user()->mfi_id,
            'case_type' => 3,
        ];

        $listPenaltyCaseOne = $this->penaltySettingService->listPenalty($filterCaseOneConditions, 'id', 'asc', 15);
        $listPenaltyCaseTwo = $this->penaltySettingService->listPenalty($filterCaseTwoConditions, 'id', 'asc', 15);
        $listPenaltyCaseThree = $this->penaltySettingService->listPenalty($filterCaseThreeConditions, 'id', 'asc', 15);

        return view('mfi.penalty-setting.list', compact('listPenaltyCaseOne', 'listPenaltyCaseTwo', 'listPenaltyCaseThree'));
    }

    public function listCaseTwoPenaltySetting(Request $request)
    {
        if ($request->post()) {
            $request->validate([
                'minimum_amount.*' => 'required|numeric|min:30|regex:/^[0-9]+$/',
                'maximum_amount.*' => 'required|numeric|gt:minimum_amount.*|regex:/^[0-9]+$/',
                'penaltywise_amount.*' => 'required|numeric|regex:/^[0-9]+$/',
            ], [
                'maximum_amount.*.gt' => 'The Max Amount must be greater than :value',
            ]);
            // DB::begintransaction();
            // try {
            DB::begintransaction();
            try {
                $isUserUpdated = $this->penaltySettingService->createOrUpdateTwoCasePenalty($request->except('_token'));

                if ($isUserUpdated) {
                    /*  $userBranchData = ['user_id' => auth()->user()->id, 'branch_id' => $isBranchCreated->id];
                    UserBranch::create($userBranchData); */
                    DB::commit();
                    $data = ['status' => true, 'message' => 'Penalty Updated Succesfully', 'data' => ['branch' => $isUserUpdated]];
                    return response($data);

                    /* return $this->responseRedirectBack('Profile updated successfully', 'success', false); */
                }
            } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                $data = ['status' => false, 'message' => 'Something went wrong !!', 'data' => []];
                return response($data);

            }

            /* $isUserUpdated = $this->penaltySettingService->createOrUpdatePenalty($request->except('_token'));
            if ($isUserUpdated) {
            DB::commit();
            return $this->responseRedirectBack('Penalty  Updated Successfully', 'success', false);
            } */
            // } catch (\Exception$e) {
            //     DB::rollBack();
            //     logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            //     return $this->responseRedirectBack('Something Went Wrong', 'error', true);
            // }

        }
    }

    public function listCaseThreePenaltySetting(Request $request)
    {

        if ($request->post()) {
            $id = $request->penalty_id;
            if (!empty($id)) {
                $request->validate([
                    'amount' => 'required|numeric|regex:/^[0-9]+$/',
                ]);

            } else {
                $request->validate([
                    'amount' => 'required|numeric|regex:/^[0-9]+$/',
                ]);

            }

            DB::begintransaction();
            try {
                $isUserUpdated = $this->penaltySettingService->createOrUpdateCaseThreePenalty($request->except('_token'), $id);
                // dd($isUserUpdated);
                if ($isUserUpdated) {
                    DB::commit();
                    /* return $this->responseRedirect('mfi.administrator.penalty-setting.list', ['slug' => $code], 'User updated successfully', 'success', false); */
                    DB::commit();
                    $data = ['status' => true, 'message' => 'Penalty Updated Succesfully', 'data' => ['branch' => $isUserUpdated]];
                    return response($data);

                    /* return $this->responseRedirectBack('Penalty Added Or Updated Successfully', 'success', false); */

                }
            } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                $data = ['status' => false, 'message' => 'Something went wrong !!', 'data' => []];
                return response($data);

            }

        }
    }

    public function listCasePenaltySettingSave(Request $request)
    {

        if ($request->post()) {
            $id = $request->penalty_id;

            $request->validate([
                'min_amount' => 'required|numeric|min:30|regex:/^[0-9]+$/',
                'max_amount' => 'required|numeric|gt:min_amount|regex:/^[0-9]+$/',
                'penalty_amount' => 'required|numeric|regex:/^[0-9]+$/',
            ], [
                'max_amount.gt' => 'The Max Amount must be greater than :value',
            ]);

            DB::begintransaction();
            try {
                $isUserUpdated = $this->penaltySettingService->createCasePenalty($request->except('_token'));
                // dd($isUserUpdated);
                if ($isUserUpdated) {
                    DB::commit();
                    $data = ['status' => true, 'message' => 'Penalty Added Succesfully', 'data' => ['branch' => $isUserUpdated]];
                    return response($data);

                    /* return $this->responseRedirect('mfi.administrator.penalty-setting.list', ['slug' => $code], 'User updated successfully', 'success', false); */
                    //return $this->responseRedirectBack('Penalty Added  Successfully', 'success', false);

                }
            } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                $data = ['status' => false, 'message' => 'Something went wrong !!', 'data' => []];
                return response($data);

            }

        }
    }
    public function listCasePenaltySettingCase2Save(Request $request)
    {

        if ($request->post()) {
            $id = $request->p_id;

            $request->validate([
                'minimum_amount' => 'required|numeric|min:30|regex:/^[0-9]+$/',
                'maximum_amount' => 'required|numeric|gt:minimum_amount|regex:/^[0-9]+$/',
                'penaltywise_amount' => 'required|numeric|regex:/^[0-9]+$/',
            ], [
                'maximum_amount.gt' => 'The Max Amount must be greater than :value',
            ]);

            DB::begintransaction();
            try {
                $isUserUpdated = $this->penaltySettingService->createTwoCasePenalty($request->except('_token'));
                // dd($isUserUpdated);
                if ($isUserUpdated) {
                    DB::commit();
                    $data = ['status' => true, 'message' => 'Penalty Added Succesfully', 'data' => ['branch' => $isUserUpdated]];
                    return response($data);

                    /* return $this->responseRedirect('mfi.administrator.penalty-setting.list', ['slug' => $code], 'User updated successfully', 'success', false); */
                    //return $this->responseRedirectBack('Penalty Added  Successfully', 'success', false);

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
