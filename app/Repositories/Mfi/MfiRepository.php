<?php

namespace App\Repositories\Mfi;

use App\Contracts\Mfi\MfiContract;
use App\Models\Mfi;
use App\Models\Role;
use App\Repositories\BaseRepository;
use App\Traits\UploadAble;

/**
 * Class MfiRepository
 *
 * @package \App\Repositories
 */
class MfiRepository extends BaseRepository implements MfiContract
{
    use UploadAble;

    protected $model;
    /**
     * BlogRepository constructor.
     * @param Mfi $model
     */
    public function __construct(Mfi $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function getTotalData($search = null)
    {
        if ($search) {
            return $this->model->where('name', 'LIKE', "%{$search}%")
                ->orWhere('short_code', 'LIKE', "%{$search}%")
                ->count();
        }

        return $this->model->count();
    }
    /**
     * @param $start
     * @param $limit
     * @param $order
     * @param $dir
     * @param null $search
     * @return mixed
     */
    public function getList($start, $limit, $order, $dir, $search = null)
    {
        if ($search) {
            return $this->model->where('name', 'LIKE', "%{$search}%")
                ->orWhere('short_code', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        }

        return $this->model->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
    }
    public function listMfi($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $mfi = $this->model;
        if (!is_null($filterConditions)) {
            $mfi = $mfi->where($filterConditions);
        }
        $mfi = $mfi->orderBy($orderBy, $sortBy);
        if (!is_null($limit)) {
            return $mfi->paginate($limit);
        }
        return $mfi->get();
    }
    public function createMfi($attributes)
    {
        $attributes['created_by'] = auth()->user()->id;
        $attributes['updated_by'] = auth()->user()->id;
        /* $attributes['slug'] = isSluggable($attributes['title']); */
        $isMfiCreated = $this->create($attributes);
        $mfiRoles = Role::where('is_default_role', 1)->whereIn('role_type', ['hq', 'branch'])->get();
        // $isMfiCreated->roles()->attach($mfiRoles);
        foreach($mfiRoles as $key => $role)
        {
            $isMfiCreated->mfiRoles()->create(['role_id'=>$role->id]);
        }
        // $isMfiCreated->mfiRoles()->
        if ($isMfiCreated) {
            if (isset($attributes['mfi_image'])) {
                $fileName = uniqid() . '.' . $attributes['mfi_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['mfi_image'], config('constants.SITE_LOGO_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $isMfiCreated->logo()->create([
                        'logoable_type' => get_class($isMfiCreated),
                        'logoable_id' => $isMfiCreated->id,
                        'logo_type' => 'logo',
                        'file' => $fileName,
                    ]);
                }
            }

        }

        /* if ($isBlogCreated) {
        if (isset($attributes['blog_image'])) {
        $fileName = uniqid() . '.' . $attributes['blog_image']->getClientOriginalExtension();
        $isFileUploaded = $this->uploadOne($attributes['blog_image'], config('constants.SITE_BLOG_IMAGE_UPLOAD_PATH'), $fileName, 'public');
        if ($isFileUploaded) {
        $isFileRelatedMediaCreated = $isBlogCreated->media()->create([
        'user_id' => auth()->user()->id,
        'media_type' => 'image',
        'file' => $fileName,
        'alt_text' => $attributes['alt_text'] ?? null,
        'is_profile_picture' => false,
        ]);
        }
        }
        $isRelatedSeoCreated = $isBlogCreated->seo()->create([
        'body' => $attributes['seo'],
        ]);
        } */
        return $isMfiCreated;
    }

    public function updateMfi($attributes, $id)
    {
        $mfi = $this->find($id);
        $attributes['updated_by'] = auth()->user()->id;
        $mfi = $this->update($attributes, $id);
        if ($mfi) {

        }
        return $mfi;
    }

    public function deleteMfi($id)
    {
        $mfiData = $this->find($id);
        // $mfiData->media()->delete();
        // $mfiData->seo()->delete();
        return $mfiData->delete();
    }
}
