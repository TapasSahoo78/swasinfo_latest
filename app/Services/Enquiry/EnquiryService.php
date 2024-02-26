<?php

namespace App\Services\Enquiry;

use App\Contracts\Enquiry\EnquiryContract;

class EnquiryService
{
    /**
     * @var EnquiryContract
     */
    protected $enquiryRepository;

    /**
     * EnquiryService constructor
     */
    public function __construct(EnquiryContract $enquiryRepository)
    {
        $this->enquiryRepository = $enquiryRepository;
    }
    public function listEnquiry(array $filterConditions, string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->enquiryRepository->listEnquiry($filterConditions, $orderBy, $sortBy, $limit);
    }

    public function findEnquiryById($id)
    {
        return $this->enquiryRepository->find($id);
    }

    public function createOrUpdateEnquiry(array $attributes, $id = null)
    {
        //return $attributes;
        if (is_null($id)) {
            return $this->enquiryRepository->createEnquiry($attributes);
        } else {
            return $this->enquiryRepository->updateEnquiry($attributes, $id);
        }
    }
    public function enquiryStatusChange(array $attributes, int $id)
    {
            return $this->enquiryRepository->enquiryStatusChange($attributes, $id);
    }

    public function updateEnquiryStatus($attributes, $id)
    {
        $attributes['status'] = $attributes['value'] == '1' ? 1 : 0;
        return $this->enquiryRepository->update($attributes, $id);
    }

    public function deleteEnquiry(int $id)
    {
        return $this->enquiryRepository->deleteEnquiry($id);
    }

    public function leadWiseEnquiry(int $id)
    {
        return $this->enquiryRepository->leadWiseEnquiry($id);
    }
}
