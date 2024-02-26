<?php
namespace App\Repositories\Users;

use Auth;
use App\Traits\UploadAble;
use App\Models\User\Profile;
use Illuminate\Http\UploadedFile;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use App\Contracts\Users\ProfileContract;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class ProfileRepository
 *
 * @package \App\Repositories
 */
class ProfileRepository extends BaseRepository implements ProfileContract
{
    use UploadAble;

    /**
     * ProfileRepository constructor.
     * @param Profile $model
     */
    public function __construct(Profile $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function list(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    public function updateOrCreate($params)
    {
        return $this->model->updateOrCreate(
            ['user_id' => $params['user_id']],
            [
                'gender' => $params['gender'],
                'sexual_orientation' => $params['sexual_orientation'],
                'bio' => $params['bio'],
                'sex' => $params['sex'],
                'category' => $params['category'],
                'others' => $params['others']
            ]
        );
    }

    public function updateOrCreateProfile($params)
    {
        return $this->model->updateOrCreate(
            ['user_id' => $params['user_id']],
            ['bio' => $params['bio']]
        );
    }
}
