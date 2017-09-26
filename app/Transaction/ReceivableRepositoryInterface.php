<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 9/25/2017
 * Time: 4:57 PM
 */

namespace App\Transaction;


use App\Core\Repository;
use Illuminate\Database\Eloquent\Collection;

interface ReceivableRepositoryInterface extends Repository
{

    /**
     * @return Collection
     */
    public function findOpen();
}