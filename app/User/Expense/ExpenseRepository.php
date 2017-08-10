<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/10/2017
 * Time: 4:03 PM
 */

namespace App\User\Expense;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class ExpenseRepository implements ExpenseRepositoryInterface
{
    /**
     * @var Budget
     */
    private $model;

    /**
     * ExpenseRepository constructor.
     * @param Expense $model
     */
    public function __construct(Expense $model)
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
    public function findByUserAll($id)
    {
        return $this->model->where('user_id', $id)->get();
    }
}