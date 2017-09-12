<?php
/**
 * Created by PhpStorm.
 * User: uugan
 * Date: 9/8/2017
 * Time: 5:08 PM
 */

namespace App\User\Bail_apart;

use App\Core\Repository;
use illuminate\Database\Eloquent\Collection;

interface ApartRepositoryInterface extends Repository
{
    public function findByUserAll($id);
}