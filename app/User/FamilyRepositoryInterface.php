<?php
/**
 * Created by PhpStorm.
 * User: uugan
 * Date: 8/7/2017
 * Time: 3:06 PM
 */

namespace App\User;

use Illuminate\Database\Eloquent\Collection;
use App\Core\Repository;

interface FamilyRepositoryInterface extends Repository
{
    /**
     * @param $user_id
     * @return mixed
     */
    public function findByUserId($user_id);
}