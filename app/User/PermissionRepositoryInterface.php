<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/4/2017
 * Time: 2:43 PM
 */

namespace App\User;


use App\Core\Repository;
use Illuminate\Database\Eloquent\Collection;

interface PermissionRepositoryInterface extends Repository
{

    /**
     * @param $role_id
     * @param $search
     * @return Collection
     */
    public function search($role_id, $search);
}