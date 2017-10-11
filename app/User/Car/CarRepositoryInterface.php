<?php
/**
 * Created by PhpStorm.
 * User: uugan
 * Date: 9/29/2017
 * Time: 4:53 PM
 */

namespace App\User\Car;

use App\Core\Repository;
use Illuminate\Database\Eloquent\Collection;

interface CarRepositoryInterface extends Repository
{
    public function findByUserAll($id);
}