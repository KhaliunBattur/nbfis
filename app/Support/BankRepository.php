<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/17/2017
 * Time: 10:26 AM
 */

namespace App\Support;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class BankRepository implements BankRepositoryInterface
{
    /**
     * @var Bank
     */
    private $model;

    /**
     * BankRepository constructor.
     * @param Bank $model
     */
    public function __construct(Bank $model)
    {

        $this->model = $model;
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

    /**
     * @param $get
     * @return Collection
     */
    public function search($get)
    {
        return $this->model
            ->where(function($query) use($get){
                $query->where('name', 'like', '%'. $get .'%');
            })->get();
    }
}