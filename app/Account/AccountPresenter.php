<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/23/2017
 * Time: 10:56 AM
 */

namespace App\Account;


use Laracasts\Presenter\Presenter;

class AccountPresenter extends Presenter
{

    public function balance($season_key)
    {
        $balance = 0;

        $debit = $this->entity->transaction($season_key)->where('type', 'debit')->sum('amount');
        $credit = $this->entity->transaction($season_key)->where('type', 'credit')->sum('amount');

        if($this->entity->type == 'active')
        {
            $balance = $debit - $credit;
        }
        else
        {
            $balance = $credit - $debit;
        }
        return $this->entity->balance($season_key) + $balance;
    }

}