<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/16/2017
 * Time: 6:20 PM
 */

namespace App\Support;


use App\Core\Repository;

interface CurrencyRepositoryInterface extends Repository
{

    /**
     * @param $get
     * @return mixed
     */
    public function search($get);

    /**
     * @param $id
     * @return mixed
     */
    public function notIn($id);
}