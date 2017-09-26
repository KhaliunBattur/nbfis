<?php
/**
 * Created by PhpStorm.
 * User: uugan
 * Date: 9/9/2017
 * Time: 2:31 PM
 */

namespace App\User\Car;

use App\Core\Repository;
use illuminate\Database\Eloquent\Collection;

interface CarRepositoryInterface extends Repository
{
    public function findByUserAll($id);
}