<?php

namespace App\Http\Controllers\Mfi;

use App\Http\Controllers\BaseController;
use App\Services\Occupation\OccupationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OccupationController extends BaseController
{
    protected $occupationService;
    public function __construct(OccupationService $occupationService)
    {
        $this->occupationService = $occupationService;

    }
    public function listOccupation(Request $request)
    {
        $this->setPageTitle('All Occupations');
        $filterConditions = [
            'mfi_id' => auth()->user()->mfi_id,
        ];
        if($request->has('occupation_name')){
            $filterConditions['occupation_name']= $request->occupation_name ;
        }

        $listOccupation = $this->occupationService->listOccupation($filterConditions, 'id', 'asc', 15);
        //dd($listBranch->toArray());
        return view('mfi.occupation.list', compact('listOccupation'));
    }

    public function store(Request $request)
    {
        //return $request->all();
        if ($request->post()) {
            $id = $request->id;
            if (!empty($id)) {
                $request->validate([
                    'name' => 'required|string|unique:occupations,name,' . $id,
                    'note' => 'required|string'
                    /* 'min_amount' => 'required|numeric|min:30|regex:/^[0-9]+$/',
                    'max_amount' => 'required|numeric|gt:min_amount|regex:/^[0-9]+$/', */
                ]);
                $message = "Occupation Updated Successfully";
            } else {
                $request->validate([
                    'name' => 'required|string|unique:occupations,name',
                    'note' => 'required|string'
                ]);
                $message = "Occupation Created Successfully";
            }

            //dd($request->all());
            /* $request->validate([
            'name' => 'required|string|unique:occupations,name',
            'note' => 'required|string'
            ]); */
            DB::begintransaction();
            try {
                $isOccupationCreated = $this->occupationService->createOrUpdateOccupation($request->except('_token'),$id);

                if ($isOccupationCreated) {
                    DB::commit();
                    $data = ['status' => true, 'message' => $message, 'data' => ['occupation' => $isOccupationCreated]];
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
