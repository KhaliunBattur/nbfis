<?php
/**
 * Created by PhpStorm.
 * User: uugan
 * Date: 8/7/2017
 * Time: 2:57 PM
 */

namespace App\User\Contact;

use App\Core\Repository;
use Illuminate\Database\Eloquent\Collection;

interface ContactRepositoryInterface extends Repository
{

    /**
     * @param $id
     * @param $limit
     * @param $search
     * @return mixed
     */
    public function findByUserPaginate($id, $limit, $search = []);
}