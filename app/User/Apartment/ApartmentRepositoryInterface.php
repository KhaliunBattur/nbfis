<?php
/**
 * Created by PhpStorm.
 * User: uugan
 * Date: 9/29/2017
 * Time: 4:03 PM
 */

namespace App\User\Apartment;


use App\Core\Repository;
use Illuminate\Database\Eloquent\Collection;

interface ApartmentRepositoryInterface extends Repository
{
    /**
     * @param $id
     * @return mixed
     */
    public function findByUserAll($id);
}