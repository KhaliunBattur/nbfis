<?php
/**
 * Created by PhpStorm.
 * User: uugan
 * Date: 9/9/2017
 * Time: 3:24 PM
 */

namespace App\User\Other;

use App\Core\Repository;
use Illuminate\Database\Eloquent\Collection;


interface OtherRepositoryInterface extends Repository
{
    /**
     * @param $id
     * @return mixed
     */
    public function findByUserAll($id);
}