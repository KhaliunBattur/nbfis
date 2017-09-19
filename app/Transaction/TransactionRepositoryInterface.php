<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/29/2017
 * Time: 5:22 PM
 */

namespace App\Transaction;


use App\Core\Repository;

interface TransactionRepositoryInterface extends Repository
{

    /**
     * @param $transaction_date
     * @return mixed
     */
    public function getTransactionNumber($transaction_date);

    /**
     * @param $id
     * @return mixed
     */
    public function findByNumber($id);
}