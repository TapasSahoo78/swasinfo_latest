<?php

namespace App\Services\Penalty;

use App\Contracts\Penalty\PenaltyContract;

class PenaltyService
{
    /**
     * @var PenaltyContract
     */
    protected $penaltyRepository;

    /**
     * PenaltyService constructor
     */
    public function __construct(PenaltyContract $penaltyRepository)
    {
        $this->penaltyRepository = $penaltyRepository;
    }
    public function listPenalty(array $filterConditions, string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->penaltyRepository->listPenalty($filterConditions, $orderBy, $sortBy, $limit);
    }

    public function findPenaltyById($id)
    {
        return $this->penaltyRepository->find($id);
    }

    public function createOrUpdatePenalty(array $attributes, $id = null)
    {
        $minmumAmount = $attributes['min_amount'];
        foreach ($minmumAmount as $key => $value) {
            if (!empty($attributes['min_amount'][$key]) && !empty($attributes['penalty_amount'][$key]) && !empty($attributes['max_amount'][$key])) {
                $data = ['min_amount' => $attributes['min_amount'][$key],
                    'max_amount' => $attributes['max_amount'][$key],
                    'penalty_amount' => $attributes['penalty_amount'][$key],
                    /* 'case_type' => $attributes['case_type'],
                    'penalty_type' => $attributes['penalty_type'], */
                    'created_by' => auth()->user()->id,
                    'mfi_id' => auth()->user()->mfi_id,
                    'updated_by' => auth()->user()->id,
                ];
                if (!empty($attributes['id']) && !empty($attributes['id'][$key])) {
                    $id = $attributes['id'][$key];
                    /*  if (is_null($id)) { */
                    $this->penaltyRepository->update($data, $id);
                    /* } */

                } else {
                    $this->penaltyRepository->create($data);
                }
            }

        }
        return true;

    }

    public function createOrUpdateTwoCasePenalty(array $attributes, $id = null)
    {
        $minmumAmount = $attributes['minimum_amount'];
        foreach ($minmumAmount as $key => $value) {
            if (!empty($attributes['minimum_amount'][$key]) && !empty($attributes['penaltywise_amount'][$key]) && !empty($attributes['maximum_amount'][$key])) {
                $data = ['minimum_amount' => $attributes['minimum_amount'][$key],
                    'maximum_amount' => $attributes['maximum_amount'][$key],
                    'penaltywise_amount' => $attributes['penaltywise_amount'][$key],
                    /* 'case_type' => $attributes['case_type'],
                    'penalty_type' => $attributes['penalty_type'], */
                    'created_by' => auth()->user()->id,
                    'mfi_id' => auth()->user()->mfi_id,
                    'updated_by' => auth()->user()->id,
                ];
                if (!empty($attributes['p_id']) && !empty($attributes['p_id'][$key])) {
                    $id = $attributes['p_id'][$key];
                    /*  if (is_null($id)) { */
                    $this->penaltyRepository->update($data, $id);
                    /* } */

                } else {
                    $this->penaltyRepository->create($data);
                }
            }

        }
        return true;

    }

    public function createCasePenalty(array $attributes)
    {
        $data = ['min_amount' => $attributes['min_amount'],
            'max_amount' => $attributes['max_amount'],
            'penalty_amount' => $attributes['penalty_amount'],
            'case_type' => $attributes['case_type'],
            'penalty_type' => $attributes['penalty_type'],
            'created_by' => auth()->user()->id,
            'mfi_id' => auth()->user()->mfi_id,
            'updated_by' => auth()->user()->id,
        ];
        return $this->penaltyRepository->create($data);
    }
    public function createTwoCasePenalty(array $attributes)
    {
        $data = ['min_amount' => $attributes['minimum_amount'],
            'max_amount' => $attributes['maximum_amount'],
            'penalty_amount' => $attributes['penaltywise_amount'],
            'case_type' => $attributes['casetwo_type'],
            'penalty_type' => $attributes['penaltywise_type'],
            'created_by' => auth()->user()->id,
            'mfi_id' => auth()->user()->mfi_id,
            'updated_by' => auth()->user()->id,
        ];
        return $this->penaltyRepository->create($data);
    }

    public function createOrUpdateCaseThreePenalty(array $attributes, $id = null)
    {
        if (is_null($id)) {
            return $this->penaltyRepository->createCaseThreePenalty($attributes);
        } else {
            return $this->penaltyRepository->updateCaseThreePenalty($attributes, $id);
        }

    }

    /*  public function updateOccupationStatus($attributes, $id)
{
$attributes['status'] = $attributes['value'] == '1' ? 1 : 0;
return $this->occupationRepository->update($attributes, $id);
}

public function deleteOccupation(int $id)
{
return $this->occupationRepository->deleteOccupation($id);
} */
}
