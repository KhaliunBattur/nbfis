<?php
/**
 * Created by PhpStorm.
 * User: uugan
 * Date: 9/9/2017
 * Time: 3:24 PM
 */

namespace App\User\Bail_other;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class OtherRepository implements OtherRepositoryInterface
{

    private $model;

    /**
     * CarRepository constructor.
     * @param Car $model
     */
    public function __construct(Other $model)
    {
        $this->model=$model;
    }


    /**
     * @param $id
     * @return Collection|static[]
     */
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