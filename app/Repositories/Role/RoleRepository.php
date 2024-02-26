<?php
namespace App\Repositories\Role;

use App\Contracts\Role\RoleContract;
use App\Models\Permission;
use App\Models\Role;
use App\Models\MfiRole;
use App\Repositories\BaseRepository;

class RoleRepository extends BaseRepository implements RoleContract
{

    protected $model;
    protected $permissionModel;
    protected $mfiRoleModel;
    public function __construct(Role $model, Permission $permissionModel,MfiRole $mfiRoleModel)
    {
        parent::__construct($model);
        $this->permissionModel = $permissionModel;
        $this->mfiRoleModel = $mfiRoleModel;
    }

    public function getTotalData($search = null)
    {
        if ($search) {
            return $this->model->where('mfi_id', '=', auth()->user()->mfi_id)->where('name', 'LIKE', "%{$search}%")
                ->orWhere('slug', 'LIKE', "%{$search}%")
            /*   ->orWhere('short_code', 'LIKE', "%{$search}%")
            ->orWhere('role_type', 'LIKE', "%{$search}%") */
                ->count();
        }

        return $this->model->where('mfi_id', '=', auth()->user()->mfi_id)->count();
    }

    public function roleList($filterConditions)
    {
        $role = $this->model;
        if (!is_null($filterConditions)) {
            foreach($filterConditions as $key => $condition)
            {
                if($key=='status')
                {
                    $role = $role->listMfiRoles($condition);
                }else
                {
                    $role = $role->where($filterConditions[$key]);
                }
            }
        }else
        {
            $role->listMfiRoles();
        }
        return $role->get();
    }

    public function getTotalPermissionData($search = null)
    {
        if ($search) {
            return $this->permissionModel->where('name', 'LIKE', "%{$search}%")
                ->orWhere('slug', 'LIKE', "%{$search}%")
                ->count();
        }

        return $this->permissionModel->count();
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
        // return auth()->user()->mfi_id;
        if ($search) {
            return $this->model->where('mfi_id', auth()->user()->mfi_id)->
                orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('slug', 'LIKE', "%{$search}%")
            /*  ->orWhere('short_code', 'LIKE', "%{$search}%")
            ->orWhere('role_type', 'LIKE', "%{$search}%") */
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        }

        return $this->model->offset($start)->where('mfi_id', auth()->user()->mfi_id)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
    }
    /**
     * @param $start
     * @param $limit
     * @param $order
     * @param $dir
     * @param null $search
     * @return mixed
     */
    public function getPermissionList($start, $limit, $order, $dir, $search = null)
    {
        if ($search) {
            return $this->permissionModel->where('name', 'LIKE', "%{$search}%")
                ->orWhere('slug', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        }

        return $this->permissionModel->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
    }

    public function findById($id)
    {
        return $this->find($id);
    }

    public function getAllPermissions()
    {
        return $this->permissionModel->NotDashboard()->get();
    }
    public function getSpecifiedPermissions()
    {
        return $this->permissionModel->NotMfi()->get();
    }

    public function createRole($attributes)
    {

        $isRoleCreated = $this->model->create([
            'name' => $attributes['name'],
            'slug' => isSluggable($attributes['name']),
            'description' => $attributes['description'],
            'is_default_role' => 0,
            'role_type' => 'hq',
            /* 'mfi_id' => auth()->user() ? auth()->user()->mfi_id : null, */
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);
        if($isRoleCreated){
            //$isRoleCreated->mfi()->attach($isRoleCreated);
            $mfiRoleData = (['mfi_id' => auth()->user()->mfi_id]);
            $isRoleCreated->mfi()->create($mfiRoleData);

            return  $isRoleCreated;
        }

        /* $attributes['name'] = $attributes['name'];
        $attributes['slug'] = isSluggable($attributes['name']);
        $attributes['created_by'] = auth()->user()->id;
        $attributes['updated_by'] = auth()->user()->id;
        $attributes['mfi_id'] = auth()->user()?auth()->user()->mfi_id:NULL;
        $isBlogCreated = $this->create($attributes); */


    }

    public function updateRole($attributes, $id)
    {
        $roleData = $this->find($id);
        return $roleData->update([
            'name' => $attributes['name'],
            'description' => $attributes['description'],
            'updated_by' => auth()->user()->id,
        ]);

    }
    public function updateMfiRole($attributes, $id)
    {
        $roleMfiData = $this->mfiRoleModel->find($id);
        return $roleMfiData->update([
            'status' => $attributes['status'],
        ]);

    }
    public function createPermission($attributes)
    {
        return $this->permissionModel->create($attributes);
    }

    public function deleteRole($id)
    {
        $roleData = $this->model->find($id);
        //$branchData->media()->delete();
        return $roleData->delete();
    }
}
