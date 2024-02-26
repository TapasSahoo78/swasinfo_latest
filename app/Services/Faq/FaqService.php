<?php

namespace App\Services\Faq;

use App\Contracts\Faq\FaqContract;

class FaqService
{
    /**
     * @var FaqContract
     */
    protected $faqRepository;

    /**
     * BlogService constructor
     */
    public function __construct(FaqContract $faqRepository)
    {
        $this->faqRepository = $faqRepository;
    }
    public function listFaqs(array $filterConditions, string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->faqRepository->listFaqs($filterConditions, $orderBy, $sortBy, $limit, $inRandomOrder);
    }

    public function findFaqById($id)
    {
        return $this->faqRepository->find($id);
    }

    public function createOrUpdateFaq(array $attributes, $id = null)
    {
        if (is_null($id)) {
            return $this->faqRepository->createFaq($attributes);
        } else {
            return $this->faqRepository->updateFaq($attributes, $id);
        }
    }
    public function updateFaqStatus($attributes, $id)
    {
        $attributes['is_active'] = $attributes['value'] == '1' ? 1 : 0;
        return $this->faqRepository->update($attributes, $id);
    }

    public function updateRewardStatus(array $attributes, $id)
    {
        $data['is_active'] = $attributes['value'] == '1' ? 1 : 0;
        return $this->faqRepository->updateRewardStatus($data, $id);
    }

    public function deleteFaq(int $id)
    {
        return $this->faqRepository->delete($id);
    }
    public function deleteReward(int $id)
    {
        return $this->faqRepository->deleteReward($id);
    }
    public function deleteAttribute(int $id)
    {
        return $this->categoryRepository->deleteAttribute($id);
    }
}
