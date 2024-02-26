<?php

namespace App\Repositories\Testimonial;

use App\Contracts\Testimonial\TestimonialContract;
use App\Models\Review;
use App\Repositories\BaseRepository;
use App\Traits\UploadAble;

/**
 * Class TestimonialRepository
 *
 * @package \App\Repositories
 */
class TestimonialRepository extends BaseRepository implements TestimonialContract
{
    use UploadAble;

    protected $model;
    /**
     * BlogRepository constructor.
     * @param Review $model
     */
    public function __construct(Review $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
    public function listTestimonials($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $testimonials = $this->model;
        if (!is_null($filterConditions)) {
            $testimonials = $testimonials->where($filterConditions);
        }
        $testimonials = $testimonials->orderBy($orderBy, $sortBy);
        if (!is_null($limit)) {
            return $testimonials->paginate($limit);
        }
        return $testimonials->get();
    }
    public function createTestimonial($attributes)
    {
        $user_id = uuidtoid($attributes['user_id'], 'users');
        return $this->create([
            'user_id' => $user_id,
            'description' => $attributes['description'],
            'overall_rating' => $attributes['overall_rating'],
            'reviewable_type' => 'App\Models\User',
            'reviewable_id' => $user_id,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);
    }

    public function updateTestimonial($attributes, $id)
    {
        $testimonialData = $this->find($id);
        $user_id = uuidtoid($attributes['user_id'], 'users');
        return $testimonialData->update([
            'user_id' => $user_id,
            'description' => $attributes['description'],
            'overall_rating' => $attributes['overall_rating'],
            'updated_by' => auth()->user()->id,
        ]);
    }

    public function deleteTestimonial($id)
    {
        return $this->delete($id);
    }
}
