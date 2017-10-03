<?php
/**
 * Created by PhpStorm.
 * User: uugan
 * Date: 9/29/2017
 * Time: 4:52 PM
 */

namespace App\User\Car;

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
        $this->model = $model;
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
        return $this->model->All();
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
       return $this->model->where('id','!=',$ignoreId)->pluck($name,$value);
    }
}