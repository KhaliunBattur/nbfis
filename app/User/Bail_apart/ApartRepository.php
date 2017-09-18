<?php
/**
 * Created by PhpStorm.
 * User: uugan
 * Date: 9/8/2017
 * Time: 5:07 PM
 */

namespace App\User\Bail_apart;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
class ApartRepository implements ApartRepositoryInterface
{

    private $model;

    /**
     * ApartRepository constructor.
     * @param Apartment $model
     */
    public function __construct(Apartment $model)
    {
        $this->model=$model;
    }

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

    }

    /**
     * @param $howMany
     * @param array $params
     * @return LengthAwarePaginator
     */
    public function findByPaginate($howMany, $params = [])
    {

    }

    /**
     * @param $value
     * @param $name
     * @param int $ignoreId
     * @return Collection
     */
    public function findByList($value, $name, $ignoreId = 0)
    {

    }

    public function findByUserAll($id)
    {
      return $this->model->where('user_id',$id)->get();
    }
}