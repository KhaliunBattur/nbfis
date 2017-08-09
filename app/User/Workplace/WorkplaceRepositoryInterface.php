<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/7/2017
 * Time: 3:37 PM
 */

namespace App\User\Workplace;


use App\Core\Repository;
use Illuminate\Database\Eloquent\Collection;

interface WorkplaceRepositoryInterface extends Repository
{


    /**
     * @param $id
     * @param $limit
     * @param $search
     * @return Collection
     */
    public function findByUserPaginate($id, $limit, $search = []);
}