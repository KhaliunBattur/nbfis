<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/16/2017
 * Time: 10:54 AM
 */

namespace App\Account;


use App\Core\Repository;
use Illuminate\Database\Eloquent\Collection;

interface AccountRepositoryInterface extends Repository
{

    /**
     * @return Collection
     */
    public function findAllIdList();
}