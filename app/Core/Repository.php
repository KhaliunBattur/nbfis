<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/2/2017
 * Time: 6:36 PM
 */

namespace App\Core;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface Repository
{

    /**
     * @return Collection
     */
    public function findAll();

    /**
     * @param $id
     * @return Model
     */
    public function findById($id);

    /**
     * @param $howMany
     * @param array $params
     * @return LengthAwarePaginator
     */
    public function findByPaginate($howMany, $params = []);

    /**
     * @param $value
     * @param $name
     * @param int $ignoreId
     * @return Collection
     */
    public function findByList($value, $name, $ignoreId = 0);

}