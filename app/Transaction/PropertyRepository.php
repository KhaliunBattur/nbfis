<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 10/10/2017
 * Time: 10:27 AM
 */

namespace App\Transaction;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class PropertyRepository implements PropertyRepositoryInterface
{

    /**
     * @var Property
     */
    private $model;

    /**
     * PropertyRepository constructor.
     * @param Property $model
     */
    public function __construct(Property $model)
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