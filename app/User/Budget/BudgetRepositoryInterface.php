<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/10/2017
 * Time: 4:03 PM
 */

namespace App\User\Budget;


use App\Core\Repository;
use Illuminate\Database\Eloquent\Collection;

interface BudgetRepositoryInterface extends Repository
{

    /**
     * @param $id
     * @return Collection
     */
    public function findByUserAll($id);
}