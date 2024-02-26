<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use App\Services\Blog\BlogService;
use App\Services\Faq\FaqService;
use App\Services\Page\PageService;
use Illuminate\Http\Request;

class PagesController extends BaseController
{

    protected $pageService;
    protected $faqService;
    protected $blogService;

    public function __construct(PageService $pageService, FaqService $faqService, BlogService $blogService)
    {

        $this->pageService = $pageService;

        $this->faqService = $faqService;

        $this->blogService = $blogService;

    }

    public function anyPages(Request $request, $slug)
    {

        if ($slug == "faqs") {

            $this->setPageTitle('Faqs', '');

            $filterConditions = [];

            $listFaqs = $this->faqService->listFaqs($filterConditions, 'id', 'asc', 15);

            return view('frontend.faqs', compact('listFaqs'));

        }

        if ($slug == "blogs") {

            $this->setPageTitle('Blogs', '');

            $filterConditions = [];
            $filterByPopularConditions = [
                'is_featured'=>1
            ];
            $listBlogs = $this->blogService->listBlogs($filterConditions, 'id', 'asc', 15);
            $listPopularBlogs = $this->blogService->listBlogs($filterByPopularConditions, 'id', 'asc', 15);

            return view('frontend.blog.blog', compact('listBlogs','listPopularBlogs'));

        }

        $pageContent = $this->pageService->fetchPageBySlug($slug);

        if (empty($pageContent) || $pageContent->status == false) {
            return $this->showErrorPage();
        }

        if ($pageContent->slug == 'home') {
            return redirect()->route('frontend.home');
        }

        $this->setMetaDetails($pageContent->seo?->body);

        $this->setPageTitle($pageContent->title, '');

        return view('frontend.pages.any-pages', compact('pageContent'));

    }

}
