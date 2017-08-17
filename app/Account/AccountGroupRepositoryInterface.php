<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/15/2017
 * Time: 2:30 PM
 */

namespace App\Account;


use App\Core\Repository;

interface AccountGroupRepositoryInterface extends Repository
{

    /**
     * @param $id
     * @param $search
     * @return mixed
     */
    public function findByListWhere($id, $search);

    /**
     * @return mixed
     */
    public function findParents();
}