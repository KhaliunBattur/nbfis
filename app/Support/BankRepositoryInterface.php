<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/17/2017
 * Time: 10:26 AM
 */

namespace App\Support;


use App\Core\Repository;
use Illuminate\Database\Eloquent\Collection;

interface BankRepositoryInterface extends Repository
{

    /**
     * @param $get
     * @return Collection
     */
    public function search($get);
}