<?php

namespace App\Services\Testimonial;

use App\Contracts\Testimonial\TestimonialContract;

class TestimonialService
{
    /**
     * @var TestimonialContract
     */
    protected $testimonialRepository;

    /**
     * BlogService constructor
     */
    public function __construct(TestimonialContract $testimonialRepository)
    {
        $this->testimonialRepository = $testimonialRepository;
    }
    public function listTestimonials(array $filterConditions, string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->testimonialRepository->listTestimonials($filterConditions, $orderBy, $sortBy, $limit, $inRandomOrder);
    }

    public function findTestimonialById($id)
    {
        return $this->testimonialRepository->find($id);
    }

    public function createOrUpdateTestimonial(array $attributes, $id = null)
    {
        if (is_null($id)) {
            return $this->testimonialRepository->createTestimonial($attributes);
        } else {
            return $this->testimonialRepository->updateTestimonial($attributes, $id);
        }
    }
    public function updateTestimonialStatus($attributes, $id)
    {
        $attributes['status'] = $attributes['value'] == '1' ? 1 : 0;
        return $this->testimonialRepository->update($attributes, $id);
    }

    public function deleteTestimonial(int $id)
    {
        return $this->testimonialRepository->deleteTestimonial($id);
    }
}
