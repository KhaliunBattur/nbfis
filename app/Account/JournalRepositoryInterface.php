<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/17/2017
 * Time: 10:06 AM
 */

namespace App\Account;


use App\Core\Repository;
use Illuminate\Database\Eloquent\Collection;

interface JournalRepositoryInterface extends Repository
{

    /**
     * @param $get
     * @param int $ignore
     * @return Collection
     */
    public function search($get, $ignore = 0);

    /**
     * @return Collection
     */
    public function findWithAccounts();

    /**
     * @return Collection
     */
    public function rootLists();
}