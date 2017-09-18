<?php
/**
 * Created by PhpStorm.
 * User: uugan
 * Date: 9/9/2017
 * Time: 3:24 PM
 */

namespace App\User\Bail_other;
use App\Core\Repository;
use illuminate\Database\Eloquent\Collection;


interface OtherRepositoryInterface extends Repository
{
    public function findByUserAll($id);
}