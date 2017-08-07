<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/7/2017
 * Time: 3:38 PM
 */

namespace App\User\Workplace;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class WorkplaceRepository implements WorkplaceRepositoryInterface
{
    /**
     * @var Workplace
     */
    private $model;

    /**
     * WorkplaceRepository constructor.
     * @param Workplace $model
     */
    public function __construct(Workplace $model)
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
}