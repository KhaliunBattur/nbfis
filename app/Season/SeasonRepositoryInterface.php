<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/22/2017
 * Time: 11:37 AM
 */

namespace App\Season;


use App\Core\Repository;

interface SeasonRepositoryInterface extends Repository
{

    /**
     * @return mixed
     */
    public function findLastClose();
}