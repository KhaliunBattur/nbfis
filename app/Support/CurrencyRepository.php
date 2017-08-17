<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/16/2017
 * Time: 6:20 PM
 */

namespace App\Support;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class CurrencyRepository implements CurrencyRepositoryInterface
{
    /**
     * @var Currency
     */
    private $model;

    /**
     * CurrencyRepository constructor.
     * @param Currency $model
     */
    public function __construct(Currency $model)
    {
        $this->model = $model;
    }

    /**
     * @return Collection
     */
    public function findAll()
    {

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
     * @return mixed
     */
    public function search($get)
    {
        return $this->model
            ->where(function($query) use($get){
                $query->where('name', 'like', '%'. $get .'%');
            })->get();
    }
}