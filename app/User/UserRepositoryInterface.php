<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/2/2017
 * Time: 6:35 PM
 */

namespace App\User;


use App\Core\Repository;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface extends Repository
{

    /**
     * @param $id
     * @return User
     */
    public function findInfoById($id);

    /**
     * @return Collection
     */
    public function findByCustomerListRaw();
}