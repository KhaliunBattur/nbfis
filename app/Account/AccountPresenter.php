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
        return $this->entity->balance($season_key);
    }

}