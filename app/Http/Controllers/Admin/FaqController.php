<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Services\Faq\FaqService;
use App\Services\Page\PageService;
use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\Page;
use Illuminate\Support\Facades\DB;

class FaqController extends BaseController
{

    protected $faqService;
    protected $PageService;


    public function __construct(FaqService $faqService,PageService $PageService)
    {
        $this->faqService = $faqService;
        $this->PageService = $PageService;
    }

    public function index()
    {
        $this->setPageTitle('All Faqs');
        $filterConditions = [];
        $listFaqs = $this->faqService->listFaqs($filterConditions, 'id', 'asc', 15);
        return view('admin.faq.index' , compact('listFaqs'));
    }

    public function addFaq(Request $request)
    {
        $this->setPageTitle('Add Faq');
        $faq = Faq::where('id','1')->first();
        $faqId = "1";
        $faqData = $this->faqService->findFaqById($faqId);
        if ($request->post()) {
            $request->validate([
                "answer"        => 'required'
            ]);
            DB::beginTransaction();
            try {
                $isFaqUpdated = $this->faqService->createOrUpdateFaq($request->except('_token'), $faqId);
                if ($isFaqUpdated) {
                    DB::commit();
                    return $this->responseRedirect('admin.faq.add', 'Faq Update successfully', 'success', false);
                }
            } catch (\Exception$e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.faq.add',compact('faq'));
    }

    public function addprivacy(Request $request)
    {
        $this->setPageTitle('Add privacy');
        $privacy = Page::where('id','1')->first();
        $faqId = "1";
        $faqData = $this->faqService->findFaqById($faqId);
        if ($request->post()) {
            $request->validate([
                "answer"        => 'required'
            ]);
            DB::beginTransaction();
            try {
                $privacy = Page::where('id','1')->first();
                $privacy->description = $request->answer;
                $privacy->save();
                
                    DB::commit();
                    return $this->responseRedirect('admin.faq.addprivacy', 'Faq created successfully', 'success', false);
                
            } catch (\Exception$e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.faq.addprivacy',compact('privacy'));
    }


    public function addterm(Request $request)
    {
        $this->setPageTitle('Add Faq');
        $privacy = Page::where('id','3')->first();
        $faqId = "4";
        $faqData = $this->faqService->findFaqById($faqId);
        if ($request->post()) {
            $request->validate([
              
                "answer"        => 'required'
            ]);
            DB::beginTransaction();
            try {
                $privacy = Page::where('id','3')->first();
                $privacy->description = $request->answer;
                $privacy->save();
                
                    DB::commit();
                    return $this->responseRedirect('admin.faq.addterm', 'Faq created successfully', 'success', false);
                
            } catch (\Exception$e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.faq.addterm',compact('privacy'));
    }

    public function addcontact(Request $request)
    {
      
        $this->setPageTitle('Add Faq');
        $privacy = Page::where('id','2')->first();
        $faqId = "5";
        $faqData = $this->faqService->findFaqById($faqId);
        if ($request->post()) {
            
            $request->validate([
                "answer"        => 'required'
            ]);
            DB::beginTransaction();
            try {
                $privacy = Page::where('id','2')->first();
              
                $privacy->description = $request->answer;
                $privacy->save();
                DB::commit();
                return $this->responseRedirect('admin.faq.addcontact', 'Faq created successfully', 'success', false);
                
            } catch (\Exception$e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.faq.addcontact',compact('privacy'));
    }

    public function editFaq(Request $request, $uuid)
    {
        $this->setPageTitle('Edit Faq');
        $faqId = uuidtoid($uuid, 'faqs');
        $faqData = $this->faqService->findFaqById($faqId);
        if ($request->post()) {
            $request->validate([
                'question' => 'required|string|unique:faqs,question,' . $faqId,
                "answer"   => 'required',
            ]);
            DB::beginTransaction();
            try {
                $isFaqUpdated = $this->faqService->createOrUpdateFaq($request->except('_token'), $faqId);
                if ($isFaqUpdated) {
                    DB::commit();
                    return $this->responseRedirect('admin.faq.list', 'Faq updated successfully', 'success', false);
                }
            } catch (\Exception$e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }

        }
        return view('admin.faq.edit', compact('faqData'));
    }


    public function addHelpSupport(Request $request)
    {
       
        $this->setPageTitle('Add Faq');
        $privacy = Page::where('id','4')->first();
        if ($request->post()) {
            $request->validate([
                "answer"        => 'required'
            ]);
            DB::beginTransaction();
            try {
                $help = Page::find(4);
                $help->description = $request->answer;
                $help->save();
                DB::commit();
                return $this->responseRedirect('admin.faq.addhelp', 'Help And Support created successfully', 'success', false);
                
            } catch (\Exception$e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.faq.addhelp',compact('privacy'));
    }

}
