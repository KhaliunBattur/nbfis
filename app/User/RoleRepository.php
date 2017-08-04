<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/4/2017
 * Time: 12:39 PM
 */

namespace App\User;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class RoleRepository implements RoleRepositoryInterface
{
    /**
     * @var Role
     */
    private $model;

    /**
     * RoleRepository constructor.
     * @param Role $model
     */
    public function __construct(Role $model)
    {

        $this->model = $model;
    }

    /**
     * @return Collection
     */
    public function findAll()
    {
        return $this->model->all();
    }

    /**
     * @param $id
     * @return Model
     */
    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param $howMany
     * @param array $params
     * @return LengthAwarePaginator
     */
    public function findByPaginate($howMany, $params = [])
    {
        return $this->model->paginate($howMany);
    }

    /**
     * @param $value
     * @param $name
     * @param int $ignoreId
     * @return Collection
     */
    public function findByList($value, $name, $ignoreId = 0)
    {
        return $this->model->where('id', '!=', $ignoreId)->pluck($name, $value);
    }

    /**
     * @return Collection
     */
    public function findAllWithPermissions()
    {
        return $this->model->with('perms')->get();
    }
}