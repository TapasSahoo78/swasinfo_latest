<?php
namespace App\Repositories\Page;

use App\Models\Seo;
use App\Models\Page;
use App\Traits\UploadAble;
use App\Contracts\Page\PageContract;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
/**
 * Class PageRepository
 *
 * @package \App\Repositories
 */
class PageRepository extends BaseRepository implements PageContract
{
    use UploadAble;


    protected $seoModel;
    /**
     * PageRepository constructor
     *
     * @param Page $model
     */
    /**
     * SeoRepository constructor
     *
     * @param Seo $model
     */
    public function __construct(Page $model,Seo $seoModel)
    {
        parent::__construct($model);
        $this->model = $model;
        $this->seoModel = $seoModel;
    }

    /**
     * List of all pages
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listPages($filterConditions,string $order = 'id', string $sort = 'desc',$limit= null,$inRandomOrder= false){
        $pages= $this->all();
        if(!is_null($limit)){
            return $pages->paginate($limit);
        }
        return $pages;
    }
    public function createFaq($attributes)
    {
        $attributes['created_by'] = auth()->user()->id;
        $attributes['updated_by'] = auth()->user()->id;
        return $this->create($attributes);
    }

    public function updateFaq($attributes, $id)
    {
        $faqData = $this->find($id);
        $attributes['updated_by'] = auth()->user()->id;
        return $faqData->update($attributes);
    }
   
    
   


    /**
     * Find a page with id
     *
     *
     */
    public function findPageById(int $id)
    {
        try
        {
            return $this->findOneBy(['id' => $id]);

        }
        catch (ModelNotFoundException $exception)
        {
            throw new ModelNotFoundException($exception);
        }
    }

    /**
     * Find a page by it's slug
     *
     * @param $slug
     * @return mixed
     */
    public function findPageBySlug($slug)
    {
        return $this->model::where([
                                ['slug','=',$slug],
                                ['status','=',1],
                                ])->first();
    }

    public function findPageByCountry($slug)
    {
        return $this->model::where([
            ['country', $slug],
            ['page_type', 'Location']
            ])
            ->whereNull('city')
            ->whereNull('category')
            ->first();
    }

    public function findPage($params)
    {

        /* $query = $this->model::where([
            ['country', $params['country']],
            ['page_type', 'Location']
            ]); */
        $query = $this->model->where([
            ['status', true]
            ]);

        if($params->has('category') && !is_null($params['category'])){
            $query->where('page_type', 'Categories');
        } else{
            $query->where('page_type', 'Location');
        }

        if ($params->has('country') && !is_null($params['country'])) {
            $query->where('country', $params['country']);

            if(is_null($params['city']) && is_null($params['category'])){
                $query->where('city', null)->where('category', null);
            }
        }
        if ($params->has('city') && !is_null($params['city'])) {

            $query->Where(function ($query) use ($params){
                $query->where('city', $params['city']);
            });

            if(is_null($params['category'])){
                $query->where('category', null);
            }
        }
        if ($params->has('category') && !is_null($params['category'])) {
            $query->Where(function ($query) use ($params){
                $query->where('category', $params['category']);
            });
        }
        return $query->first();
    }

    /**
     * Create a page
     *
     * @param array $params
     * @return Page|mixed
     */
    public function createPage(array $params)
    {
        $collection = collect($params);
            $page = $this->model;
            $page->title = $collection['title'];
            $page->slug = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($collection['title'])));
           // $page->page_type = $collection['page_type'];
            $page->description = $collection['description'];
            $page->status = 1;
            /* $page->created_by = auth()->user()->id;
            $page->updated_by = auth()->user()->id; */
            $page->save();

           /*  if($page){
                $isRelatedSeoCreated= $page->seo()->create([
                'body' => $collection['seo'],
                'seoable_id' => $page->id,
                'seoable_type' => get_class($page)
            ]);
        } */
            return $page;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updatePage($attributes,$id)
    {
        $pageData= $this->find($id);
        $isPageUpdated= $this->update([
            /* 'name' => $attributes['name'], */
            'title' => $attributes['title'],
            'description' => $attributes['description'],
            'slug' => preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($attributes['title'])))
        ],$id);
        return $isPageUpdated;
    }

    /**
     * Delete a page
     *
     * @param $id
     * @return bool|mixed
     */
    public function deletePage($id)
    {
        $page = $this->findPageById($id);
        ## Delete page seo
        if($page){
            $page->delete();
        }
        return $page ?? false;
    }

    /**
     * Update a page's status
     *
     * @param array $params
     * @return mixed
     */
    public function updatePageStatus(array $params)
    {
        $page = $this->findPageById($params['id']);
        $collection = collect($params)->except('_token');
        $page->status = $collection['check_status'];
        $page->update();
        return $page;
    }

    /**
     * Get count of total pages
     *
     * @param null $search
     * @return mixed
     */
    public function getTotalData($page_type = null, $search=null)
    {
        $query = $this->model;
        if($page_type){
            $query = $query->where('page_type', $page_type);
        }

        if($search) {
            $query = $query->where('title','LIKE',"%{$search}%")->orWhere('slug', 'LIKE',"%{$search}%");
        }

        return $query->count();
    }

    /**
     * Get list of pages for datatable
     *
     * @param $start
     * @param $limit
     * @param $order
     * @param $dir
     * @param null $search
     * @return mixed
     */
    public function getList($type, $start, $limit, $order, $dir, $search = null)
    {
        $query = $this->model->where('page_type', $type);

        if($search) {
            $query = $query->where('title','LIKE',"%{$search}%")->orWhere('slug', 'LIKE',"%{$search}%");
        }

        return $query->offset($start)->limit($limit)->orderBy($order, $dir)->get();
    }
}
