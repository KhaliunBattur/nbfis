<?php
/**
 * Created by PhpStorm.
 * User: uugan
 * Date: 8/7/2017
 * Time: 3:06 PM
 */

namespace App\User\Family;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class FamilyRepository implements FamilyRepositoryInterface
{
    private $model;

    /**
     * FamilyRepository constructor.
     * @param Family $model
     */
    public function __construct(Family $model)
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
        // TODO: Implement findById() method.
    }

    /**
     * @param $howMany
     * @param array $params
     * @return LengthAwarePaginator
     */
    public function findByPaginate($howMany, $params = [])
    {
        // TODO: Implement findByPaginate() method.
    }

    /**
     * @param $value
     * @param $name
     * @param int $ignoreId
     * @return Collection
     */
    public function findByList($value, $name, $ignoreId = 0)
    {
        // TODO: Implement findByList() method.
    }
}