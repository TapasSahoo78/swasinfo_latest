<?php

namespace App\Http\Controllers\Admin;

use App\Models\Reward;
use Illuminate\Http\Request;
use App\Services\Faq\FaqService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use App\Traits\UploadAble;

class RewardController extends BaseController
{

    protected $faqService;
    protected $userService;
    use UploadAble;

    public function __construct(FaqService $faqService)
    {
        $this->faqService = $faqService;
    }

    public function index()
    {
        $this->setPageTitle('All Rewards');
        //$filterConditions = [];
        $listRewards = Reward::all();
        return view('admin.reward.index' , compact('listRewards'));
    }

    public function addReward(Request $request)
    {
        $this->setPageTitle('Add Reward');
        if ($request->post()) {
            $request->validate([
                'title'      => 'required|string|unique:rewards,title',
                "description"        => 'required'
            ]);
            DB::beginTransaction();
            $fileName = uniqid() . '.' . $request['file']->getClientOriginalExtension();
             $isFileUploaded = $this->uploadOne($request['file'], config('constants.SITE_REWARD_IMAGE_UPLOAD_PATH'), $fileName, 'public');
            try {
                $isRewardCreated = Reward::create([
                    'title'=>$request->title,
                    'description'=>$request->description,
                    'images'=>  $fileName
                ]);
                if ($isRewardCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.reward.list', 'Reward created successfully', 'success', false);
                }
            } catch (\Exception$e) {
                DB::rollback();
                echo $e->getMessage();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.reward.add');
    }

    public function editReward(Request $request, $uuid)
    {
        $this->setPageTitle('Edit Faq');
        $rewardId = uuidtoid($uuid, 'rewards');
        $rewardData = Reward::find($rewardId);
        if ($request->post()) {
            $request->validate([
                'title' => 'required|string|unique:rewards,title,' . $rewardId,
                "description"   => 'required',
            ]);
            DB::beginTransaction();
            try {
                $isRewardUpdated = Reward::where('id', $rewardId)->update([
                    'title' => $request->title,
                    'description' => $request->description
                ]);
                if ($isRewardUpdated) {
                    DB::commit();
                    return $this->responseRedirect('admin.reward.list', 'Reward updated successfully', 'success', false);
                }
            } catch (\Exception$e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }

        }
        return view('admin.reward.edit', compact('rewardData'));
    }

}
