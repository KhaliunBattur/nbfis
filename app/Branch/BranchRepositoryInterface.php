<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 9/1/2017
 * Time: 11:30 AM
 */

namespace App\Branch;


use App\Core\Repository;

interface BranchRepositoryInterface extends Repository
{

    /**
     * @return mixed
     */
    public function findByListRaw();
}