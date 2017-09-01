<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 9/1/2017
 * Time: 11:30 AM
 */

namespace App\Branch;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class BranchRepository implements BranchRepositoryInterface
{
    /**
     * @var Branch
     */
    private $model;

    /**
     * BranchRepository constructor.
     * @param Branch $model
     */
    public function __construct(Branch $model)
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
        return $this->model->where('id', '!=', $ignoreId)->pluck($value, $name);
    }

    /**
     * @return mixed
     */
    public function findByListRaw()
    {
        return $this->model->select('id', \DB::raw("CONCAT(code, ' ', name) as text"))->get();
    }
}