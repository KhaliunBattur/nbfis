<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 9/18/2017
 * Time: 2:32 PM
 */

namespace App\Support;


use App\Account\Account;

class AccountBalanceChecker
{
    public function __construct()
    {

    }

    /**
     * @param int $season_id
     * @param Account $account
     * @param Account $to_account
     * @param double $amount
     * @param string $type
     * @param $exchange
     * @param $to_exchange
     * @return bool
     */
    public function can_transaction($season_id, $account, $to_account, $amount, $type, $exchange, $to_exchange)
    {
        $account_balance = $account->present()->balance($season_id);

        $to_account_balance = $to_account->present()->balance($season_id);

        if($type == 'credit')
        {
            return $account_balance >= ($account->currency->is_current == 1 ? $amount * $exchange : $amount);
        }
        else
        {
            return $to_account_balance >= ($to_account->currency->is_current == 1 ? $amount * $exchange : $amount);
        }
    }

}