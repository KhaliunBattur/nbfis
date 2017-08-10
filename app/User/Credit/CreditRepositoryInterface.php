<?php
/**
 * Created by PhpStorm.
 * User: uugan
 * Date: 8/7/2017
 * Time: 3:05 PM
 */

namespace App\User\Credit;

use Illuminate\Database\Eloquent\Collection;
use App\Core\Repository;

interface CreditRepositoryInterface extends Repository
{
    /**
     * @param $id
     * @param $limit
     * @param array $search
     * @return mixed
     */
    public function findByUserPaginate($id, $limit, $search=[]);
}