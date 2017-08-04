<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/4/2017
 * Time: 12:39 PM
 */

namespace App\User;


use App\Core\Repository;
use Illuminate\Database\Eloquent\Collection;

interface RoleRepositoryInterface extends Repository
{

    /**
     * @return Collection
     */
    public function findAllWithPermissions();
}