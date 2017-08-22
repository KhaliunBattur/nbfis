<?php
/**
 * Created by PhpStorm.
 * User: uugan
 * Date: 8/22/2017
 * Time: 12:04 PM
 */

namespace App\User\LoanRequest;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class RequestRepository implements RequestRepositoryInterface
{

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