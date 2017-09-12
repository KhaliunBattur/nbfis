<?php
/**
 * Created by PhpStorm.
 * User: uugan
 * Date: 9/9/2017
 * Time: 2:30 PM
 */

namespace App\User\Bail_car;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class CarRepository implements CarRepositoryInterface
{

    private $model;

    /**
     * CarRepository constructor.
     * @param Car $model
     */
    public function __construct(Car $model)
    {
        $this->model=$model;
    }


    public function findByUserAll($id)
    {
        return $this->model->where('user_id',$id)->get();
    }

    /**
     * @return Collection
     */
    public function findAll()
    {
        // TODO: Implement findAll() method.
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