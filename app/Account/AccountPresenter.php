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
        $debit = 0;
        $credit = 0;

        if($this->entity->type == 'active')
        {
            $debit = $this->entity->transaction($season_key)->where('type', 'debit')->sum('amount');
            $credit = $this->entity->transaction($season_key)->where('type', 'credit')->sum('amount');
        }
        else
        {
            $debit = $this->entity->transaction($season_key)->where('type', 'credit')->sum('amount');
            $credit = $this->entity->transaction($season_key)->where('type', 'debit')->sum('amount');
        }
        return $this->entity->balance($season_key) + ($debit - $credit);
    }

}