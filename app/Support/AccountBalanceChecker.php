<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 9/18/2017
 * Time: 2:32 PM
 */

namespace App\Support;

class AccountBalanceChecker
{
    /**
     * @param $season_id
     * @param $account
     * @param $parameters
     * @return bool
     * @throws \Exception
     */
    public function can_transaction($season_id, $account, $parameters)
    {
        $account_balance = $account->present()->balance($season_id);

        if(!($parameters['amount'] > 0))
        {
            throw new \Exception("Үнийн дүн 0-с их байх ёстой", 403);
        }

        if($parameters['type'] == 'credit')
        {
            if($account->type == 'active')
            {
                if($account_balance >= ($account->currency->is_current == 1 ? ($parameters['amount'] * $parameters['exchange']) : $parameters['amount']))
                {
                    return true;
                }
                else
                {
                    throw new \Exception($account->name . '(' . $account->account_number . ')' . ' дансны үлдэгдэл хүрэхгүй байна', 403);
                }
            }
            else
            {
                return true;
            }
        }
        else
        {
            if($account->type == 'passive')
            {
                if($account_balance >= ($account->currency->is_current == 1 ? ($parameters['amount'] * $parameters['exchange']) : $parameters['amount']))
                {
                    return true;
                }
                else
                {
                    throw new \Exception($account->name . '(' . $account->account_number . ')' . ' дансанд илүү дүнгийн бичилт хийж болохгүй', 403);
                }
            }
            else
            {
                return true;
            }
        }
    }

}