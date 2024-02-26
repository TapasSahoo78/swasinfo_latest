<?php

namespace App\Repositories\Faq;

use App\Contracts\Faq\FaqContract;
use App\Models\Faq;
use App\Models\Reward;
use App\Repositories\BaseRepository;
use App\Traits\UploadAble;

/**
 * Class BlogRepository
 *
 * @package \App\Repositories
 */
class FaqRepository extends BaseRepository implements FaqContract
{
    use UploadAble;

    protected $model;
    protected $rewardModel;
    /**
     * BlogRepository constructor.
     * @param Faq $model
     *  @param Reward $rewardModel
     */
    public function __construct(Faq $model, Reward $rewardModel)
    {
        parent::__construct($model);
        $this->model = $model;
        $this->rewardModel = $rewardModel;
    }
    public function listFaqs($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $faqs = $this->model;
        if (!is_null($filterConditions)) {
            $faqs = $faqs->where($filterConditions);
        }
        $faqs = $faqs->orderBy($orderBy, $sortBy);
        if (!is_null($limit)) {
            return $faqs->paginate($limit);
        }
        return $faqs->get();
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
    public function updateRewardStatus($attributes, $id)
    {
        return $this->rewardModel->find($id)->update($attributes);
    }
    public function findAttributeById($id)
    {
        return $this->attributeModel->find($id);
    }
    public function findRewardById($id)
    {
        return $this->rewardModel->find($id);
    }
    public function deleteReward($id)
    {
        $reward = $this->findRewardById($id);
        ## Delete page seo
        if ($reward) {
            /* $attribute->is_active = 3;
            $reward->update(); */
            $reward->delete();
        }
        return $reward ?? false;
    }
}
